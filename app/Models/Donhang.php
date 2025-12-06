<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donhang extends Model
{
    protected $table = 'Donhang';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'ngaydathang',
        'trangthai',
        'tongtien',
        'diachi_id',
        'phuongthucthanhtoan',
        'ghichu'
    ];

    protected $casts = [
        'ngaydathang' => 'datetime',
    ];

    public function chitietdonhangs()
    {
        return $this->hasMany(Chitietdonhang::class, 'donhang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
