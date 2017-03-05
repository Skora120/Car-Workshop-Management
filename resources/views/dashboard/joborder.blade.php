@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <form method="POST" action="{{URL::to('dashboard/newclient/new')}}">
                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" name="passsword">
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number:</label>
                            <input type="tel" class="form-control" name="phone_number">
                        </div>

                    </form>

                    <hr>

                    <div>
                        <label for="description">Client Exists?</label>
                        <input type="radio" name="clientexist" onclick="existingClient(true)" value="1">Yes
                        <input type="radio" name="clientexist" onclick="existingClient(false)" value="0">No
                    </div>

                    <form method="POST" action="{{ url()->current() }}/new">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="description">Select Client:</label>
                            <select name="client_id">
                                <option value="1">Hard coded user</option>
                            </select>                            
                        </div>
                        <div class="form-group">
                            <label for="description">Select Car:</label>
                            <select name="car_id">
                                <option value="1">Hard coded car</option>
                            </select>  
                        </div>
                        <div class="form-group">
                            <label for="description">Job Description:</label>
                            <textarea rows="4" class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Pirority:</label>
                            <select name="pirority">
                                <option value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Urgent</option>
                            </select>  
                        </div>
                        <button type="submit" class="btn btn-primary">Add new order</button>
                    </form>

                    <script>
                        function existingClient(e){
                            if(e){
                                //append clients list
                            }else{
                                //append client add form
                            }
                        }




                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
