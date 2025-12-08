@extends('layouts.user')

@section('title', 'Browse Equipment')

@section('content')
<div class="mb-4">
    <h4>Browse Equipment</h4>
    <p class="text-muted">Find and reserve equipment for your needs</p>
</div>

<!-- Search Filter -->
<div class="card mb-4">
    <div class="card-body">
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
</div>

<!-- Equipment Grid -->
<div class="row">
    @forelse($equipment as $equip)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($equip->image)
                    <img src="{{ asset('uploads/equipment/' . $equip->image) }}" style="width: 100%; height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;" alt="{{ $equip->name }}">
                @else
                    <div style="width: 100%; height: 200px; background: #6c757d; display: flex; align-items: center; justify-content: center; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <i class="fas fa-box fa-4x text-white"></i>
                    </div>
                @endif

                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $equip->category->name }}</span>
                    <h5 class="card-title mb-2">{{ $equip->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($equip->description, 100) }}</p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i>
                            {{ $equip->available_quantity }} Available
                        </span>
                        <span class="text-muted small">Total: {{ $equip->quantity }}</span>
                    </div>

                    @if($equip->available_quantity > 0)
                        <a href="{{ route('user.equipment.book', $equip->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-calendar-plus"></i> Book Now
                        </a>
                    @else
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-times-circle"></i> Not Available
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h5>No Equipment Found</h5>
                    <p class="text-muted">Try adjusting your search or filters</p>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection