<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         
         <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            Foodtastic
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->username }}
                        </a>
                        <div class="dropdown-menu" style="min-width:5rem" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
                @if(Session::has('selectedCity'))
                    <li class="nav-item" onclick="showModalToChangeCity()">
                        <a class="nav-link" href="JavaScript:Void(0);"><i class="fa fa-map"></i>&nbsp;{{ Session::get('selectedCity')->name }}</a>
                    </li>
                @endif
                <li class="nav-item">
                        <a class="nav-link" href="/Cart"><i class="fa fa-cart-arrow-down fa-lg"></i>&nbsp;<span class="badge badge-light" id="numberOfItemsInCart">{{Session::has('cart') ? count(Session::get('cart')) : '0'}}</span></a>
                    </li>
            </ul>
        </div>
        </nav>

        @if(Session::has('info'))
        <div class="alert alert-info mt-1" role="alert">
            {{ Session::get('info') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger mt-1" role="alert">
            {{ Session::get('error') }}
        </div>
        @endif

        @yield('content')
    </div>

<div class="modal fade" id="info-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title">Informations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="info-body"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="change-selected-city-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title">Change city</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul id="selectableCities" class="list-group">

        </ul>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
