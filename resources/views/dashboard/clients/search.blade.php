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
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pagination as $key => $value)
                            <tr onclick="redir('{{ $value->id }}');">
                                <td>{{ $pagination->firstItem()+$key }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->phone_number }}</td>
                                <td>{{ $value->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>

                        {{ $pagination->links() }}


                    </table>
                    <script>
                        function redir(value){
                            window.location.href = "{{ route('clients') }}/"+value;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
