<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loaisp extends Model
{
    protected $table = 'Loaisp';
    protected $timestamps = false;
    protected $fillable = ['tenloai', 'slug', 'parent_id', 'mota_loaisp'];

    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_loaisp');
    }

    public function children()
    {
        return $this->hasMany(Loaisp::class, 'parent_id');
    }
}
