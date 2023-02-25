<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;


class Mkaryawan extends Model
{
    use HasFactory;
    protected $table      = "karyawan";
    protected $appends    = ['hashid'];
    protected $hidden     = ['id'];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
    public function onePinjaman (){

        return $this->hasOne('App\Models\kasbon\MdataPinjaman','id_karyawan','id')->where('jenis','Bayar Langsung')->latest();
    
    }
    
}
