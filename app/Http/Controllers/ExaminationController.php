<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{
    public function table()
    {
        $user = Auth::user();
        $doctors = Examination::with('patient', 'doctor')
            // ->where('doctor_id', $user->id)
             ->get();
        return response()->json($doctors, Response::HTTP_OK);
    }
}
