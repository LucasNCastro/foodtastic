@extends('layouts.app')

@section('content')

<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-10">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header">
               Product details
            </h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{$image_url}}" class="rounded" width="200" height="200"/>
                    </div>
                    <div class="col-md-8">
                        <h4>{{$product->name}}</h4>
                        @if($product->description)
                        <div class="row">
                            <div class="col-md-4">Description</div>
                            <div class="col-md-4">{{$product->description}}</div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">Category</div>
                            <div class="col-md-4">{{$product->category->name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Producer</div>
                            <div class="col-md-4">{{$product->producer->name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Price</div>
                            <div class="col-md-4">{{$product->price}} €</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">Quantity</div>
                            <div class="col-md-4">
                        @if(Session::has('selectedCity'))
                        @php
                            $isInStock = false;
                            $howMany = 0;
                        @endphp
                            @foreach($product->productAvailabilities as $productAvailability)
                                @if($productAvailability->city_id == Session::get('selectedCity')->id)
                                @php
                                    $isInStock = true;
                                    $howMany = $productAvailability->quantity;
                                @endphp
                                    {{$productAvailability->quantity}}
                                @endif
                            @endforeach
                            @if(!$isInStock)
                            0
                            @endif
                        @else
                            <p class="text-warning">Please select a city to view the quantity in stock<p>
                        @endif
                            </div>
                        </div>

                        @if($isInStock && Session::has('selectedCity'))
                        <div class="row">
                            <div class="col-md-4">
                                <select id="quantity" class="form-control" onchange="computeTotalPrice({{$product->price}})">
                                @for ($i = 1; $i <= $howMany; $i++)
                                    <option>{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" onclick="addToCart({{$product->id}}, {{$product->price}})">Add to cart</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 display-4 text-primary" id="totalPrice">
                                {{$product->price}} €
                            </div>
                        </div>
                        @elseif(!$isInStock && Session::has('selectedCity'))
                        <p class="text-danger">We don't have this product in the stock.</p>
                        @endif
                        
                        

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection