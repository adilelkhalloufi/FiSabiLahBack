<?php

namespace App\Console\Commands;

use App\Models\ScheduledPost;
use App\Services\SocialMediaPublisher;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish';
    protected $description = 'Publish scheduled posts that are due';

    public function handle(SocialMediaPublisher $publisher)
    {
        $this->info('Starting to process scheduled posts...');
        
        $posts = ScheduledPost::where('status', 'pending')
            ->where('scheduled_at', '<=', Carbon::now())
            ->get();
            
        $this->info("Found {$posts->count()} posts to publish");
        
        foreach ($posts as $post) {
            $this->info("Publishing post ID: {$post->id} to {$post->socialAccount->platform}");
            
            try {
                // Mark as processing to prevent duplicate processing
                $post->update(['status' => 'processing']);
                
                $result = $publisher->publish($post);
                
                if ($result) {
                    $this->info("Successfully published post ID: {$post->id}");
                } else {
                    $this->error("Failed to publish post ID: {$post->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error publishing post ID: {$post->id} - {$e->getMessage()}");
                
                // Update status to failed
                $post->update([
                    'status' => 'failed',
                    'platform_response' => ['error' => $e->getMessage()]
                ]);
            }
        }
        
        $this->info('Finished processing scheduled posts');
        
        return 0;
    }
}
