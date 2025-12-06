<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'User'; // Tên bảng trong DB

    const CREATED_AT = 'thoigiantao';
    const UPDATED_AT = 'thoigiancapnhat';

    protected $fillable = [
        'hoten',
        'sdt',
        'email',
        'pass_hash',
        'vaitro'
    ];

    protected $hidden = [
        'pass_hash',
    ];

    public function getAuthPassword()
    {
        return $this->pass_hash;
    }

    public function donhangs()
    {
        return $this->hasMany(Donhang::class, 'user_id');
    }

    public function diachis()
    {
        return $this->hasMany(Diachi::class, 'user_id');
    }
}
