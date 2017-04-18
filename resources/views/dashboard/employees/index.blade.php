@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Employee</button>
            </div>

            <div class="panel-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-danger">
                    @foreach($errors->all() as $value)
                            <p>{{ $value }}</p>
                    @endforeach
                    </div>
                @endif
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Permission level</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr onclick="redir('{{ $value->id }}')">
                            <td>{{ $data->firstItem()+$key }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->phone_number }}</td>
                            <td>{{ $value->level }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}

                <script>
                    function redir(value){
                        window.document.location = "{{ url()->current() }}/"+value;
                    }
                </script>
            </div>
        </div>
    </div>
</div>


<!-- Add Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Employee</h4>
      </div>
      <div class="modal-body">
            <form method="POST" action="{{ url()->current()}}/post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="username">User Name</label> 
                    <input class="form-control" type="text" name="username">
                </div>
                <div class="form-group">
                    <label for="name">Name</label> 
                    <input class="form-control" type="text" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label> 
                    <input class="form-control" type="text" name="email">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label> 
                    <input class="form-control" type="text" name="phone_number">
                </div>
                <div class="form-group">
                    <label for="level">Level</label> 
                    <input class="form-control" type="text" name="level">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Delete Employee</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- End of addModal -->

@endsection
