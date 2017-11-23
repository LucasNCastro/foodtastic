<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', ["cities" => City::all()]);
    }
}
