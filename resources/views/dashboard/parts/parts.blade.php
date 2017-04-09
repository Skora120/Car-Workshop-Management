@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard

            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Part</button>
            </div>

            <div class="panel-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <pre>{{print_r($data,true)}}</pre>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Description</th> 
                            <th>For</th>  
                            <th>Amount</th>
                            <th>Employee</th>
                            <th>Part Number</th>
                            <th>Manage</th>
                        
                                           
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr>
                            <td id="desc{{$value['id']}}">{{$value['description']}}</td>
                            <td id="shortinfo{{$value['id']}}">{{$value['shortinfo']}}</td>
                            <td id="amount{{$value['id']}}">{{$value['amount']}}</td>
                            <td>{{$value['employee']}}</td>
                            <td id="part{{$value['id']}}">{{$value['part_number']}}</td>
                            <td style="width:20%">
                                <div style="display:flex;">
                                    <div style="width: 55%">
                                        <img id="e{{$value['id']}}" class="img-responsive" onClick="editModal($(this).attr('id'))" data-toggle="modal" data-target="#editmodal" src="{{asset('img/edit.png')}}">
                                    </div>
                                    <div style="width: 45%">
                                        <img id="d{{$value['id']}}" class="img-responsive" onClick="deleteModal($(this).attr('id'))" data-toggle="modal" data-target="#deleteModal" src="{{asset('img/delete.png')}}">
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <script>
                    function deleteModal(arg) {
                        var id = arg.slice(1);
                        var description = $('#desc'+id).text();
                        var shortinfo = $('#shortinfo'+id).text();
                        $('#iddelete').val(id);
                        $('#shortinfodelete').val(shortinfo);
                        $('#descriptiondelete').val(description);
                    }

                    function editModal(arg) {
                        var id = arg.slice(1);
                        var description = $('#desc'+id).text();
                        var shortinfo = $('#shortinfo'+id).text();
                        var amount = $('#amount'+id).text();
                        var part = $('#part'+id).text();
                        $('#idedit').val(id);
                        $('#shortinfoedit').val(shortinfo);
                        $('#descriptionedit').val(description);
                        $('#amountedit').val(amount);
                        $('#numberedit').val(part);
                    }
                </script>
            </div>
        </div>
    </div>

    <!-- Add Modal  https://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
    <div id="addModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Part Delete</h4>
          </div>
          <div class="modal-body">
            <form id="editModal" method="POST" action="{{ url()->current()}}/post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="description">Description</label> 
                    <textarea rows="4" class="form-control" name="description"></textarea>            
                </div>
                <div class="form-group">
                    <label for="shortinfo">For</label> 
                    <input type="text" name="shortinfo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label> 
                    <input type="number" name="amount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="part number">Part Number</label> 
                    <input type="text" name="part_number" class="form-control">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" onClick="$(this).submit(function(e){e.preventDefault();
});" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Part</button>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    <!-- End of deleteModal -->

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
            <form id="deleteModalForm" method="POST" action="{{ url()->current()}}/delete">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="iddelete" type="hidden" name="id">
                <div class="form-group">
                    <label for="description">Description</label> 
                    <textarea id="descriptiondelete" disabled="true" rows="4" class="form-control" name="description">asd</textarea>            
                </div>
                <div class="form-group">
                    <label for="shortinfo">For</label> 
                    <input id="shortinfodelete" disabled="true" type="text" name="shortinfo" class="form-control">
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
    <div id="editmodal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Part Edit</h4>
          </div>
          <div class="modal-body">
            <form id="editModal" method="POST" action="{{ url()->current()}}/put">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="idedit" type="hidden" name="id">
                <div class="form-group">
                    <label for="description">Description</label> 
                    <textarea id="descriptionedit" rows="4" class="form-control" name="description">asd</textarea>            
                </div>
                <div class="form-group">
                    <label for="for">For</label> 
                    <input id="shortinfoedit" type="text" name="shortinfo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label> 
                    <input id="amountedit" type="number" name="amount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="part number">Part Number</label> 
                    <input id="numberedit" type="text" name="part_number" class="form-control">
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
