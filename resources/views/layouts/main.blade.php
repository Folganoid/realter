<!doctype html>
<html lang="en">
<head>
    <title>Realter</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glyphicon.css') }}">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">LOGO</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{ route('list') }}">List</a>
            <a class="nav-item nav-link" href="{{ route('cabinet') }}">Cabinet</a>
            <a class="nav-item nav-link" href="{{ route('property.add') }}">Add property</a>
            <a class="nav-item nav-link" href="{{ route('admin') }}">for Admin</a>
        </div>

        <div class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <a class="nav-item nav-link" href="{{ route('login') }}">Login</a>
            <a class="nav-item nav-link" href="{{ route('register') }}">Register</a>
            @else

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                Profile
                            </a>
                        </li>
                    </ul>
                </li>
        </div>
        @endguest
    </div>
    </div>
</nav>

<div class="container">
    @if(Auth::check() && Gate::denies('is-verify'))
        <div class="alert alert-warning }}">
            <b>Check Email and verify your account!</b>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-{{ session('class') }}">
            {{ session('status') }}
        </div>
    @endif

    @yield('content')
</div>


</body>
</html>