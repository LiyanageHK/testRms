@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Roles</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ url('admin/role/create') }}" class="btn btn-primary mb-3">+ New Role</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td>{{ $r->name }}</td>
                    <td>
                        <a href="{{ url('admin/role/edit/'.$r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ url('admin/role/delete/'.$r->id) }}" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure to delete this role?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
