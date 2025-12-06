<?php

namespace App\Http\Controllers;

use App\Enums\AdmissionStatus;
use App\Http\Requests\CreateAdmissionRequest;
use App\Http\Requests\ListAdmissionsRequest;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\AdmissionsListCollection;
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

    public function list(ListAdmissionsRequest $request){
        $admissions = Admission::latest();
        $status = strtoupper($request->input('status'));
        
        switch ($status) {
            case AdmissionStatus::ACTIVE->value:
                $admissions = $admissions->whereNull('discharged_at');
                break;
            case AdmissionStatus::DISCHARGED->value:
                $admissions = $admissions->whereNotNull('discharged_at');
                break;
        }

        return AdmissionsListCollection::make($admissions->get());
    }
}
