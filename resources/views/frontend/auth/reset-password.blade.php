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
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div id="login-box" class="col-md-12 shadow-none p-3 mb-5 bg-light rounded">
                    <form id="login-form" class="form" action="{{route('password.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="token"  value="{{ $token}}">
                        <h3 class="text-center text-primary">Reset Password</h3>
                        <div class="form-group">
                            <input type="text" name="email" placeholder="email" class="form-control">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="new password" class="form-control">
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="confirm password" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit"class="btn btn-primary btn-md" >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection