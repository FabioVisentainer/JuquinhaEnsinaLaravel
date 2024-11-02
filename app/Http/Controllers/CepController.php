<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City; // Make sure this is the correct model for your cities

class CepController extends Controller
{
    // Change this method to accept the cep as a route parameter
    public function fetchAddress($cep)
    {
        $city = City::with(['state', 'state.country']) // Ensure relationships are correctly defined in the models
            ->where('cep_start', '<=', $cep)
            ->where('cep_end', '>=', $cep)
            ->first();
    
        if ($city) {
            return response()->json([
                'city' => [
                    'id' => $city->city_id, // or use 'id' if that's your column name
                    'name' => $city->city_name,
                ],
                'state' => [
                    'id' => $city->state->state_id,
                    'name' => $city->state->state_name, // Adjust if your state name column is different
                ],
                'country' => [
                    'id' => $city->state->country->country_id,
                    'name' => $city->state->country->country_name, // Adjust if your country name column is different
                ],
            ]);
        }
    
        return response()->json(['error' => 'City not found'], 404);
    }
}