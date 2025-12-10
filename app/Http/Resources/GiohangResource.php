<?php

namespace App\Http\Resources;

use App\Helper\GiohangHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Sanpham;

class GiohangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$sanphams, $giohang] = $this->resource;
        return [
            'soluong' => GiohangHelper::getCount(),
            'tongcong' => $sanphams->reduce(fn(?float $carry, Sanpham $sanpham) => $carry + $sanpham->gia * $giohang[$sanpham->id]['soluong']),
            'items' => $giohang,
            'sanphams' => SanphamResource::collection($sanphams),
        ];
    }
}
