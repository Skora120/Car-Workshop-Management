<!DOCTYPE html>
<html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta id="csrf_token" name="csrf-token" content="{{ csrf_token() }}">
	<!-- TITLE -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!-- Temporary jQuery upper -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
                @if(Auth::guard('employee')->check())
                    <a class="navbar-brand" href="{{ url('/dashboard-employee') }}">
                        Dashboard
                    </a>
                @elseif(!Auth::guest())
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Dashboard
                    </a>
                @endif
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ route('dashboard-employee') }}/jobs">Orders</a></li>
            <li><a href="{{ route('dashboard-employee') }}/clients">Clients</a></li>
            <li><a href="{{ route('dashboard-employee') }}/parts">Parts</a></li>
            <li><a href="{{ route('dashboard-employee') }}/advanced">Advenced</a></li>
            <li><a href="{{ route('dashboard-employee') }}/settings">Settings</a></li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
          </ul>
          <form class="navbar-form navbar-middle">
            <div class="form-group">
                <input id="searchEngineLink" type="hidden" value="{{ route('search') }}">
                <input id="searchEngineLinkClients" type="hidden" value="{{ route('clients') }}">
                <input id="searchEngineLinkJobs" type="hidden" value="{{ route('jobs') }}">
                <input id="searchEngineLinkCars" type="hidden" value="{{ route('cars') }}">
                <input id="searchEngine" type="search" placeholder="Search" class="form-control" name="query">
                <div id="searchEngineNavbarList" class="list-group aboveSearchNavList"></div>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>