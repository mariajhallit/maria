@extends('layouts.app') {{-- You can customize your layout as needed --}}

@section('content')
    <h1>User List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($user as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('user', $user->id) }}" class="btn btn-primary">View</a>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
