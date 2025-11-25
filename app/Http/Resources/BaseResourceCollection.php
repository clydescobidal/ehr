<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->format($this->collection);
    }

    public function format(Collection $collection) {
        return [
            'status' => [
                'error' => false,
                'message' => null,
                'code' => Response::HTTP_OK,
            ],
            'data' => $collection,
        ];
    }
}
