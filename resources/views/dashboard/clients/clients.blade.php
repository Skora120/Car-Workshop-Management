@extends('layouts.appEmployee')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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

                    <div class='row'>
                        <div class="col-md-12">
                                <input id="searchClient" class="form-control" type="text" placeholder="Type customer's name">
                                <div id="searchClistnList" class="list-group above"></div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Cars count</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $value)
                            <tr onclick="redir('{{$value['id']}}');">
                                <td>{{$value['id']}}</td>
                                <td>{{$value['name']}}</td>
                                <td>{{$value['phone_number']}}</td>
                                <td>{{$value['cars_count']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        $('#searchClient').keyup(function (e) {
                            var str = $(this).val();
                            if(str.length >= 3){
                                getClientInformation(str);                                
                            }
                            if(str.length === 0){
                                $('#searchClistnList').html('');
                            }
                            if(e.keyCode === 13){
                                window.location.href = "{{ route('search') }}/client/"+str;
                            }
                        });

                        function appendInfromation(arg) {
                                $('#searchClistnList').html('');
                                if(arg.length > 0){
                                    for(var i = 0;i < arg.length; i++){
                                        var id = arg[i].id;

                                        var item = "<a class='list-group-item list-group-item-action above-list-search' onClick='redir("+id+")'>"
                                            +"<div class='row text-center'>"
                                                +"<strong>"
                                                    +"Name: "+arg[i].name
                                                +"</strong>"
                                            +"</div>"
                                                +"<div class='columns-12 row'>"
                                                    +"<div class='col-md-6 pull-left'>Email:"
                                                        +arg[i].email
                                                    +"</div>"
                                                +"<div class='col-md-6 pull-right'>Phone Number: "
                                                    +arg[i].phone_number
                                                +"</div>"
                                            +"</div>"
                                        +"</a>";

                                        $( "#searchClistnList" ).append(item).hide().slideDown();     
                                    }
                                }else{
                                    var item = "<div class='list-group-item list-group-item-action above'>"+"Not Found"+"<div class='columns-4'>"+"</div>"+"</div>";
                                    $( "#searchClistnList" ).append(item).hide().slideDown();  
                                }
                            }


                        function getClientInformation(arg) {
                            var link = "{{ route('searchClientAjax') }}";
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
                            window.location.href = "{{ url()->current() }}/"+value;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
