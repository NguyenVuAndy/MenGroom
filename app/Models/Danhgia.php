<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Danhgia extends Model
{
    protected $table = 'Danhgia';

    // Cấu hình timestamp tùy chỉnh
    public $timestamps = true;
    const CREATED_AT = 'thoigiandanhgia';
    const UPDATED_AT = null; // Không có cột cập nhật

    protected $fillable = [
        'user_id',
        'sanpham_id',
        'danhgia',
        'binhluan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sanpham_id');
    }
}
