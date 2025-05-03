@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create New Role</h3>

    <form action="{{ url('admin/role/store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-success">Save Role</button>
    </form>
</div>
@endsection
