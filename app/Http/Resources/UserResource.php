<?php

namespace App\Http\Resources;

use Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();
        $tenants = Arr::pull($data, 'tenants');
        $data['tenants'] = [];
        foreach($tenants as $tenant) {
            $data['tenants'][] = [
                ...$tenant['tenant'],
                'roles' => Arr::pluck($tenant['roles'], 'name')
            ];
        }
     
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
