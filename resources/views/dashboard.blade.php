@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!

                    <p><a href="{{ url()->current() }}/newjoborder">Add new job order</a></p>
                    <p><a href="{{ url()->current() }}/newclient">Add new client</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
