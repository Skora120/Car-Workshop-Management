@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p><a href="{{ route('createClient') }}">Add new client</a></p>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Cars count</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $value)
                            <tr onclick="redir('{{$value['id']}}');">
                                <td>{{$value['id']}}</td>
                                <td>{{$value['name']}}</td>
                                <td>{{$value['phone_number']}}</td>
                                <td>{{$value['cars_count']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        function redir(value){
                            window.document.location = "{{ url()->current() }}/id/"+value;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
