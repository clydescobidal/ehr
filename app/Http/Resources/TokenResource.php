<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TokenResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'token_type' => 'Bearer',
            'access_token' => $this->resource
        ];

        return parent::format($data);
    }
}
