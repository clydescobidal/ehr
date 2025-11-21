<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TenantResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::format(parent::toArray($request));
    }
}
