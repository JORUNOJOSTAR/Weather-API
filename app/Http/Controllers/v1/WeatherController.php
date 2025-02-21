<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\WeatherRequest;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\RequestException as ClientRequestException;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function __invoke(WeatherRequest $request){
        //hash the whole request url
        $cache_key = md5($request->fullUrl());

        $weather_data = Cache::remember($cache_key,now()->addHours(12),function() use ($request){
            return $this->requestAPI($request)->json();
        });

        return $weather_data;
    }

    private function requestAPI(WeatherRequest $request){
        $api_response = Http::withUrlParameters([
            'endpoint'=> env('WEATHER_API_ENDPOINT'),
            'mode' => $request->query('mode'),
            'api_key' => env('WEATHER_API_KEY'),
            'city' => $request->query('city'),
            'days'=> $request->query('days'),
            'date'=> $request->query('date'),
        ])->get('{+endpoint}/{mode}.json?key={api_key}&q={city}&days={days}&dt={date}');

        if($api_response->successful()){
            return $api_response;
        }else{
            throw new ClientRequestException($api_response);
        }
    }
}
