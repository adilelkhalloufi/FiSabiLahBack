<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{ 

   public const TABLE_NAME = 'subjects';

    public const COL_ID = 'id';
    public const COL_NAME = 'name';
    public const COL_DESCRIPTION = 'description';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';

    public function videos()
    {
        return $this->hasMany(Videos::class, Videos::COL_SUBJECT_ID, self::COL_ID);
    }

    //
}
