@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard
            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit Part</button>
            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Part</button>

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


                <pre>{{ print_r($data, true) }}</pre>



            </div>
        </div>
    </div>
    <!-- Delete Modal  https://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Part Delete</h4>
          </div>
          <div class="modal-body">
            <form id="deleteModalForm" method="POST" action="{{ url()->current() }}/delete">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data[0]->id }}">
                <div class="form-group">
                    <label for="description">Description</label> 
                    <textarea disabled="true" rows="4" class="form-control" name="description">{{ $data[0]->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="shortinfo">For</label> 
                    <input disabled="true" type="text" class="form-control" name="shortinfo" value="{{ $data[0]->shortinfo }}">
                </div>
                <div class="form-group">
                    <label for="part_number">Part Number</label> 
                    <input disabled="true" type="text" class="form-control" name="part_number" value="{{ $data[0]->shortinfo }}">
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
    <!-- End of deleteModal -->


    <!-- Edit Modal  https://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Part Edit</h4>
          </div>
          <div class="modal-body">
            <form id="editModal" method="POST" action="{{ url()->current() }}/put">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data[0]->id }}">
                <div class="form-group">
                    <label for="description">Description</label> 
                    <textarea rows="4" class="form-control" name="description">{{ $data[0]->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="shortinfo">For</label> 
                    <input type="text" class="form-control" name="shortinfo" value="{{ $data[0]->shortinfo }}">
                </div>
                <div class="form-group">
                    <label for="part_number">Part Number</label> 
                    <input type="text" class="form-control" name="part_number" value="{{ $data[0]->shortinfo }}">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label> 
                    <input type="number" class="form-control" name="amount" value="{{ $data[0]->amount }}">
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
    <!-- End of editModal -->
</div>
@endsection
