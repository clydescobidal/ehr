<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasUlids;

    protected string $ULID_PREFIX = 'pnt_';

    protected $keyType = 'string';

    public $incrementing = false;  

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'occupation',
        'religion',
        'contact_number'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];
}
