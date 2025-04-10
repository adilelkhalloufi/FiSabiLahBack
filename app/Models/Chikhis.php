<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chikhis extends Model
{ 

   public const TABLE_NAME = 'chikhis';

    public const COL_ID = 'id';
    public const COL_NAME = 'name';
    public const COL_DESCRIPTION = 'description';
    public const COL_IMAGE = 'image';
 


    public function videos()
    {
        return $this->hasMany(Videos::class, Videos::COL_CHIKHI_ID, self::COL_ID);
    }
  


 
}
