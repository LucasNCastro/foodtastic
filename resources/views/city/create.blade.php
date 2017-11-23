@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-6">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header text-center">
                Add a city
            </h4>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('city_create') }}">
            {{ csrf_field() }}
           
           <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="name" class="col-md-12 control-label">Name</label>

                <div class="col-md-12">
                    <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" class="btn btn-success  btn-lg btn-block">
                            Add
                        </button>
                    </div>
                </div>
        </form>
            </div>
        </div>

    </div>
  </div>
</div>
@endsection