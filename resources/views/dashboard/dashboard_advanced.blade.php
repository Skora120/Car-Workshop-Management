@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p><a href="{{ route('history') }}"><button class="btn btn-primary btn-lg">History</button></a></p>
                    <p><a href="{{ route('employees') }}"><button class="btn btn-primary btn-lg">Employee Manager</button></a></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
