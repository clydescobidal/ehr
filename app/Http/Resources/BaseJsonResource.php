<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class BaseJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function format(array $data): array
    {
        return [
            'status' => [
                'error' => false,
                'message' => $this->resource->message ?? null,
                'code' => Response::HTTP_OK,
            ],
            'data' => $data,
        ];
    }
}
