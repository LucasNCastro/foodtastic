@extends('layouts.app')

@section('content')

<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
    <div class="list-group">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product</th>
                <th>Unit price</th>
                <th>Quantity</th>
                <th>Remove</th>
                <th>Total price</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
            @endphp
            @for($i = 0; $i < count($cart); $i +=2)
                <tr>
                    <td>{{$i + 1}}</td>
                    <td><img src="{{$cart[$i]['product']->image_path}}" width=50 height=50/></td>
                    <td>{{$cart[$i]['product']->name}}</td>
                    <td>{{$cart[$i]['product']->price}} €</td>
                    <td>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="number" value="{{$cart[$i + 1]['quantity']}}" class="form-control" id="product-{{$cart[$i]['product']->id}}-quantity" />
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-warning" onclick="updateQuantity({{$cart[$i]['product']->id}})">Update</button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="removeProductFromCart({{$cart[$i]['product']->id}})">Remove</button>
                    </td>
                    <td>{{$cart[$i]['product']->price * $cart[$i + 1]['quantity']}} €</td>
                    @php
                        @$grandTotal += $cart[$i]['product']->price * $cart[$i + 1]['quantity'];
                    @endphp
                </tr>
            @endfor
        </tbody>
        </table>

        <p class="display-4">Grand total : {{$grandTotal}} € &nbsp;<button href="#" class="btn btn-lg btn-success"><i class="fa fa-credit-card"></i>&nbsp;Pay</button></p>
    </div>
    </div>
  </div>
</div>

@endsection