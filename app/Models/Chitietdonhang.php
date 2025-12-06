<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chitietdonhang extends Model
{
    protected $table = 'Chitietdonhang';
    public $timestamps = false;

    protected $fillable = [
        'donhang_id',
        'bienthe_id',
        'soluong',
        'giagoc'
    ];

    public function donhang()
    {
        return $this->belongsTo(Donhang::class, 'donhang_id');
    }

    public function bienthe()
    {
        return $this->belongsTo(Bienthe::class, 'bienthe_id');
    }
}
