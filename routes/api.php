<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

Route::middleware('api')->get('/tutors', function (Request $request) {
    return response()->json([
        'data' => [], // You can replace this with your actual logic
        'message' => 'Tutors fetched successfully.',
    ]);
});

