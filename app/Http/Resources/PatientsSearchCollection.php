<?php

namespace App\Http\Resources;

use Arr;
use Illuminate\Http\Request;

class PatientsSearchCollection extends BaseResourceCollection
{
    public function toArray(Request $request): array
    {
        $hits = $this->collection->get('hits');
        $data = collect($hits)->map(function($resource) {
            return Arr::only($resource['document'], ['id', 'first_name', 'middle_name', 'last_name']);
        });

        return parent::format($data);
    }
}
