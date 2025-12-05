@extends('admin.layouts.app')

@section('title', 'Manage Equipment')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Manage Equipment</h4>
        <p class="text-muted mb-0">Add, edit, or remove equipment from inventory</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Add Equipment
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Available</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ $item->image_url }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ $item->category->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><span class="badge bg-success">{{ $item->available_quantity }}</span></td>
                            <td>
                                <span class="badge {{ $item->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick='editEquipment(@json($item))'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.equipment.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this equipment?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No equipment found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.equipment.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Equipment Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Equipment Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">JPG, PNG, or GIF (Max 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Equipment Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Equipment Name *</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category_id" id="edit_category" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Quantity *</label>
                            <input type="number" name="quantity" id="edit_quantity" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Available *</label>
                            <input type="number" name="available_quantity" id="edit_available" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div id="current_image_preview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editEquipment(item) {
    document.getElementById('editForm').action = `/admin/equipment/${item.id}`;
    document.getElementById('edit_name').value = item.name;
    document.getElementById('edit_category').value = item.category_id;
    document.getElementById('edit_description').value = item.description || '';
    document.getElementById('edit_quantity').value = item.quantity;
    document.getElementById('edit_available').value = item.available_quantity;
    document.getElementById('edit_status').value = item.status;
    
    if (item.image) {
        document.getElementById('current_image_preview').innerHTML = 
            '<img src="' + item.image_url + '" style="max-width: 150px;" class="img-thumbnail">';
    } else {
        document.getElementById('current_image_preview').innerHTML = '';
    }
    
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush