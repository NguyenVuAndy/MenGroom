<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thuonghieu extends Model
{
    protected $table = 'Thuonghieu';
    protected $timestamps = false;
    protected $fillable = ['tenthunghieu', 'logo_url', 'mota_thuonghieu'];

    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_thuonghieu');
    }
}
