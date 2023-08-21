@extends('frontend.layout.master')

@section('content')

<style>

#login .container #login-row #login-column #login-box {
  max-width: 600px;
  border: 1px solid #d7d7d7;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -45px;
}
</style>

<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 shadow-none p-3 mb-5 bg-light rounded">
                    <form id="login-form" class="form" action="{{route('registerPost')}}" method="post">
                        @csrf
                        <h3 class="text-center text-primary">Register</h3>
                        <div class="form-group">
                            <label for="username" class="text-dark">Username:</label><br>
                            <input type="text" name="username" id="username" class="form-control">
                            @error('username')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-dark">Email:</label><br>
                            <input type="text" name="email" id="email" class="form-control">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="text-dark">Confirm password:</label><br>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit"class="btn btn-primary btn-md" >
                                Submit
                            </button>
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="{{route('login')}}" class="text-primary">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection