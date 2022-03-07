<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function index(){
        $locations = Location::all();
        return response()->json($locations, Response::HTTP_OK);
    }
}
