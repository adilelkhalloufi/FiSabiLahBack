<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'videos';

    public const COL_ID = 'id';
    public const COL_URL = 'url';
    public const COL_PLATFORM = 'platform';
    public const COL_DESCRIPTION = 'description';
    public const COL_CHIKHI_ID = 'chikhi_id';
    public const COL_SUBJECT_ID = 'subject_id';

    /**
     * Get the chikhi that owns the video.
     * Added as an alias to chikhis() for consistent naming.
     */
    public function chikhi()
    {
        return $this->belongsTo(Chikhis::class, self::COL_CHIKHI_ID, Chikhis::COL_ID);
    }

    /**
     * Get the subjects associated with the video.
     */
    public function subjects()
    {
        return $this->belongsTo(Subjects::class, self::COL_SUBJECT_ID, Subjects::COL_ID);
    }

    /**
     * Get the subject that owns the video.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
