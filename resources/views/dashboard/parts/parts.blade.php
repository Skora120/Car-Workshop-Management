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

                <div class='row'>
                    <div class="col-md-12">
                            <input id="searchPart" class="form-control" type="text" placeholder="Type part car/description/part number">
                            <div id="searchPartList" class="list-group above"></div>
                    </div>
                </div>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Description</th> 
                            <th>For</th>  
                            <th>Amount</th>
                            <th>Part Number</th>              
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr onclick="redir('{{ $value['id'] }}');">
                            <td>{{$value['description']}}</td>
                            <td>{{$value['shortinfo']}}</td>
                            <td>{{$value['amount']}}</td>
                            <td>{{$value['part_number']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $data->links() }}

                <script>
                    $('#searchPart').keyup(function (e) {
                        var str = $(this).val();
                        if(str.length >= 3){
                            getPartsInformation(str);                                
                        }
                        if(str.length === 0){
                            $('#searchPartList').html('');
                        }
                        if(e.keyCode === 13){
                            window.location.href = "{{ url('/') }}/dashboard-employee/search/part/"+str;
                        }
                    });

                function appendInfromation(arg) {
                        $('#searchPartList').html('');
                        if(arg.length > 0){
                            for(var i = 0;i < arg.length; i++){
                                var description = arg[i].description;
                                if(description.length>30){
                                    description = description.substr(0,30)+"...";
                                }
                                var id = arg[i].id;

                                var item = "<a class='list-group-item list-group-item-action above-list-search' onClick='redir("+id+")'>"
                                    +"<div class='row '>"
                                        +"<div class='col-md-8 pull-left'>"
                                            +"<strong>"
                                                +"Description: "+description
                                            +"</strong>"
                                        +"</div>"
                                        +"<div class='col-md-4 pull-right'>"
                                            +"For: "+arg[i].shortinfo
                                        +"</div>"
                                    +"</div>"
                                        +"<div class='columns-12 row'>"
                                            +"<div class='col-md-8 pull-left'>Part Number:"
                                                +arg[i].part_number
                                            +"</div>"
                                        +"<div class='col-md-4 pull-right'>Amount: "
                                            +arg[i].amount
                                        +"</div>"
                                    +"</div>"
                                +"</a>";

                                $( "#searchPartList" ).append(item).hide().slideDown();     
                            }
                        }else{
                            var item = "<div class='list-group-item list-group-item-action above'>"+"Not Found"+"<div class='columns-4'>"+"</div>"+"</div>";
                            $( "#searchPartList" ).append(item).hide().slideDown();  
                        }
                    }


                    function getPartsInformation(arg) {
                        var link = "{{ route('searchPartAjax') }}";
                        $.ajax({
                            type : 'GET',
                            url : link,
                            beforeSend: function(xhr){
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                            },
                            data : {'search' : arg},
                            success:function(data){
                              console.log(data);
                              appendInfromation(data);
                            },
                            error: function(data){
                                console.log(data);
                            }
                        });
                    }

                    function redir(value){
                        window.location.href = "{{ url()->route('parts') }}/"+value;
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
            <form method="POST" action="{{ route('part-post') }}">
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
    <!-- End of addModal -->
</div>
@endsection
