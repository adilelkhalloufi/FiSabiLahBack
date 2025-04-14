<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        // Add other fields as needed
    ];
    
    /**
     * Get the videos for the subject.
     */
    public function videos()
    {
        return $this->hasMany(Videos::class);
    }
}
