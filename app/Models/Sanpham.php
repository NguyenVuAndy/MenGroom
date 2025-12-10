<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Sanpham extends Model
{
    use HasSlug;

    protected $table = 'Sanpham';
    const CREATED_AT = 'thoigiantao';
    const UPDATED_AT = 'thoigiancapnhat';

    protected $fillable = [
        'tensp',
        'slug',
        'sku',
        'image_url',
        'gia',
        'giakhuyenmai',
        'soluongtonkho',
        'chitietsp',
        'hdsd',
        'thanhphansp',
        'id_loaisp',
        'id_thuonghieu',
        'trangthaihienthi'
    ];

    public function loaisp()
    {
        return $this->belongsTo(Loaisp::class, 'id_loaisp');
    }

    public function thuonghieu()
    {
        return $this->belongsTo(Thuonghieu::class, 'id_thuonghieu');
    }

    public function danhgias()
    {
        return $this->hasMany(Danhgia::class, 'sanpham_id');
    }

    public function chitietdonhangs()
    {
        return $this->hasMany(Chitietdonhang::class, 'sanpham_id');
    }

    public function giohangs()
    {
        return $this->hasMany(Giohang::class, 'sanpham_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('tensp')
            ->saveSlugsTo('slug');
    }
}