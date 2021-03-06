<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientCreateRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Models\Location;
use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    public function table()
    {
        $patients = Patient::orderBy('created_at', 'desc')->with('location')->get();
        return response()->json($patients, Response::HTTP_OK);
    }

    public function store(PatientCreateRequest $request)
    {
        try {
            $inputs = $request->validated();
            $location = Location::create([
                'city' => $inputs['city'],
                'address' => $inputs['address']
            ]);
            $inputs['location_id'] = $location->id;
            $patient = Patient::create($inputs);
            return response()->json($patient, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(PatientUpdateRequest $request, $id)
    {
        try {
            $inputs = $request->validated();
            $patient = Patient::findOrFail($id);
            $location = Location::findOrFail($patient->location_id);
            $location->update([
                'city' => $inputs['city'],
                'address' => $inputs['address']
            ]);
            $patient = $patient->update($inputs);
            return response()->json($patient, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return response()->json($patient, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
