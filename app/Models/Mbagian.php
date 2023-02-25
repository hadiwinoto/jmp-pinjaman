<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Mbagian extends Model
{
  
    use HasFactory;
    protected $table      = "master_bagian";
    protected $appends    = ['hashid'];
    protected $hidden     = ['id'];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
}
