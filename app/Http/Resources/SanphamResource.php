<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SanphamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tensp' => $this->tensp,
            'slug' => $this->slug,
            'gia' => $this->gia,
            'giakhuyenmai' => $this->giakhuyenmai,
            'sku' => $this->sku,
            'chitietsp' => $this->chitietsp,
            'hdsd' => $this->hdsd,
            'thanhphansp' => $this->thanhphansp,
            'trangthaihienthi' => $this->trangthaihienthi,
            'soluongtonkho' => $this->soluongtonkho,
            'thoigiantao' => $this->thoigiantao,
            'thoigiancapnhat' => $this->thoigiancapnhat,
            'image_url' => $this->image_url,
            'soluong' => $this->when(isset($this->soluong), $this->soluong),
            'thuonghieu' => new ThuonghieuResource($this->whenLoaded('thuonghieu')),
            'thuonghieu_id' => $this->id_thuonghieu,
            'loaisp' => new LoaispResource($this->whenLoaded('loaisp')),
            'loaisp_id' => $this->id_loaisp,
        ];
    }
}
