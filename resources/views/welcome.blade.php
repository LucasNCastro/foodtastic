@extends('layouts.app')

@section('content')

<div class="jumbotron">
  <div class="row">
    <div class="col-md-6">
        <h1 class="display-2">Foodtastic</h1>
    <p class="lead">A company specialized in organic and regional products selling.</p>
    </div>
    <div class="col-md-5 ml-auto">
        <div class="card text-white bg-primary">
            <div class="card-body">

            @if(Session::has('selectedCity'))
                <h5 class="card-title">{{Session::get('selectedCity')->name}} is selected as your city.</h5>
            @else
                <h5 class="card-title">Select a city to start browsing our products</h5>
            @endif
            
                
                    <div class="form-group">
                    <select id="selectedCity" name="selectedCity" class="form-control">
                    @foreach($cities as $city)
                        <option value="{{$city->id}}" {{Session::has('selectedCity') && Session::get('selectedCity')->id == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                    @endforeach
                    </select>
                    </div>
                
                
                <div class="form-group">
                    <button class="btn btn-default btn-block" onclick="citySelected()">Start browsing</button>
                </div>
            </div>

        </div>
    </div>
  </div>
</div>

@endsection