@extends('layouts.app')

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
                <details>
                    <summary>Add client form</summary>
                    <form method="POST" action="{{URL::to('dashboard/newclient/new')}}">
                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login">
                            @if($errors->has('login'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" name="passsword">
                            @if($errors->has('passsword'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('passsword') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name">
                            @if($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number:</label>
                            <input type="tel" class="form-control" name="phone_number">
                            @if($errors->has('phone_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>

                    </form>
                </details>

                    <hr>

                    <div>
                        <label for="description">Client Exists?</label>
                        <input type="radio" name="clientexist" onclick="existingClient(true)" value="1">Yes
                        <input type="radio" name="clientexist" onclick="existingClient(false)" value="0">No
                    </div>

                    <form method="POST" action="{{ url()->current() }}/post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="description">Select Client:</label>
                            <select name="client_id">
                                <option value="1">Hard coded user</option>
                            </select>  
                            @if($errors->has('client_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('client_id') }}</strong>
                                </span>
                            @endif                     
                        </div>
                        <div class="form-group">
                            <label for="description">Select Car:</label>
                            <select name="car_id">
                                <option value="1">Hard coded car</option>
                            </select>  
                            @if($errors->has('car_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('car_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Job Description:</label>
                            <textarea rows="4" class="form-control" name="description"></textarea>
                            @if($errors->has('description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Pirority:</label>
                            <select name="pirority">
                                <option value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Urgent</option>
                            </select> 
                            @if($errors->has('pirority'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pirority') }}</strong>
                                </span>
                            @endif
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