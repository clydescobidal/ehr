<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => [
                'error' => false,
                'message' => $this->resource->message ?? null,
                'code' => Response::HTTP_OK,
            ],
            'data' => parent::toArray($request),
        ];
    }
}
