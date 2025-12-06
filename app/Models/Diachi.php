<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diachi extends Model
{
    protected $table = 'Diachi';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tennguoinhan',
        'sodienthoai',
        'diachichitiet',
        'phuong_xa',
        'quan_huyen',
        'tinh_thanhpho',
        'diachimacdinh'
    ];

    protected $casts = [
        'diachimacdinh' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donhangs()
    {
        return $this->hasMany(Donhang::class, 'diachi_id');
    }
}
