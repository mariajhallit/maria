@extends('layouts.app')

@section('title', 'Update User')

@section('content')
<div class="container">
    <h1>Update User</h1>
    <form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- Add more input fields for other user attributes as needed -->

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
