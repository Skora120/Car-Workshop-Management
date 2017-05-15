@extends('layouts.appClient')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in as Client.
                    <p><a href="{{ route('clientViewOrders') }}">Your Orders</a></p>
                    <p><a href="{{ route('clientSettings') }}">Settings</a></p>

                    <pre>{{ print_r($user,true) }}</pre>
                    <pre>{{ print_r($cars,true) }}</pre>
                    <pre>{{ print_r($carsCount,true) }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
