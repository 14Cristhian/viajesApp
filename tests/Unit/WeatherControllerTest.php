<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\WeatherController;

class WeatherControllerTest extends TestCase
{
    public function testGetWeatherReturnsJson()
    {

        $request = new Request(['city' => 'London', 'country' => 'UK']);

        //Mock
        Http::fake([
            '*' => Http::response(['temp' => 20, 'description' => 'Cloudy'], 200),
        ]);


        $controller = new WeatherController();


        $response = $controller->getWeather($request);


        $this->assertJson($response->content());


        dump($response->content());
    }
}
