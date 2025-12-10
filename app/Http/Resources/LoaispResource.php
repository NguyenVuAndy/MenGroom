<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoaispResource extends JsonResource
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
            'tenloaisp' => $this->tenloaisp,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'mota_loaisp' => $this->mota_loaisp,
            'thoigiantao' => $this->thoigiantao,
            'thoigiancapnhat' => $this->thoigiancapnhat,
        ];
    }
}
