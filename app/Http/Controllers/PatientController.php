<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    public function table()
    {
        $patients = Patient::with('location')->get();
        return response()->json($patients, Response::HTTP_OK);
    }

    public function destroy($id){

        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return response()->json($patient, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
