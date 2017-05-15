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

                    <div id='exists'>
                        <label for="description">Customer Exists?</label>
                        <input type="radio" name="clientexist" onclick="existingClient(true)">Yes
                        <input type="radio" name="clientexist" onclick="existingClient(false)">No
                    </div>

                    <!-- Add Client Ajax "form" -->
                    <div id="addClient" class="hide">

                        <p>Customer Infromation</p>
                        <div class="form-group">

                            <label for="email">Email:</label>
                            <input id="acEmail" type="email" class="form-control">
                            <span id="aerroremail" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input id="acName" type="text" class="form-control">
                            <span id="aerrorname" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone number:</label>
                            <input id="acTel" type="tel" class="form-control">
                            <span id="aerrorTel" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>
                        </div>

                        <hr>

                        <p>Car Infromation</p>
                        <div class="form-group">
                            <label for="manufacturer">Manufacturer:</label> 
                            <input id="acManufacturer" type="text" class="form-control">
                            <span id="aerrormanufacturer" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span> 
                        </div>
                        <div class="form-group">
                            <label for="model">Model:</label> 
                            <input id="acModel" type="text" class="form-control">
                            <span id="aerrormodel" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>       
                        </div>
                        <div class="form-group">
                            <label for="color">Color:</label> 
                            <input id="acColor" type="text" class="form-control">
                            <span id="aerrorcolor" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>      
                        </div>
                        <div class="form-group">
                            <label for="engine">Engine:</label> 
                            <input id="acEngine" type="text" class="form-control">
                            <span id="aerrorengine" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>    
                        </div>
                        <div class="form-group">
                            <label for="vin">Vin:</label> 
                            <input id="acVin" type="text" class="form-control">
                            <span id="aerrorvin" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>     
                        </div>
                        <div class="form-group">
                            <label for="year">Year:</label> 
                            <input id="acYear" type="number" class="form-control">
                            <span id="aerroryear" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span> 
                        </div>
                        <div class="form-group">
                            <label for="number_plates">Number Plate:</label> 
                            <input id="acNumberPlates" type="text" class="form-control">
                            <span id="aerrorplates" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>
                        </div>         
                        <div class="form-group">
                            <label for="milage">Milage:</label> 
                            <input id="acMilage" type="number" class="form-control">
                            <span id="aerrormilage" class="text-danger">
                                <strong class="clearErrors"></strong>
                            </span>    
                        </div>
                        <button id="CustomerAddButton" class="btn btn-primary" onClick="ajaxAddNewClient()">Save Client</button>
                    </div>

                    <!-- Add Order Ajax "form" after adding new Client -->
                    <div id="addOrderAfterClient" class="hide">
                        <p>Create new Job Order</p>
                        <input id="acClientId" type="hidden">
                        <input id="acCarId" type="hidden">
                        <div class="form-group">
                            <label for="name">Customer Name: <span id=acClientName></span></label>
                        </div>
                        <div class="form-group">
                            <label for="name">Car: <span id=acCarName></span></label>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="acDescription" class="form-control" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <select id="acPirority" class="form-control">
                                <option selected value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Urgent</option>
                            </select>
                        </div>
                        <button id="CustomerAddButton" class="btn btn-primary" onClick="ajaxAddNewOrder()">Save New Order</button>
                        </div>

                    <!-- Add Order Ajax "form" to existing Client -->
                    <!-- add hide class -->
                    <div id="addOrderExistClient" class="hide"> 
                        <div id="searchClientDiv" class="col-md-12">
                            <input id="searchClientInput" class="form-control" type="text" placeholder="Type customer name">
                        </div>

                      <div class="col-md-12">
                        <div id="searchCustomer" class="list-group above"></div>
                      </div>

                      <div>
                          <div id="inputNewOrder" class="hide">
                            <p>Create new Job Order</p>
                            <input id="aoeClientId" type="hidden">
                            <div class="form-group">
                                <label for="name">Customer Name: <span id="aoeClientName"></span></label>
                            </div>
                            <div class="form-group">
                                <label for="name">Select Car:</label>
                                <select id="aoeCar" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="aoeDescription" class="form-control" rows="4" cols="50"></textarea>
                            </div>
                            <div class="form-group">
                                <select id="aoePirority" class="form-control">
                                    <option selected value="1">Normal</option>
                                    <option value="2">High</option>
                                    <option value="3">Urgent</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" onClick="addNewOrderFromExistingClient()">Save New Order</button>
                            </div>
                        </div>

                    <script>
                        $('#searchClientInput').keyup(function (e) {
                            var str = $(this).val();
                            if(str.length >= 3){
                                getExistingClient(str);                                
                            }
                            if(str.length === 0){
                                $('#searchCustomer').html('');
                            }
                        });

                        function existingClient(e) {
                            if(e){
                                $('#exists').hide();
                                $('#addOrderExistClient').removeClass('hide');
                            }else{
                                $('#exists').hide();
                                $('#addClient').removeClass('hide');
                            }
                        }

                        function clientExistsList(arg) {
                            $('#searchCustomer').html('');
                            if(arg.length > 0){
                                for(var i = 0;i < arg.length; i++){
                                    var cars = "";

                                    var devided;
                                    switch(arg[i].cars.length){
                                        case 1:
                                            devided = 12;
                                            break;
                                        case 2:
                                            devided = 6;
                                            break;
                                        default:
                                            devided = 4;
                                    }


                                    if(arg[i].cars.length <= 3){
                                        for(var j = 0; j < arg[i].cars.length; j++){
                                            var manufacturer = arg[i].cars[j].manufacturer;
                                            var model = arg[i].cars[j].model;
                                            var carinfo = "<div id='ecid' class='col-md-"+devided+" text-center'>"+manufacturer+" "+model+"</div>";
                                            cars+=carinfo;
                                        }
                                    }

                                    var item = "<a id='ex"+arg[i].client_id+"' class='list-group-item list-group-item-action above-list-search' onClick='appendExistingInformation($(this))'>"
                                        +"<div class='columns-12'>"
                                        +"<div class='col-md-8 pull-left'><strong>"
                                        +arg[i].name
                                        +"</strong></div>"
                                        +"<div class='col-md-4'>"
                                        +" Amount of Cars: "+arg[i].cars.length
                                        +"</div>"
                                        +"</div>"
                                        +"<div class='columns-12 row'>"
                                        +cars
                                        +"</div>"
                                    +"</a>";

                                    $( "#searchCustomer" ).append(item).hide().slideDown();     
                                }
                            }else{
                                var item = "<div class='list-group-item list-group-item-action above'>"+"Not Found"+"<div class='columns-4'>"+"</div>"+"</div>";
                                $( "#searchCustomer" ).append(item).hide().slideDown();  
                            }
                        }

                        function appendExistingInformation(arg) {
                            $("#searchClientDiv").hide()
                            var client_id = arg[0].id;
                            client_id = client_id.slice(2);
                            var client_name = arg.children().children()[0].innerHTML;

                            $('#aoeClientId').val(client_id);
                            $('#searchCustomer').html('');
                            $('#aoeClientName').html(client_name);

                            var link = "{{ route('clientCarsAjax') }}";
                            $.ajax({
                                type : 'GET',
                                url : link,
                                beforeSend: function(xhr){
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                },
                                data : {'client_id' : client_id},
                                success:function(data){
                                    fillSelectInformation(data);
                                },
                                error: function(data){
                                    $("#CustomerAddButton").attr("disabled", false);
                                    var errors = data.responseJSON;
                                }
                            });
                            $('#inputNewOrder').removeClass('hide');
                        }

                        function fillSelectInformation(arg) {
                            for(var i = 0; i < arg.length; i++){
                                var select = "<option value='"+arg[i].id+"'>"+arg[i].manufacturer+" "+arg[i].model+" "+arg[i].number_plates+"</option>"
                                $('#aoeCar').append(select);
                            }
                        }
                        function addNewOrderFromExistingClient() {
                            var link = "{{ route('createJobAjax') }}";
                            var information = {
                                client_id: $('#aoeClientId').val(),
                                car_id: $('#aoeCar option:selected').val(),
                                description: $('#aoeDescription').val(),
                                pirority: $('#aoePirority option:selected').val(),
                            }

                            $.ajax({
                                type : 'POST',
                                url : link,
                                beforeSend: function(xhr){
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                },
                                data : information,
                                success:function(data){
                                    window.location.href = "{{ url('/') }}/dashboard-employee/jobs/"+data;
                                },
                                error: function(data){
                                    $("#CustomerAddButton").attr("disabled", false);
                                    var errors = data.responseJSON;
                                }
                            });
                        }

                        function addOrderData(arg) {
                            $('#acClientId').attr("value", arg.clientId);
                            $('#acCarId').attr("value", arg.carId);
                            $('#acClientName').html(arg.name);
                            $('#acCarName').html(arg.manufacturer+" "+arg.model); 
                        }

                        function newClientErrors(arg) {

                            if(arg.email){
                                var str = "";
                                for(var i = 0; i< arg.email.length; i++){
                                    str+=arg.email[i]+" ";
                                }
                                $('#aerroremail').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.name){
                                var str = "";
                                for(var i = 0; i< arg.name.length; i++){
                                    str+=arg.name[i]+" ";
                                }
                                $('#aerrorname').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.phone_number){
                                var str = "";
                                for(var i = 0; i< arg.phone_number.length; i++){
                                    str+=arg.phone_number[i]+" ";
                                }
                                $('#aerrorTel').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.manufacturer){
                                var str = "";
                                for(var i = 0; i< arg.manufacturer.length; i++){
                                    str+=arg.manufacturer[i]+" ";
                                }
                                $('#aerrormanufacturer').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.model){
                                var str = "";
                                for(var i = 0; i< arg.model.length; i++){
                                    str+=arg.model[i]+" ";
                                }
                                $('#aerrormodel').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.color){
                                var str = "";
                                for(var i = 0; i< arg.color.length; i++){
                                    str+=arg.color[i]+" ";
                                }
                                $('#aerrorcolor').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.engine){
                                var str = "";
                                for(var i = 0; i< arg.engine.length; i++){
                                    str+=arg.engine[i]+" ";
                                }
                                $('#aerrorengine').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.vin){
                                var str = "";
                                for(var i = 0; i< arg.vin.length; i++){
                                    str+=arg.vin[i]+" ";
                                }
                                $('#aerrorvin').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.year){
                                var str = "";
                                for(var i = 0; i< arg.year.length; i++){
                                    str+=arg.year[i]+" ";
                                }
                                $('#aerroryear').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.number_plates){
                                var str = "";
                                for(var i = 0; i< arg.number_plates.length; i++){
                                    str+=arg.number_plates[i]+" ";
                                }
                                $('#aerrorplates').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                            if(arg.milage){
                                var str = "";
                                for(var i = 0; i< arg.milage.length; i++){
                                    str+=arg.milage[i]+" ";
                                }
                                $('#aerrormilage').html("<strong class=\"clearErrors\">"+str+"</strong>");
                            }
                        }

                        function ajaxAddNewClient() {
                            $("#CustomerAddButton").attr("disabled", true);
                            $('.clearErrors').each(function(){
                                $(this).remove();
                            });

                            var link = "{{ route('createClientAjax') }}";
                            var information = {
                                email: $('#acEmail').val(),
                                name: $('#acName').val(),
                                phone_number: $('#acTel').val(),
                                manufacturer: $('#acManufacturer').val(),
                                model: $('#acModel').val(),
                                color: $('#acColor').val(),
                                engine: $('#acEngine').val(),
                                vin: $('#acVin').val(),
                                year: $('#acYear').val(),
                                number_plates: $('#acNumberPlates').val(),
                                milage: $('#acMilage').val(),
                            }

                            $.ajax({
                                type : 'POST',
                                url : link,
                                beforeSend: function(xhr){
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                },
                                data : information,
                                success:function(data){
                                    $('#addClient').hide();
                                    $('#addOrderAfterClient').removeClass('hide');
                                    addOrderData(data);
                                },
                                error: function(data){
                                    $("#CustomerAddButton").attr("disabled", false);
                                    var errors = data.responseJSON;
                                    newClientErrors(errors);
                                }
                            });
                        }

                        function ajaxAddNewOrder() {
                            var link = "{{ route('createJobAjax') }}";
                            var information = {
                                client_id: $('#acClientId').val(),
                                car_id: $('#acCarId').val(),
                                description: $('#acDescription').val(),
                                pirority: $('#acPirority option:selected').val(),
                            }

                            $.ajax({
                                type : 'POST',
                                url : link,
                                beforeSend: function(xhr){
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                },
                                data : information,
                                success:function(data){
                                    window.location.href = "{{ url('/') }}/dashboard-employee/jobs/"+data;
                                },
                                error: function(data){
                                    $("#CustomerAddButton").attr("disabled", false);
                                    var errors = data.responseJSON;
                                }
                            });
                        }

                        function getExistingClient(arg) {
                            var link = "{{ route('clientSearchAjax') }}";
                            $.ajax({
                                type : 'GET',
                                url : link,
                                beforeSend: function(xhr){
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                },
                                data : {'search' : arg},
                                success:function(data){
                                    clientExistsList(data);
                                },
                                error: function(data){
                                    $("#CustomerAddButton").attr("disabled", false);
                                    var errors = data.responseJSON;
                                    newClientErrors(errors);
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection