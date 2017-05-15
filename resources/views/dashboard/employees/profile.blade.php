@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard
                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit Employee</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Employee</button>
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
            
                <pre>{{ print_r($data,true) }}</pre>
            </div>
        </div>
    </div>
</div>
    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Employee Edit</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url()->current()}}/put">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="form-group">
                    <label for="name">Name</label> 
                    <input class="form-control" type="text" name="name" value="{{ $data->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label> 
                    <input class="form-control" type="text" name="email" value="{{ $data->email }}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label> 
                    <input class="form-control" type="text" name="phone_number" value="{{ $data->phone_number }}">
                </div>
                <div class="form-group">
                    <label for="level">Level</label> 
                    <input class="form-control" type="text" name="level" value="{{ $data->level }}">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Information</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End of editModal -->

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Employee Delete</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url()->current()}}/delete">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="form-group">
                    <label for="username">User Name</label> 
                    <input class="form-control" type="text" name="username" disabled="true" value="{{ $data->username }}">
                </div>
                <div class="form-group">
                    <label for="name">Name</label> 
                    <input class="form-control" type="text" name="name" disabled="true" value="{{ $data->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label> 
                    <input class="form-control" type="text" name="email" disabled="true" value="{{ $data->email }}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label> 
                    <input class="form-control" type="text" name="phone_number" disabled="true" value="{{ $data->phone_number }}">
                </div>
                <div class="form-group">
                    <label for="level">Level</label> 
                    <input class="form-control" type="text" name="level" disabled="true" value="{{ $data->level }}">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Employee</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End of deleteModal -->
@endsection
