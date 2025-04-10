<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{ 

   public const TABLE_NAME = 'videos';

    public const COL_ID = 'id';
    public const COL_URL = 'url';
    public const COL_PLATFORM = 'platform';
    public const COL_DESCRIPTION = 'description';
    public const COL_CHIKHI_ID = 'chikhi_id';
    public const COL_SUBJECT_ID = 'subject_id';
 

    public function chikhis()
    {
        return $this->belongsTo(Chikhis::class, self::COL_CHIKHI_ID, Chikhis::COL_ID);
    }

    public function subjects()
    {
        return $this->belongsTo(Subjects::class, self::COL_SUBJECT_ID, Subjects::COL_ID);
    }



    //
}
