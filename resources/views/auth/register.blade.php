@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <form action="{{ route('register') }}" method="POST" class="p-4 border rounded shadow-sm bg-light" style="width: 300px;">
        @csrf
        <h3 class="mb-3 text-center">Sign Up</h3>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="regbtn">Register</button>
        <div class="mt-3 text-center">
            <small>Already have an account? <a href="{{ route('login') }}">Sign in</a></small>
        </div>
    </form>
</div>
@endsection