@extends('layouts.appClient')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Car</th>
                                <th>Status</th>                        
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:i') }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->carInfo() }}</td>
                                <td>{{ $value->formattedProgress() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
