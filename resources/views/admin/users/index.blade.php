@extends('admin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="mb-4">
    <h4>Manage Users</h4>
    <p class="text-muted">View and manage all registered users</p>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id_number }}</td>
                            <td>
                                <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->department }}</td>
                            <td>
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'department' ? 'bg-warning' : 'bg-primary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->id != auth()->id())
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#manageModal{{ $user->id }}">
                                        <i class="fas fa-cog"></i> Manage
                                    </button>
                                @else
                                    <span class="text-muted">Current User</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Manage User Modal -->
                        <div class="modal fade" id="manageModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Manage User: {{ $user->first_name }} {{ $user->last_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong> After changing a user's role, they must log out and log back in for the changes to take effect.
                                        </div>
                                        
                                        <h6>Change Role</h6>
                                        <form method="POST" action="{{ route('admin.users.change-role', $user->id) }}" class="mb-3">
                                            @csrf
                                            <div class="input-group">
                                                <select name="role" class="form-select">
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="department" {{ $user->role == 'department' ? 'selected' : '' }}>Department Staff</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>

                                        <h6>Change Status</h6>
                                        <form method="POST" action="{{ route('admin.users.change-status', $user->id) }}">
                                            @csrf
                                            <div class="input-group">
                                                <select name="status" class="form-select">
                                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection