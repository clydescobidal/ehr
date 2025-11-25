<?php

namespace App\Http\Resources;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsSearchCollection extends BaseResourceCollection
{
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function(Patient $resource) {
            return $resource->only([
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'birth_date',
                'birth_place',
                'address_line_1',
                'address_line_2',
                'address_barangay',
                'address_city',
                'address_province',
                'address_postal_code',
                'occupation',
                'religion',
                'contact_number'
            ]);
        });

        return parent::format($data);
    }
}
