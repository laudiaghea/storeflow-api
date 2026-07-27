<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'nama_prodk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'category' => [
                'id' => $this->category?->id,
                'nama_kategori' => $this->category?->nama_kategori
            ],
        ];
    }
}
