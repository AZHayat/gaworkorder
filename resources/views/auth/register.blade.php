@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <h3 class="text-center">{{ __('Register') }}</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                   name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                   name="username" value="{{ old('username') }}" required>
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

        <div class="mb-3">
            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" 
                   name="password_confirmation" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
        </div>

        <div class="text-center mt-3">
            <span>Sudah punya akun?</span> 
            <a href="{{ route('login') }}">{{ __('Login di sini') }}</a>
        </div>
    </form>
@endsection
