<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    public function create(CreatePatientRequest $request) {
        if (Auth::user()->cannot('createPatient', new Patient())) {
            abort(Response::HTTP_FORBIDDEN, 'FORBIDDEN');
        }

        $patient = Patient::create($request->validated());

        return PatientResource::make($patient);
    }
}
