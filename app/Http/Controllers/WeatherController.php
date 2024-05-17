<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->input('city');
        $country = $request->input('country');
        $apiKey = '474defd3503ea00be11b22200d6e0a50';
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid={$apiKey}";

        $response = Http::get($apiUrl);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener el clima'], 500);
        }

        return response()->json($response->json());
    }
}