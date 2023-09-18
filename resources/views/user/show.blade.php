@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <table class="table">
        <tbody>
            <tr>
                <th>Name:</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $user->email }}</td>
            </tr>
            <!-- Add more rows for other user attributes as needed -->
        </tbody>
    </table>
    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit User</a>
    <a href="{{ route('user.index') }}" class="btn btn-secondary">Back to Users</a>
</div>
@endsection
