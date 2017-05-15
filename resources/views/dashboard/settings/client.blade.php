@extends('layouts.appClient')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
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

                <form method="POST" action="{{ route('clientSettingsPut') }}">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="oldpassword">Old Password</label> 
                    <input class="form-control" type="password" name="oldpassword">
                </div>
                <div class="form-group">
                    <label for="password">New Password</label> 
                    <input class="form-control" type="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Repeat New Password</label> 
                    <input class="form-control" type="password" name="password_confirmation">
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
