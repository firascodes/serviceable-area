<?php

namespace App\Http\Controllers;

use App\Models\CoordinatesLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Location\Coordinate;
use Location\Polygon;

class CoordinateCheckController extends Controller
{
    public function check(Request $request)
    {
        $polygon = new Polygon();
        // $allPoints = Redis::georadius('serviceable_areas', 0, 0, 10000, 'km', 'WITHCOORDINATES');

        // [26.854508260485595, 80.91159015529058],
        // [26.897994159339035, 80.92085986987401],
        // [26.891564200205366, 81.02351337581624],
        // [26.812231298440736, 81.00634723769879],

        // 26.851751548407407, 80.95004230467363

        // outside
        // 26.77514939011856, 80.96171527859347
        //Dummy points
        $allPoints = [
            ['member' => 'Point 1', 'coordinates' => [26.854508260485595, 80.91159015529058]],
            ['member' => 'Point 2', 'coordinates' => [26.897994159339035, 80.92085986987401]],
            ['member' => 'Point 3', 'coordinates' => [26.891564200205366, 81.02351337581624]],
            ['member' => 'Point 4', 'coordinates' => [26.812231298440736, 81.00634723769879],],
            // Add more points as needed
        ];


        foreach ($allPoints as $pointData) {
            $coordinates = $pointData['coordinates'];
            $latitude = $coordinates[0];
            $longitude = $coordinates[1];
            $polygon->addPoint(new Coordinate($latitude, $longitude));
        }
        // dd($polygon);
        //add a debugging tool to view in postman API testing

        $isInServiceableArea = $this->coordinateInPolygon($request->input('latitude'), $request->input('longitude'), $polygon);

        dd($isInServiceableArea);
        // Log the inputted coordinate and the check result in MySQL
        CoordinatesLog::create([
            'coordinates' => json_encode($request->all()),
            'is_serviceable' => $isInServiceableArea
        ]);

        return response()->json(['is_in_serviceable_area' => $isInServiceableArea]);
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