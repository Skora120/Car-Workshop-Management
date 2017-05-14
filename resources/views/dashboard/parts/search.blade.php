@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <pre>{{ print_r($data, true) }}</pre>

                {{ count($data[0]) }}

                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Part Number</th>
                                <th>For</th>
                            </tr>
                        </thead>                        
                        <tbody>
                        @foreach($pagination[0] as $key => $value)
                            <tr onclick="redir('{{ $value->id }}');">
                                <td>{{ $pagination->firstItem()+$key }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->part_number }}</td>
                                <td>{{ $value->shortinfo }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <script>
                        function redir(value){
                            window.location.href = "{{ url()->route('parts') }}/"+value;
                        }
                    </script>

                {!! $pagination->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
