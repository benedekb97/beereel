<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="BeerEel"/>
        <meta name="author" content="Benedek Burgess"/>

        <title>@yield('title')</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">BeerEel.</a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">Profilom</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @if (\Auth::user() !== null)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Kijelentkezés</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div>
        @yield('modals')
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
