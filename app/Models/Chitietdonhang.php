<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chitietdonhang extends Model
{
    protected $table = 'Chitietdonhang';
    public $timestamps = false;

    protected $fillable = [
        'donhang_id',
        'sanpham_id',
        'soluong',
        'giagoc'
    ];

    public function donhang()
    {
        return $this->belongsTo(Donhang::class, 'donhang_id');
    }

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sanpham_id');
    }
}