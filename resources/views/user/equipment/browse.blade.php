@extends('layouts.user')

@section('title', 'Browse Equipment')

@section('extra-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .equipment-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .equipment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    .equipment-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .equipment-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .filter-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <h4>Browse Equipment</h4>
    <p class="text-muted">Find and reserve equipment for your needs</p>
</div>

<div class="filter-card">
    <form method="GET" class="row g-3">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search equipment..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </form>
</div>

<div class="row">
    @forelse($equipment as $equip)
        <div class="col-md-4 mb-4">
            <div class="equipment-card">
                @if($equip->image)
                    <img src="{{ $equip->image_url }}" class="equipment-image" alt="{{ $equip->name }}">
                @else
                    <div class="equipment-placeholder">
                        <i class="fas fa-box fa-4x text-white"></i>
                    </div>
                @endif

                <div class="p-3">
                    <span class="badge bg-primary mb-2">{{ $equip->category->name }}</span>
                    <h5 class="mb-2">{{ $equip->name }}</h5>
                    <p class="text-muted small mb-3">{{ Str::limit($equip->description, 100) }}</p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i>
                            {{ $equip->available_quantity }} Available
                        </span>
                        <span class="text-muted small">Total: {{ $equip->quantity }}</span>
                    </div>

                    <a href="{{ route('user.equipment.book', $equip->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-calendar-plus"></i> Book Now
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h5>No Equipment Found</h5>
                <p class="text-muted">Try adjusting your search or filters</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
