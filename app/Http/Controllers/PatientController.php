<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\SearchPatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientsSearchCollection;
use App\Models\Patient;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    public function create(CreatePatientRequest $request) {
        $patient = Patient::create($request->validated());

        return PatientResource::make($patient);
    }

    public function search(SearchPatientRequest $request) {
        $patients = Patient::search($request->input('q'))->options([
            'num_typos' => 0,
            'limit_hits' => 10
        ])->raw();

        return PatientsSearchCollection::make($patients);
    }
}
