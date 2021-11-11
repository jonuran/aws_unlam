@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-10 col-lg-6 mx-auto">
            <form class="bg-white shadow rounded py-3 px-4"
                method="POST" 
                action="{{ route('register') }}"
            >
                @csrf
                <h1 class="display-4">{{ __('Register') }}</h1>
                <hr>
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input class="form-control bg-light shadow-sm @error('name') is-invalid @else border-0 @enderror"
                    type="text" 
                    name="name"
                    placeholder="Escribe aquí tu nombre..."
                    value="{{ old('name') }}"
                    id="name" 
                    autocomplete="name" 
                    autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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

                <div class="form-group">
                    <label for="subject">{{ __('Confirm Password') }}</label>
                    <input class="form-control bg-light shadow-sm @error('password_confirmation') is-invalid @else border-0 @enderror"
                        id="password-confirm"
                        name="password_confirmation"
                        type="password"
                        placeholder="Reescribe tu contraseña aquí..."
                        value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Login') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
