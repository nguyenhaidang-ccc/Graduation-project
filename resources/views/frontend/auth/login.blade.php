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
#login-form .password-container {
    position: relative;
}

#login-form .toggle-password {
    position: absolute;
    top: 75%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>

<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 shadow-none p-3 mb-5 bg-light rounded">
                    <form id="login-form" class="form" action="{{route('loginPost')}}" method="post">
                    @csrf
                        <h3 class="text-center text-primary">Login</h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="email" class="text-dark">Email:</label><br>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group password-container">
                            <label for="password" class="text-dark">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="toggle-password">👁️</span>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <a href="{{ route('password.request') }}" class="text-primary">Forgot password?</a>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-md">Login</button>
                        </div>

                        <div id="register-link" class="text-right">
                            <a href="{{ route('register') }}" class="text-primary">Resgister here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.querySelector('#login-form .toggle-password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
    </script>

@endsection