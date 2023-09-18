@extends('layouts.app') {{-- Use your base layout if applicable --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirm Deletion</div>

                <div class="card-body">
                    <p>Are you sure you want to delete this item?</p>

                    <form method="POST" action="{{ route('user.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
