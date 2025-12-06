<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bienthe extends Model
{
    protected $table = 'Bienthe';
    public $timestamps = false;

    protected $fillable = [
        'id_sp',
        'ten',
        'sku',
        'gia',
        'giakhuyenmai',
        'soluongtonkho',
        'hinhanh_1',
        'thuoc_tinh_1',
        'giatri_1',
        'thuoc_tinh_2',
        'giatri_2'
    ];

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sp');
    }
}
