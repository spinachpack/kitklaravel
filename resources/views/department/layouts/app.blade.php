<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Department Dashboard') - KitKeeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e5a96;
            --dark-blue: #0d3b66;
        }
        body {
            background: #f5f7fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-blue), var(--dark-blue));
            color: white;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        .sidebar .profile-section {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 25px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-section">
            <img src="{{ asset('uploads/profiles/' . (auth()->user()->profile_picture ?: 'default-avatar.png')) }}" class="profile-img" alt="Profile">
            <h5 class="mt-3 mb-0">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
            <small class="text-white-50">Department Staff</small>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('department.dashboard') ? 'active' : '' }}" href="{{ route('department.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('department.equipment.*') ? 'active' : '' }}" href="{{ route('department.equipment.index') }}">
                <i class="fas fa-box"></i> Manage Equipment
            </a>
            <a class="nav-link {{ request()->routeIs('department.bookings.*') ? 'active' : '' }}" href="{{ route('department.bookings.index') }}">
                <i class="fas fa-calendar-check"></i> Manage Bookings
                @php
                    $pendingCount = \App\Models\Reservation::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-warning ms-2">{{ $pendingCount }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('department.profile.*') ? 'active' : '' }}" href="{{ route('department.profile.show') }}">
                <i class="fas fa-user"></i> My Profile
            </a>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>