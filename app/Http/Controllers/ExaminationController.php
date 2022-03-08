<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExaminationCreateRequest;
use App\Models\Examination;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{
    public function __construct()
    {
        $this->middleware('counter')->only('store', 'destroy');
        $this->middleware('examination');
     }

    public function table()
    {
        $user = Auth::user();
        $examinations = Examination::query();
        if ($user->role == 'doctor') {
            $examinations = $examinations->where('doctor_id', $user->id)->where('performed', 0);
        }
        $examinations = $examinations->with('patient', 'doctor')->orderBy('created_at', 'desc')->paginate(6);
        return response()->json($examinations, Response::HTTP_OK);
    }
    public function store(ExaminationCreateRequest $request)
    {
        try {
            $inputs = $request->validated();
            $examination = Examination::create($inputs);
            return response()->json($examination, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(ExaminationCreateRequest $request, $id)
    {
        try {
            $user = Auth::user();
            $inputs = $request->validated();
            $examination = Examination::findOrFail($id);
            if($user->role == 'doctor'){
                unset($inputs['patient_id']);
                unset($inputs['doctor_id']);
                unset($inputs['time_of_examination']);
             }
            $examination = $examination->update($inputs);
            return response()->json($examination, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($id)
    {
        try {
            $examination = Examination::findOrFail($id);
            $examination->delete();
            return response()->json($examination, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
