@extends('layouts.app')

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

                <button class="btn btn-primary" data-toggle="modal" data-target="#detailAdd">Add new detail</button>
                <a href="{{ url()->current() }}/edit"><button class="btn btn-primary">Edit</button></a>
                <pre>{{print_r($data,true)}}</pre>
				<pre>{{print_r($details,true)}}</pre>

                <!-- Add Detail Modal  https://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
                <div id="detailAdd" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Detail</h4>
                      </div>
                      <div class="modal-body">
                        <form method="POST" action="{{ url()->current()}}/detailAdd">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="joborder_id" value="{{$data->id}}">
                            <div class="form-group">
                                <label for="description">Description</label> 
                                <textarea rows="4" class="form-control" name="description"></textarea>            
                            </div>
                            <div class="form-group">
                                <label for="status">Progress</label> 
                                    <select name="status">
                                        <option value="1">In order</option>
                                        <option value="2">In progress</option>
                                        <option value="3">Done</option>
                                    </select>   
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>






            </div>
        </div>
    </div>
</div>
@endsection
