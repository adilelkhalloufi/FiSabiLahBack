<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'user_id',
        'social_account_id',
        'title',
        'caption',
        'hashtags',
        'scheduled_at',
        'status',
        'platform_post_id',
        'platform_response',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'platform_response' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function socialAccount(): BelongsTo
    {
        return $this->belongsTo(SocialAccount::class);
    }
}
