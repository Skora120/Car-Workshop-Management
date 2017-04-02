@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard <button class="btn btn-danger pull-right" onClick="deleteOrder({{$data->id}});"> Delete order</button></div>
                <div class="panel-body">
               <!--  <pre>//{{ print_r($data, true)}}</pre> -->

                    <!-- Edit Detail Modal  https://www.w3schools.com/bootstrap/bootstrap_modal.asp -->
                    <div id="detailEdit" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Detail Edit</h4>
                          </div>
                          <div class="modal-body">
                            <form id="editModal" method="POST" action="{{ url()->current()}}/detailEdit">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input id="idedit" type="hidden" name="id">
                                <div class="form-group">
                                    <label for="description">Description</label> 
                                    <textarea id="descriptionedit" rows="4" class="form-control" name="description">asd</textarea>            
                                </div>
                                <div class="form-group">
                                    <label for="status">Progress</label> 
                                        <select id="statusedit" name="status">
                                            <option value="1">In order</option>
                                            <option value="2">In progress</option>
                                            <option value="3">Done</option>
                                        </select>   
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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url()->current()}}/put">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="form-group">
                            <label for="client_id">Client:</label>
                            <input type="text" class="form-control" value="{{$data->client_id}}" name="client_id">
                        </div>
                        <div class="form-group">
                            <label for="car_id">Car:</label> 
                            <input type="text" class="form-control" value="{{$data->car_id}}" name="car_id">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea rows="4" class="form-control" name="description" id="textarea">{{$data->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="progress">Progress:</label>
                            <select id="progress" name="progress">
                                <option value="1">In order</option>
                                <option value="2">In progress</option>
                                <option value="3">Done</option>
                            </select>     
                        </div>
                        <div class="form-group">
                            <label for="pirority">Pirority:</label>
                            <select id="pirority" name="pirority">
                                <option value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Urgent</option>
                            </select>                             
                        </div>

                        <button class="btn btn-primary" type="submit"> Update main information</button>
                    </form>

                    <hr>

                    <script>
                        $('#progress').find('option[value={{$data->progress}}]').attr("selected", true).change();
                        $('#pirority').find('option[value={{$data->pirority}}]').attr("selected", true).change();
                    </script>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="row">
                            @foreach($data->details as $key => $value)
                                <tr>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->employee_id}}</td>
                                    <td id="desc{{$value->id}}">{{$value->description}}</td>
                                    <td id="stat{{$value->id}}">{{$value->status}}</td>
                                    <td style="width:20%">
                                        <div style="display:flex;">
                                            <div style="width: 55%">
                                                <img id="e{{$value->id}}" class="img-responsive" onClick="editModal($(this).attr('id'))" data-toggle="modal" data-target="#detailEdit" src="{{asset('img/edit.png')}}">
                                            </div>
                                            <div style="width: 45%">

                                                <a id="d{{$value->id}}" onClick="deleteForm($(this).attr('id'))">
                                                    <img class="img-responsive" src="{{asset('img/delete.png')}}">
                                                </a>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <script>
                            function deleteForm(arg) {
                                var id = arg.slice(1);
                                $('#detailId').val(id);
                                $('#detaildelform').submit();
                            }

                            function editModal(arg) {
                                var id = arg.slice(1);
                                var description = $('#desc'+id).text();
                                var status = $('#stat'+id).text();
                                $('#idedit').val(id);
                                $('#descriptionedit').val(description);
                                $('#statusedit').val(status);
                            }

                            function deleteOrder(arg) {
                                $('#orderId').val(arg);
                                $('#deleteOrderForm').submit();
                            }
                        </script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>         

<div class="hidden">
    <form id="detaildelform" method="POST" action="{{ url()->current()}}/detailDelete">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="detailId" type="text" name="id">
    </form>
</div>

<div class="hidden">
    <form id="deleteOrderForm" method="POST" action="{{ url()->current()}}/delete">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="orderId" type="text" name="id">
    </form>
</div>


@endsection
