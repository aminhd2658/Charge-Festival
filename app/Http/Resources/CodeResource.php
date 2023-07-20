<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount_in_human' => number_format($this->amount),
            'amount' => $this->amount,
            'code' => $this->code,
            'count' => $this->count
        ];
    }
}
