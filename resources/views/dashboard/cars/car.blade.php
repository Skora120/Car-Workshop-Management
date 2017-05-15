@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
            <a href="{{ url()->current() }}/edit" class="btn btn-primary">Edit</a>
             <h2>Car information:</h2> 

              <a href="{{ route('clients') }}/{{ $owner->id }}"><p>Owner: {{ $owner->name }}</p></a>
              <p>Manufacturer: {{ $data->manufacturer }}</p>
              <p>Model: {{ $data->model }}</p>
              <p>Color: {{ $data->color }}</p>
              <p>Engine: {{ $data->engine }}</p>
              <p>Year: {{ $data->year }}</p>
              <p>Vin: {{ $data->vin }}</p>
              <p>Number plates: {{ $data->number_plates }}</p>
              <p>Milage: {{ $data->milage }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
