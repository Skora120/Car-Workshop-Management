@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>manufacturer</th> 
                            <th>model</th>  
                            <th>engine</th>
                            <th>year</th>        
							<th>number_plates</th>     
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pagination as $key => $value)
                        <tr onclick="redir('{{ $value->id }}');">
                            <td>{{ $value->manufacturer }}</td>
                            <td>{{ $value->model }}</td>
                            <td>{{ $value->engine }}</td>
                            <td>{{ $value->year }}</td>
                            <td>{{ $value->number_plates }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $pagination->links() }}

                <script>
                	function redir(value){
                        window.location.href = "{{ url()->route('cars') }}/"+value;
                    }   



                </script>

            </div>
        </div>
    </div>
</div>
@endsection
