@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-10 col-lg-6 mx-auto">

            <form class="bg-white shadow rounded py-3 px-4"
                method="POST"
                action="{{ route('login') }}"
            >
                @csrf
                <h1 class="display-4">{{ __('Login') }}</h1>
                <hr>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input class="form-control bg-light shadow-sm @error('email') is-invalid @else border-0 @enderror"
                        type="text"
                        name="email"
                        placeholder="Escribe aquí tu e-mail..."
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="subject">{{ __('Password') }}</label>
                    <input class="form-control bg-light shadow-sm @error('password') is-invalid @else border-0 @enderror"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Escribe tu contraseña aquí..."
                        value="{{ old('password') }}">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Login') }}</button>
            </form>

        </div>
    </div>
</div>
@endsection
