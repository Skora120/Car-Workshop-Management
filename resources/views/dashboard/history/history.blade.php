@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                     @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>UserName</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pagination as $key => $value)
                            <tr>
                                <td>{{ $pagination->firstItem()+$key }}</td>
                                <td>{{ $value->username }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $pagination->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
