@extends('layouts.appClient')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Your Card</div>

                <div class="panel-body">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Phone number: {{ $user->phone_number }}</p>
                    <p>Number of Cars: {{ $carsCount }}</p>

                    <hr>

                    @foreach($cars as $key => $value)
                        <div>
                            <p>#{{ $key+1 }}</p>
                            <p>Manufacturer: {{ $value->manufacturer }}</p>
                            <p>Model: {{ $value->model }}</p>
                            <p>Color: {{ $value->color }}</p>
                            <p>Engine: {{ $value->engine }}</p>      
                            <p>Year: {{ $value->year }}</p>
                            <p>Vin: {{ $value->vin }}</p>
                            <p>Number: Plates {{ $value->number_plates }}</p>
                            <p>Milage: {{ $value->milage }}</p>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
