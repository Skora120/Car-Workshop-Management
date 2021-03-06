@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#customerEdit">Edit Customer</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#carAdd">Add Car</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#customerDelete">Delete Customer</button>
                    </div>   
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
                    @if (session('errors'))
                        <div class="alert alert-danger">
                        @foreach($errors->all() as $value)
                                <p>{{ $value }}</p>
                        @endforeach
                        </div>
                    @endif

                    <hr>

                    <p>Name: {{ $user->name }}</p>
                    <p>Phone Number: {{ $user->phone_number }}</p>
                    <p>Email: {{ $user->email }}</p>

                    <hr>

                    @if(empty($cars[0]))
                        <p><strong>Customer does not have any cars!</strong></p>
                    @else
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th> 
                                <th>Manufacturer</th> 
                                <th>Model</th>  
                                <th>Color</th>
                                <th>Engine</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($cars as $key => $value)
                            <tr onclick="redirc('{{$value->id}}');">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->manufacturer }}</td>
                                <td>{{ $value->model }}</td>
                                <td>{{ $value->color }}</td>
                                <td>{{ $value->engine }}</td>
                                <td>{{ $value->year }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    @endif

                    <hr>
                    
                    @if(empty($orders[0]))
                        <p><strong>Customer does not have any orders!</strong></p>
                    @else
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th> 
                                <th>Description</th>
                                <th>Car</th>
                                <th>Pirority</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $key => $value)
                            <tr onclick="redirj('{{$value->id}}');">
                                <td>{{ $orders->firstItem()+$key }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $orders[$key]->carInfo() }}</td>
                                <td>{{ $value->formattedPirority() }}</td> 
                                <td>{{ $value->formattedProgress() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> 
                    {{ $orders->links() }}
                    @endif
                    <script>
                        function redirc(value){
                            window.location.href = "{{ url()->route('cars') }}/"+value;
                        }
                        function redirj(value){
                            window.location.href = "{{ url()->route('jobs') }}/"+value;
                        }
                    </script>
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

<!-- Add Car -->
<div id="carAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Car Add</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ url()->current()}}/caradd">
            <input type="hidden" name="_method" value="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $user['id'] }}">
            <div class="form-group">
                <label for="manufacturer">Manufacturer:</label> 
                <input type="text" class="form-control" name="manufacturer">     
            </div>
            <div class="form-group">
                <label for="model">Model:</label> 
                <input type="text" class="form-control" name="model">          
            </div>
            <div class="form-group">
                <label for="color">Color:</label> 
                <input type="text" class="form-control" name="color">         
            </div>
            <div class="form-group">
                <label for="engine">Engine:</label> 
                <input type="text" class="form-control" name="engine">         
            </div>
            <div class="form-group">
                <label for="vin">Vin:</label> 
                <input type="text" class="form-control" name="vin">         
            </div>
            <div class="form-group">
                <label for="year">Year:</label> 
                <input type="number" class="form-control" name="year">         
            </div>
            <div class="form-group">
                <label for="number_plates">Number Plate:</label> 
                <input type="text" class="form-control" name="number_plates">         
            <div class="form-group">
                <label for="milage">Milage:</label> 
                <input type="number" class="form-control" name="milage">         
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
<!-- Car Add END //////////////-->

@endsection