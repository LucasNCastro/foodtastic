<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Utils\JsonResponse;
use App\City;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function citySelected(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;

        $city = City::find($request->input('selectedCity'));

        if($city)
        {
            $request->session()->put('selectedCity', $city);  
            $jsonResponse->isSucceeded = true;      
        }

        return json_encode($jsonResponse);
    }
}
