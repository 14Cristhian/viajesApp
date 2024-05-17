<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class convertirMoneda extends Controller
{
    public function convertirMoneda(Request $request)
    {
        $from = 'COP';
        $to = $request->get('to');
        $amount = $request->get('amount');

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '6d76c9e9c4msh7ae33437c150f7fp1b6db7jsne3e4dfb85101',
            'X-RapidAPI-Host' => 'currency-conversion-and-exchange-rates.p.rapidapi.com',
        ])->get('https://currency-conversion-and-exchange-rates.p.rapidapi.com/convert', [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ]);

        return $response->json();
    }
}
