@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Role</h3>

    <form action="{{ url('admin/role/update/'.$role->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
        </div>

        <button class="btn btn-primary">Update Role</button>
    </form>
</div>
@endsection
