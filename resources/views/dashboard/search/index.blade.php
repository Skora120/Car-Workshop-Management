@extends('layouts.app')

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
                                <th>#</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pagination as $key => $value)
                            <tr onclick="redir('{{ $value['type'] }}/{{ $value['id'] }}');">
                                <td>{{ $pagination->firstItem()+$key }}</td>
                                <td>@if($value['type'] === 'jobs')
                                        Job Orders
                                    @else
                                        Customer
                                    @endif
                                </td>
                                <td>{{$value['description']}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        function redir(value){
                            window.document.location = "{{ url()->route('dashboard-employee') }}/"+value;
                        }
                    </script>

                {!! $pagination->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
