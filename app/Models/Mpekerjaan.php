<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Mpekerjaan extends Model
{
    use HasFactory;
    protected $table      = "master_pekerjaan";
    protected $appends    = ['hashid'];
    protected $hidden     = ['id'];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
}
