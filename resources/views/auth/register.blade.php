@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-lg-6">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header text-center">
                Register
            </h4>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('username') ? ' is-invalid' : '' }}">
                            <label for="name" class="col-md-12 control-label">Username</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="text-info">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('fullname') ? ' is-invalid' : '' }}">
                            <label for="fullname" class="col-md-12 control-label">Fullname</label>

                            <div class="col-md-12">
                                <input id="fullname" type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" required autofocus>

                                @if ($errors->has('fullname'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('fullname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' is-invalid' : '' }}">
                            <label for="address" class="col-md-12 control-label">Address</label>

                            <div class="col-md-12">
                                <textarea rows="5" cols="" id="address" class="form-control" name="address" required autofocus>{{ old('address') }}</textarea>

                                @if ($errors->has('address'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                            <label for="email" class="col-md-12 control-label">E-Mail</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                            <label for="password" class="col-md-12 control-label">Password</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-primary  btn-lg btn-block">
                                    Register
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
