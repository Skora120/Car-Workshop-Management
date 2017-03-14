@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">

                <pre>{{print_r($data,true)}}</pre>

            </div>
        </div>
    </div>
</div>
@endsection
