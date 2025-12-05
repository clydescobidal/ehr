<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdmissionRequest;
use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class AdmissionController extends Controller
{
    public function create(CreateAdmissionRequest $request) {
        $activeAdmission = Admission::where('patient_id', $request->input('patient_id'))->whereNull('discharged_at')->exists();
        if ($activeAdmission) {
            abort(Response::HTTP_CONFLICT, 'PATIENT_ADMITTED');
        }

        $admission = Admission::create([
            'admitted_by' => Auth::user()->id,
            ...$request->validated()
        ]);

        return AdmissionResource::make($admission);
    }

    public function list(){
        
    }
}
