<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return __METHOD__;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function details(Order $order)
    {
        return __METHOD__;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function getAllByCategory(Order $order)
    {
        return __METHOD__;
    }

    public function getAllByProducer(Order $order)
    {
        return __METHOD__;
    }

    public function getAllOrdersOfLastWeek(Order $order)
    {
        return __METHOD__;
    }

    public function placeOrders(Order $order)
    {
        return __METHOD__;
    }
}
