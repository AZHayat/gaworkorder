@extends('layouts.app')

@section('title', 'Setting Profil')

@section('content')
<div class="container">
    <h3 class="mb-4">Setting Profil</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('setting.profil.update') }}">
        @csrf

        <!-- Username (Readonly) -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input id="username" type="text" class="form-control" 
                   value="{{ $user->username }}" readonly>
        </div>

        <!-- Role (Readonly) -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input id="role" type="text" class="form-control" 
                   value="{{ $user->role }}" readonly>
        </div>

        <!-- Nama (Bisa diubah) -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <!-- Password Baru (Opsional) -->
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru (Opsional)</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password">
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-3">
            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control"
                   name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
