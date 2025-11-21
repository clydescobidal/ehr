<?php

namespace App\Http\Resources;

use Arr;
use Illuminate\Http\Request;

class UserResource extends BaseJsonResource
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


        return parent::format($data);
    }
}
