@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard You are logged as Employee!</div>

                <div class="panel-body">
                    <ul class="list-group">
                    <a href="{{ url()->current() }}/jobs?page=1" class="list-group-item">Current Orders</a>
                    <a href="{{ url()->current() }}/jobs/newjob" class="list-group-item">Create a new Order</a>
                    <a href="{{ url()->current() }}/clients" class="list-group-item">Customers</a>
                    <a href="{{ url()->current() }}/clients/newclient" class="list-group-item">Create a new customer account</a>
                    <a href="{{ url()->current() }}/parts" class="list-group-item">Parts</a>
                    @if ($level > 5)
                    <a href="{{ url()->current() }}/employees" class="list-group-item">Employees Management</a>
                    <a href="{{ url()->current() }}/history" class="list-group-item">History</a>
                    @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
