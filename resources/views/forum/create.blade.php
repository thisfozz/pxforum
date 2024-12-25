@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Create a New Topic</h3>

        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Topic Name</label>
                <input type="text" id="title" name="title" class="form-control" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-success" type="submit">Create Topic</button>
        </form>
    </div>
@endsection