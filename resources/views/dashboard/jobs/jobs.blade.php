@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                
                <pre>{{print_r($data,true)}}</pre>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Employee</th>
                            <th>Client</th>
                            <th>Car</th>                        
                            <th>Pirority</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr onclick="redir('{{$value['id']}}');">
                            <td>{{$value['data']}}</td>
                            <td>{{$value['progress']}}</td>
                            <td>{{$value['description']}}</td>
                            <td>{{$value['employee']}}</td>
                            <td>{{$value['client']}}</td>
                            <td>{{$value['car']}}</td>
                            <td>{{$value['pirority']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <script>
                    function redir(value){
                        window.document.location = "{{ url()->current() }}/"+value;
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
