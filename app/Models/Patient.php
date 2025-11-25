<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Patient extends Model
{
    use HasUlids, Searchable, SoftDeletes;

    protected string $ULID_PREFIX = 'pnt_';

    protected $keyType = 'string';

    public $incrementing = false;  

    protected $fillable = [
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
    ];

    protected $casts = [
        'address_line_1' => 'encrypted',
        'address_line_2' => 'encrypted',
        'contact_number' => 'encrypted',
    ];

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return tenant('id').'_patients_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
