<?php

namespace App\Models\kasbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class MdataPinjaman extends Model
{
    use HasFactory;
    protected $table = "pinjaman";
    protected $appends    = ['hashid'];
    protected $hidden     = ['id'];

    public function getHashidAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
}
