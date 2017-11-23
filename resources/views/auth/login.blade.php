@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-6">

        <div class="card text-white bg-dark mb-3">
            <h4 class="card-header text-center">
                Login
            </h4>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
           
           <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="text-info">
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
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" class="btn btn-primary  btn-lg btn-block">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
        </form>
            </div>
        </div>

    </div>
  </div>
</div>
@endsection
