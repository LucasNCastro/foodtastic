@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-10">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header text-center">
                Add a product
            </h4>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('product_create') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-warning" role="alert">
                @if ($errors->has('other'))
                    {{ $errors->first('other') }}
                @endif
            </div>
           
           <div class="form-row">
            <div class="col">
            <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="name" class="control-label">Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>
            </div>
            <div class="col">
            <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="price" class="control-label">Price</label>

                    <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required autofocus>

                    @if ($errors->has('price'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
           </div>

           <div class="form-row">
                <div class="col">
                
                </div>
                <div class="col">
                
                </div>
           </div>

           <div class="form-row">
                <div class="col">
                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">

                <label for="category" class="control-label">Category</label>

                <select class="form-control" id="category" name="category">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == old('category') ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>

                    @if ($errors->has('category'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                    @endif
            </div>
                </div>
                <div class="col">
                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">

                <label for="producer" class="control-label">Producer</label>

                <select class="form-control" id="producer" name="producer">
                    @foreach($producers as $producer)
                    <option value="{{$producer->id}}" {{$producer->id == old('producer') ? 'selected' : ''}}>{{$producer->name}}</option>
                    @endforeach
                </select>

                    @if ($errors->has('producer'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('producer') }}</strong>
                        </span>
                    @endif
            </div>
                </div>
           </div>

           <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
           <label for="image" class="control-label">Image</label>
           
               <input id="image" type="file" accept="image/gif, image/jpeg, image/png" class="form-control" name="image" value="{{ old('price') }}" autofocus>

               @if ($errors->has('price'))
                   <span class="text-danger">
                       <strong>{{ $errors->first('image') }}</strong>
                   </span>
               @endif
           </div>
           
           
           <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="description" class="control-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" autofocus>{{ old('price') }}</textarea>

                    @if ($errors->has('description'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
            </div>
            




                <div class="form-group">
                    <div class="col-md-offset-4">
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