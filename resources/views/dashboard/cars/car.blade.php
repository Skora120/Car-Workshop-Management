@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
            <a href="{{ url()->current() }}/edit" class="btn btn-primary">Edit</a>
To do
               Car information 

               <pre>{{ print_r($data,true) }}</pre>
               <pre>{{ print_r($owner,true) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection
