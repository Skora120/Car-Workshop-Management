@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">

                <pre>{{print_r($data,true)}}</pre>

                <table class="table table-bordered">
                    <th>Date</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Employee</th>
                    <th>Client</th>
                    <th>Car</th>                        
                    <th>Pirority</th>

                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{$value['data']}}</td>
                            <td>{{$value['progress']}}</td>
                            <td>{{$value['description']}}</td>
                            <td>{{$value['employee']}}</td>
                            <td>{{$value['client']}}</td>
                            <td>{{$value['car']}}</td>
                            <td>{{$value['pirority']}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
