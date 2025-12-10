<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Giohang extends Model
{
    protected $table = 'Giohang';

    const CREATED_AT = 'ngaytao';
    const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'user_id',
        'sanpham_id',
        'soluong'
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
