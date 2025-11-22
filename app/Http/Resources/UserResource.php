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
        $tenantUsers = Arr::pull($data, 'tenant_users');
        $data['tenants'] = [];

        foreach($tenantUsers as $tenantUser) {
            $data['tenants'][] = [
                ...$tenantUser['tenant'],
                'roles' => Arr::pluck($tenantUser['roles'], 'name')
            ];
        }

        return parent::format($data);
    }
}
