<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    protected $table = 'Sanpham';
    const CREATED_AT = 'thoigiantao';
    const UPDATED_AT = 'thoigiancapnhat';

    protected $fillable = [
        'tensp',
        'mota_chinh',
        'hdsu',
        'mota_ct',
        'id_loaisp',
        'id_thuonghieu'
    ];

    public function loaisp()
    {
        return $this->belongsTo(Loaisp::class, 'id_loaisp');
    }

    public function thuonghieu()
    {
        return $this->belongsTo(Thuonghieu::class, 'id_thuonghieu');
    }

    public function bienthes()
    {
        return $this->hasMany(Bienthe::class, 'id_sp');
    }

    public function danhgias()
    {
        return $this->hasMany(Danhgia::class, 'sanpham_id');
    }
}
