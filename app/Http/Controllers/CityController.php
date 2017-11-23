<?php

namespace App\Http\Controllers;

Use Validator;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\JsonResponse;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $cities = City::all();
 
         return View('City/Index', ['cities' => $cities]);
     }

 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create(Request $request)
     {
         if($request->isMethod('post'))
         {
             $validator = Validator::make($request->all(), [
                 'name' => 'bail|required|max:255'
             ]);
 
             $errorMessages = $validator->errors();
 
             if($errorMessages->count() == 0)
             {
                 $sameCityInDb = City::where(['name' => $request->name])->first();

                 if(!$sameCityInDb)
                 {
                    $city = new City();
                    $city->name = $request->name;
        
                    try{
                        $city->save();
                        return redirect()
                            ->route('city');
                    }catch(\Exception $e){
                        $errorMessages->add('name', 'Something went wrong while saving it to the database');
                    }
                 }
                 else
                 {
                    $errorMessages->add('name', 'City name is already taken.');
                 }
                 
             }
             return redirect()
                     ->route('city_create')
                     ->withErrors($errorMessages);
         }
         
         return View('City/Create');
     }
 
 
     /**
      * Display the specified resource.
      *
      * @param  \App\City  $city
      * @return \Illuminate\Http\Response
      */
     public function details(City $city)
     {
         return __METHOD__;
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\City  $city
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request)
     {
         $jsonResponse = new JsonResponse();
 
         if($request->input('id'))
         {
             $databaseCity = City::find($request->input('id'));
 
             if($databaseCity)
             {
                 $databaseCity->name = $request->input('name');
 
                 try{
                     if($databaseCity->save())
                     {
                         $jsonResponse->isSucceeded = true;
                         return json_encode($jsonResponse);
                     }
                 }catch(\Exception $e){}
                 
             }
         }
         $jsonResponse->isSucceeded = false;
         return json_encode($jsonResponse);
     }

     public function getAllAsJson()
     {
         return json_encode(City::all());
     }
}
