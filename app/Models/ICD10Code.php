<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ICD10Code extends Model
{
    use Searchable;

    protected $table = 'icd_codes';

    protected $keyType = 'string';
    
    protected $fillable = [
        'code',
        'description'
    ];

    public $timestamps = false;

    protected $primaryKey = 'code';

    public function searchableAs(): string
    {
        return tenant('id').'_icd_codes_index';
    }

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }
}
