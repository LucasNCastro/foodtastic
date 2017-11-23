<?php

namespace App\Http\Controllers;

use Validator;
use App\Producer;
use Illuminate\Http\Request;
use App\Utils\JsonResponse;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $producers = Producer::all();

        return View('Producer/Index', ['producers' => $producers]);
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
                $producer = new Producer();
                $producer->name = $request->name;
    
                try{
                    $producer->save();
                    return redirect()
                        ->route('producer');
                }catch(\Exception $e){
                    $errorMessages->add('name', 'Something went wrong while saving it to the database');
                }
            }
            return redirect()
                    ->route('producer_create')
                    ->withErrors($errorMessages);
        }
        
        return View('Producer/Create');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function details(Producer $producer)
    {
        return __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $jsonResponse = new JsonResponse();

        if($request->input('id'))
        {
            $databaseProducer = Producer::find($request->input('id'));

            if($databaseProducer)
            {
                $databaseProducer->name = $request->input('name');

                try{
                    if($databaseProducer->save())
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
}
