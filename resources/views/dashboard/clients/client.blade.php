@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard
                    <button class="btn btn-primary" data-toggle="modal" data-target="#customerEdit">Edit Customer</button>
                    <button class="btn btn-primary">Add Car</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#customerDelete">Delete Customer</button>

                </div>

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

                    <pre>{{print_r($user,true)}}</pre>
                    <pre>{{print_r($cars,true)}}</pre>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer -->
<div id="customerEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Customer Edit</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ url()->current()}}/clientedit">
            <input type="hidden" name="_method" value="put">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $user['id'] }}">
            <div class="form-group">
                <label for="name">Name:</label> 
                <input type="text" class="form-control" name="name" value="{{ $user['name'] }}">     
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label> 
                <input type="text" class="form-control" name="phone" value="{{ $user['phone'] }}">          
            </div>
            <div class="form-group">
                <label for="email">Email:</label> 
                <input type="text" class="form-control" name="email" value="{{ $user['email'] }}">         
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>  
<!-- Edit Customer END //////////////-->

<!-- Delete Customer -->
<div id="customerDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Customer Delete</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ url()->current()}}/clientdel">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $user['id'] }}">
            <div class="form-group">
                <label for="name">Name:</label> 
                <input type="text" class="form-control" disabled="true" name="name" value="{{ $user['name'] }}">     
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label> 
                <input type="text" class="form-control" disabled="true" name="phone" value="{{ $user['phone'] }}">          
            </div>
            <div class="form-group">
                <label for="email">Email:</label> 
                <input type="text" class="form-control" disabled="true" name="email" value="{{ $user['email'] }}">         
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Delete Customer END //////////////-->
































@endsection
