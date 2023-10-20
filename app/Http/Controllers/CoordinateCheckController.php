<?php

namespace App\Http\Controllers;

use App\Models\CoordinatesLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CoordinateCheckController extends Controller
{
    public function check(Request $request)
    {
        // Complex part -  point-in-polygon algorithm to check if the input is within the serviceable area. This could be a method in the Controller, or even a separate, dedicated service class.

        $serviceableArea = json_decode(Redis::get('serviceable_area'));
        $isInServiceableArea = $this->coordinateInPolygon($request->input('latitude'), $request->input('longitude'), $serviceableArea);

        // Log the inputted coordinate and the check result in MySQL
        CoordinatesLog::create([
            'coordinates' => $request->all(),
            'is_in_serviceable_area' => $isInServiceableArea
        ]);

        return response()->json(['is_in_serviceable_area' => $isInServiceableArea]);
    }
}