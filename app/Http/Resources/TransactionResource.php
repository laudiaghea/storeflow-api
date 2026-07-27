<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'total' => $this->total,

            'customer' => [
                'id' => $this->customer?->id,
                'nama' => $this->customer?->nama,
            ],

            'items' => TransactionDetailResource::collection($this->transactionDetails),

            'created_at' => $this->created_at
        ];
    }
}
