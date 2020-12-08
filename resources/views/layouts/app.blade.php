<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @notify_css
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-info shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    <!-- icon -->
                        <div class="dropdown nav-button notifications-button hidden-sm-down">
                            <a class="btn btn-primary dropdown-toggle" href="#" id="notifications-dropdown" data-toggle="dropdown">
                                <i id="notificationIcons" aria-hidden="true"></i>
                                <svg class="bi bi-bell-fill" width="1em" height="1em"></svg>
                                <span class="badge badge-danger">
                                    <i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true" >
                                        {{ count(\Illuminate\Support\Facades\Auth::User()->unreadNotifications) }}
                                    </i>
                                </span>
                            </a>
                            <!--Notifications-->
                            <div class="dropdown-menu notification-dropdown-menu" style="min-width: 360px; max-width: 360px">
                                <h6 class="dropdown-header">Notifications</h6>
                                @if(count(\Illuminate\Support\Facades\Auth::User()->unreadNotifications) > 0)
                                    <div id="notificationsContainer" class="notifications-container">
                                        @foreach(\Illuminate\Support\Facades\Auth::User()->unreadNotifications as $notification)
                                            <div class="notifications-body">
                                                <p class="notifications-texte mx-1">
                                                    <small>
                                                        <span class="badge badge-pill badge-dark">
                                                            #{{ $notification->data['todo_id'] }}
                                                        </span>
                                                        {{ $notification->data['affected_by'] }}
                                                        t'a affecte la todo {{ $notification->data['todo_name'] }}
                                                    </small>
                                                </p>
                                            </div>
                                            {{ \Illuminate\Support\Facades\Auth::User()->unreadNotifications->markAsRead() }}
                                        @endforeach


                                    </div>
                                @else
                                    <!-- aucune notification -->
                                    <a class="dropdown-item dropdown-notification" href="#">
                                        <p class="notification-solo text-center">Aucune nouvelle notification </p>
                                    </a>
                                @endif
                                {{-- <!-- Toutes -->
                                <a class="dropdown-item dropdown-notification-all" href="#">
                                    voir toutes les notifications
                                </a> --}}

                            </div>
                        </div>
                    @endauth
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="{{ route('todos.index') }}" class="nav-link">Les todos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('apropos') }}" class="nav-link">A propos</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
</body>
@notify_js
@notify_render
</html>
