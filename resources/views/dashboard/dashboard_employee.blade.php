@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in as Employee!

                    <p><a href="{{ url()->current() }}/jobs/newjob">Add new job order</a></p>
                    <p><a href="{{ url()->current() }}/jobs?page=1">Current jobs</a></p>
                    <p><a href="{{ url()->current() }}/clients">Clients</a></p>
                    <p><a href="{{ url()->current() }}/clients/newclient">Add new client</a></p>
                    <p><a href="{{ url()->current() }}/parts">Parts</a></p>
                    @if ($level > 5)
                    <p><a href="{{ url()->current() }}/employees">Employees Management</a></p>
                    <p><a href="{{ url()->current() }}/history">History</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
