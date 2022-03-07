<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorCreateRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\TypDoctor;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    //

    public function table(){

        $doctors = User::orderBy('created_at', 'desc')->where('role', 'doctor')->with('type')->get();
        return response()->json($doctors, Response::HTTP_OK);
    }

    public function update(DoctorUpdateRequest $request, $id){

         try {
            $inputs = $request->validated();
            $doctor = User::findOrFail($id);
            $inputs['password'] = Hash::make($inputs['password']);
            $doctor = $doctor->update($inputs);
            return response()->json($doctor, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(DoctorCreateRequest $request){

        try {
            $inputs = $request->validated();
            $inputs['role'] = 'doctor';
            $inputs['password'] = Hash::make($inputs['password']);
            $doctor = User::create($inputs);
            return response()->json($doctor, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($id){

        try {
            $doctor = User::findOrFail($id);
            $doctor->delete();
            return response()->json($doctor, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function types(){
        $types = TypDoctor::all();
        return response()->json($types, Response::HTTP_OK);
    }
}
