<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseJsonResource extends JsonResource
{
    public function toArray(Request $request) {
        return $this->format(parent::toArray($request));
    }

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
