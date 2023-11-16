<?php

namespace App\Http\Controllers;

use App\Models\CoordinatesLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Location\Coordinate;
use Location\Polygon;

class CoordinateCheckController extends Controller
{
    public function check(Request $request)
    {
        $polygon = new Polygon();

        // Fetch points from the serviceable_area table
        $allPoints = DB::table('serviceable_area')->get(['latitude', 'longitude']);


        foreach ($allPoints as $pointData) {
            $latitude = $pointData->latitude;
            $longitude = $pointData->longitude;
            $polygon->addPoint(new Coordinate($latitude, $longitude));
        }
        // dd($polygon);
        //add a debugging tool to view in postman API testing


        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $isInServiceableArea = $this->coordinateInPolygon($latitude, $longitude, $polygon);

        // dd($isInServiceableArea);
        // Log the inputted coordinate and the check result in MySQL
        CoordinatesLog::create([
            'coordinates' => json_encode($request->all()),
            'is_serviceable' => $isInServiceableArea
        ]);

        return response()->json(['is_serviceable' => $isInServiceableArea]);
    }

    private function coordinateInPolygon($latitude, $longitude, $polygon)
    {
        if ($polygon === null) {
            // Handle the case when $polygon is null, e.g., return false or an appropriate response.
            return false;
        }

        $point = new Coordinate($latitude, $longitude);
        $polygonObject = new Polygon();

        foreach ($polygon->getPoints() as $pointData) {
            // dd("reaches", $pointData->getlng());
            $polygonObject->addPoint(new Coordinate($pointData->getLat(), $pointData->getLng()));
        }

        return $polygonObject->contains($point);
    }


}