@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
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
                @if (session('errors'))
                    <div class="alert alert-danger">
                    @foreach($errors->all() as $value)
                            <p>{{ $value }}</p>
                    @endforeach
                    </div>
                @endif

		        <form method="POST" action="{{ url()->current()}}/put">
		            <input type="hidden" name="_method" value="put">
		            <input type="hidden" name="_token" value="{{ csrf_token() }}">
		            <input type="hidden" name="id" value="{{ $data->id }}">
		            <div class="form-group">
		                <label for="manufacturer">Manufacturer:</label> 
		                <input type="text" class="form-control" name="manufacturer" value="{{ $data->manufacturer }}">     
		            </div>
		            <div class="form-group">
		                <label for="model">Model:</label> 
		                <input type="text" class="form-control" name="model" value="{{ $data->model }}">          
		            </div>
		            <div class="form-group">
		                <label for="color">Color:</label> 
		                <input type="text" class="form-control" name="color" value="{{ $data->color }}">         
		            </div>
		            <div class="form-group">
		                <label for="engine">Engine:</label> 
		                <input type="text" class="form-control" name="engine" value="{{ $data->engine }}">         
		            </div>
		            <div class="form-group">
		                <label for="vin">Vin:</label> 
		                <input type="text" class="form-control" name="vin" value="{{ $data->vin }}">         
		            </div>
		            <div class="form-group">
		                <label for="year">Year:</label> 
		                <input type="number" class="form-control" name="year" value="{{ $data->year }}">         
		            </div>
		            <div class="form-group">
		                <label for="number_plates">Number Plate:</label> 
		                <input type="text" class="form-control" name="number_plates" value="{{ $data->number_plates }}">         
		            <div class="form-group">
		                <label for="milage">Milage:</label> 
		                <input type="number" class="form-control" name="milage" value="{{ $data->milage }}">         
		            </div>
		            <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modaldelete" onClick="$(this).submit(function(e){e.preventDefault();
		});" data-dismiss="modal">Delete</button>
		            <button type="submit" class="btn btn-primary">Update information about car</button>
		            </div>
		        </form>

            </div>
        </div>
    </div>
</div>

<div id="modaldelete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Car Delete</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ url()->current()}}/delete">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="form-group">
                <label for="manufacturer">Manufacturer:</label> 
                <input type="text" class="form-control" name="manufacturer" disabled="true" value="{{ $data->manufacturer }}">     
            </div>
            <div class="form-group">
                <label for="model">Model:</label> 
                <input type="text" class="form-control" name="model" disabled="true" value="{{ $data->model }}">          
            </div>
            <div class="form-group">
                <label for="color">Color:</label> 
                <input type="text" class="form-control" name="color" disabled="true" value="{{ $data->color }}">         
            </div>
            <div class="form-group">
                <label for="engine">Engine:</label> 
                <input type="text" class="form-control" name="engine" disabled="true" value="{{ $data->engine }}">         
            </div>
            <div class="form-group">
                <label for="vin">Vin:</label> 
                <input type="text" class="form-control" name="vin" disabled="true" value="{{ $data->vin }}">         
            </div>
            <div class="form-group">
                <label for="year">Year:</label> 
                <input type="number" class="form-control" name="year" disabled="true" value="{{ $data->year }}">         
            </div>
            <div class="form-group">
                <label for="number_plates">Number Plate:</label> 
                <input type="text" class="form-control" name="number_plates" disabled="true" value="{{ $data->number_plates }}">         
            <div class="form-group">
                <label for="milage">Milage:</label> 
                <input type="number" class="form-control" name="milage" disabled="true" value="{{ $data->milage }}">         
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


@endsection
