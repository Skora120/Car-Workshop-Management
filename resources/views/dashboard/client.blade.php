@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <form method="POST" action="{{URL::to('dashboard/newclient/new')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login">
                        </div>
                        <div class="form-group">
                            <label for="login">Email:</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" name="passsword">
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number:</label>
                            <input type="tel" class="form-control" name="phone_number">
                        </div>
                        <button type="submit" class="btn btn-primary">Create new Client</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
