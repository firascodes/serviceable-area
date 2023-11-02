<?php

namespace App\Http\Controllers;

use App\Models\ServiceableArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ServiceableAreaController extends Controller
{
    public function index()
    {
        // Retrieve the latitude and longitude from the database
        $coordinates = ServiceableArea::select('latitude', 'longitude')->get();

        // Return the coordinates as a JSON response
        return response()->json(['boundary_coordinates' => $coordinates]);
    }


    public function store(Request $request)
    {
        // Assuming the API receives the coordinates in the following format:
        // [
        //     {"latitude": 40.7128, "longitude": 74.0060},
        //     {"latitude": 34.0522, "longitude": 118.2437},
        //     ...
        // ]
        $validatedData = $request->validate([
            'boundary_coordinates' => 'required|array',
            'boundary_coordinates.*.latitude' => 'required|numeric',
            'boundary_coordinates.*.longitude' => 'required|numeric',
        ]);

        foreach ($validatedData['boundary_coordinates'] as $coordinate) {
            $serviceableArea = ServiceableArea::create([
                'latitude' => $coordinate['latitude'],
                'longitude' => $coordinate['longitude'],
            ]);

            $serviceableArea->save();
        }

        return response()->json(['message' => 'Serviceable area saved successfully!']);
    }

    // Helper function to extract coordinates from JSON
    // private function extractCoordinates($jsonCoordinates)
    // {
    //     $coordinates = json_decode($jsonCoordinates, true);

    //     $redisCoordinates = [];
    //     foreach ($coordinates as $coordinate) {
    //         $redisCoordinates[] = [
    //             $coordinate['latitude'],
    //             // Latitude first
    //             $coordinate['longitude'],
    //             // Longitude second
    //         ];
    //     }

    //     return $redisCoordinates;
    // }


}