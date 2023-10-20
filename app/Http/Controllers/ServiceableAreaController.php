<?php

namespace App\Http\Controllers;

use App\Models\ServiceableArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ServiceableAreaController extends Controller
{
    public function index()
    {
        // Retrieve the boundary coordinates from the database
        $coordinates = ServiceableArea::select('boundary_coordinates')->get();

        // Return the coordinates as a JSON response
        return response()->json(['boundary_coordinates' => $coordinates]);
    }


    public function store(Request $request)
    {
        //assuming the api returns the coordinates in the following format
        $validatedData = $request->validate([
            'boundary_coordinates' => 'required|json',
        ]);

        $serviceableArea = ServiceableArea::create([
            'boundary_coordinates' => $validatedData['boundary_coordinates'],
        ]);

        $serviceableArea->save();

        Redis::geoadd('serviceable_areas', $this->extractCoordinates($validatedData['boundary_coordinates']));

        return response()->json(['message' => 'Serviceable area saved successfully!']);

    }

    // Helper function to extract coordinates from JSON
    private function extractCoordinates($jsonCoordinates)
    {
        $coordinates = json_decode($jsonCoordinates, true);

        $redisCoordinates = [];
        foreach ($coordinates as $coordinate) {
            $redisCoordinates[] = [
                $coordinate['longitude'],
                $coordinate['latitude'],
            ];
        }

        return $redisCoordinates;
    }


}