<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThuonghieuResource extends JsonResource
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
            'tenthuonghieu' => $this->tenthuonghieu,
            'mota_thuonghieu' => $this->mota_thuonghieu,
            'logo_url' => $this->logo_url,
        ];
    }
}
