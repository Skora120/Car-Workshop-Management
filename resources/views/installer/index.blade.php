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
    <main>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Installer</div>
                <div class="panel-body">
                <div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="alert alert-danger">
                        @foreach($errors->all() as $value)
                                <p>{{ $value }}</p>
                        @endforeach
                        </div>
                    @endif
                <form method="POST" action="{{ route('envUpdate') }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <p>Database Configuration</p>
                    <div class="form-group">
                        <label for="hostAdress">Host adress (if it is the same server leave):</label> 
                        <input class="form-control" type="text" name="host" value="127.0.0.1">
                    </div>
                    <div class="form-group">
                    <label for="username">Login/Username to database:</label> 
                        <input class="form-control" type="text" name="user" value="{{ old('user') }}">
                    </div>
                    <div class="form-group">
                    <label for="password">Password:</label> 
                        <input class="form-control" type="text" name="password" value="{{ old('password') }}">
                    </div>
                    <div class="form-group">
                    <label for="database">Database name:</label> 
                        <input class="form-control" type="text" name="database" value="{{ old('database') }}">
                    </div>

                    <hr>

                    <p>Main Employee Account</p>
                    <div class="form-group">
                    <label for="username">Login/Username:</label> 
                        <input class="form-control" type="text" name="main_login" value="{{ old('main_login') }}">
                    </div>
                    <div class="form-group">
                    <label for="name">Name:</label> 
                        <input class="form-control" type="text" name="main_name" value="{{ old('main_name') }}">
                    </div>
                    <div class="form-group">
                    <label for="email">Email:</label> 
                        <input class="form-control" type="text" name="main_email" value="{{ old('main_email') }}">
                    </div>
                    <div class="form-group">
                    <label for="password">Password:</label> 
                        <input class="form-control" type="password" name="main_password" value="{{ old('main_password') }}">
                    </div>
                    <div class="form-group">
                    <label for="password_confirm">Password Confirm:</label> 
                        <input class="form-control" type="password" name="main_password_confirmation" value="{{ old('main_password_confirmation') }}">
                    </div>
                    <div class="form-group">
                    <label for="phone_number">Phone number:</label> 
                        <input class="form-control" type="text" name="main_phone_number" value="{{ old('main_phone_number') }}">
                    </div>

                    <hr>

                    <p>Mail Settings</p>
                    <div class="form-group">
                    <label for="mailDriver">Driver:</label> 
                        <input class="form-control" type="text" name="mail_driver" value="SMTP">
                    </div>
                    <div class="form-group">
                    <label for="mailHost">Host:</label> 
                        <input class="form-control" type="text" name="mail_host" value="{{ old('mail_host') }}">
                    </div>
                    <div class="form-group">
                    <label for="mailPort">Port:</label> 
                        <input class="form-control" type="text" name="mail_port" value="2525">
                    </div>
                    <div class="form-group">
                    <label for="mailUsername">Username:</label> 
                        <input class="form-control" type="text" name="mail_username" value="{{ old('mail_username') }}">
                    </div>
                    <div class="form-group">
                    <label for="password">Password:</label> 
                        <input class="form-control" type="text" name="mail_password" value="{{ old('mail_password') }}">
                    </div>
                    <div class="form-group">
                    <label for="encryption">Encryption (if there is no any then leave):</label> 
                        <input class="form-control" type="text" name="mail_encryption" value="{{ old('mail_encryption') }}">
                    </div>

                    <div class="text-center">
                    <button class="btn btn-primary btn-lg">Save Settings</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



    </main>


    <!-- Scripts -->
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>