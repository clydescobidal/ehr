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
        if (Auth::user()->cannot('createPatient', new Patient())) {
            abort(Response::HTTP_FORBIDDEN, 'FORBIDDEN');
        }

        $patient = Patient::create($request->validated());

        return PatientResource::make($patient);
    }

    public function search(SearchPatientRequest $request) {
        if (Auth::user()->cannot('createPatient', new Patient())) {
            abort(Response::HTTP_FORBIDDEN, 'FORBIDDEN');
        }

        $patients = Patient::search($request->input('q'))->get();

        return PatientsSearchCollection::make($patients);
    }
}
