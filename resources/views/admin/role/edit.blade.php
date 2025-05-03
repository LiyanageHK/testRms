@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Role</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="role">Role Name</label>
                                    <input type="text" name="role" id="role" class="form-control" value="{{ old('role', $role->role) }}" required>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $role->description) }}" required>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Permission Toggles with Friendly Labels -->
                        <div class="mb-3">
                            <h5>Permissions</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="sales" data-permission="sales" {{ $permissions->sales ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sales">Sales Management</label>
                                    </div>
        
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="cus_care" data-permission="cus_care" {{ $permissions->cus_care ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cus_care">Customer Care</label>
                                    </div>
        
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="chatbot" data-permission="chatbot" {{ $permissions->chatbot ? 'checked' : '' }}>
                                        <label class="form-check-label" for="chatbot">Chatbot Access</label>
                                    </div>
        
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="cat" data-permission="cat" {{ $permissions->cat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat">Category Management</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="product" data-permission="product" {{ $permissions->product ? 'checked' : '' }}>
                                        <label class="form-check-label" for="product">Product Management</label>
                                    </div>
        
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="user" data-permission="user" {{ $permissions->user ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user">User Management</label>
                                    </div>
        
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-toggle" type="checkbox" id="roles" data-permission="roles" {{ $permissions->roles ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roles">Role Management</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.permission-toggle').change(function() {
            const permission = $(this).data('permission');
            const status = this.checked ? 1 : 0; 

            $.ajax({
                url: '/admin/update_permission', 
                method: 'POST',
                data: {
                    role_id: '{{ $role->id }}', 
                    permission: permission,
                    status: status,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    console.log('Permission updated successfully:', response);
                },
                error: function(xhr, status, error) {
                    console.error("Error updating permission:", error);
                }
            });
        });
    });
</script>
@endsection
