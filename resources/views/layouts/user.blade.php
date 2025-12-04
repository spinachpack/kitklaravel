<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - KitKeeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #1e5a96; }
        body { background: #f5f7fa; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-blue), #0d3b66);
            color: white;
            position: fixed;
            width: 250px;
        }
        .sidebar .profile-section {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar .profile-img {
            width: 80px; height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 25px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        @yield('extra-styles')
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile-section">
            <img src="{{ Auth::user()->profile_picture_url }}" class="profile-img" alt="Profile">
            <h5 class="mt-3 mb-0">{{ Auth::user()->full_name }}</h5>
            <small class="text-white-50">{{ Auth::user()->id_number }}</small>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('user.equipment.*') ? 'active' : '' }}" href="{{ route('user.equipment.browse') }}">
                <i class="fas fa-box me-2"></i> Browse Equipment
            </a>
            <a class="nav-link {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}" href="{{ route('user.bookings.index') }}">
                <i class="fas fa-calendar-check me-2"></i> My Bookings
            </a>
            <a class="nav-link {{ request()->routeIs('user.notifications.*') ? 'active' : '' }}" href="{{ route('user.notifications.index') }}">
                <i class="fas fa-bell me-2"></i> Notifications
                @if(Auth::user()->notifications()->where('is_read', false)->count() > 0)
                    <span class="badge bg-danger">{{ Auth::user()->notifications()->where('is_read', false)->count() }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}" href="{{ route('user.profile.show') }}">
                <i class="fas fa-user me-2"></i> My Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>