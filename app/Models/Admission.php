<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasUlids, SoftDeletes;

    protected string $ULID_PREFIX = 'adm_';

    protected $fillable = [
        'patient_id',
        'admitted_by',
        'discharged_at',
        'discharge_status',
        'diagnosis'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $keyType = 'string';

    public $incrementing = false;  
}
