<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Loaisp extends Model
{
    use HasSlug;
    protected $table = 'Loaisp';
    public $timestamps = false;
    protected $fillable = ['tenloai', 'slug', 'parent_id', 'mota_loaisp'];

    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_loaisp');
    }

    public function children()
    {
        return $this->hasMany(Loaisp::class, 'parent_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('tenloai')
            ->saveSlugsTo('slug');
    }
}
