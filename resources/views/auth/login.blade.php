@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h3 class="text-center">{{ __('Login') }}</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">{{ __('Username') }}</label>
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                   name="username" value="{{ old('username') }}" required autofocus>

            @error('username')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   name="password" required>

            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
        </div>

        <a href="#" class="btn btn-link " data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
             {{ __('Forgot Your Password?') }}
        </a>


    </form>


@endsection
