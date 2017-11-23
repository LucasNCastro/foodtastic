@extends('layouts.app')

@section('content')

<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-10">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header text-center">
                Update product stock for each city
            </h4>
            <div class="card-body">
                <form>
                <input type="hidden" id="product-id" value="{{$product_id}}" />
                @foreach($citiesWithQuantity as $cityId => $cityWithQuantity)
                <div class="form-group row">
                    <label for="stock-{{$cityId}}" class="col-md-2 col-form-label">{{$cityWithQuantity['city']}}</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="stock-{{$cityId}}" value="{{$cityWithQuantity['quantity']}}">
                    </div>
                    <button type="button" class="btn btn-info col-md-2" onclick="updateProductStock({{$cityId}})">Update</button>
                </div>
                @endforeach
                </form>
            </div>
        </div>

    </div>

</div>

@endsection