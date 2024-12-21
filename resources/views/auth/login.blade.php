@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <form action="{{ route('login') }}" method="POST" class="p-4 border rounded shadow-sm bg-light" style="width: 300px;">
        @csrf
        <h3 class="mb-3 text-center">Login</h3>
        <div class="mb-3">
            <input type="text" class="form-control" name="identifier" placeholder="Username or Email" required>
            @error('identifier')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="remember" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember Me</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="mt-3 text-center">
            <small>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></small>
        </div>
    </form>
</div>
@endsection