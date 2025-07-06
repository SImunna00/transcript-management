<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Dashboard') - Transcript Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }

        .nav-link:hover {
            color: #fff;
        }

        .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .teacher-header {
            background-color: #0d6efd;
            color: #fff;
            padding: 15px 0;
        }

        .content-area {
            padding: 20px;
        }

        .stats-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .stats-card i {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
        }

        .stats-card p {
            font-size: 1rem;
            color: #6c757d;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assests/image/nstu_logo.png') }}" alt="Logo" width="80"
                            class="img-fluid mb-2">
                        <h5 class="text-light">Teacher Portal</h5>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('teacher.dashboard') }}"
                                class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teacher.courses') }}"
                                class="nav-link {{ request()->routeIs('teacher.courses') || request()->routeIs('teacher.courseStudents') ? 'active' : '' }}">
                                <i class="fas fa-book me-2"></i> My Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teacher.results') }}"
                                class="nav-link {{ request()->routeIs('teacher.results') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar me-2"></i> Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-cog me-2"></i> Profile Settings
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <form action="{{ route('teacher.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <div class="teacher-header mb-4">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">@yield('page-title', 'Dashboard')</h1>
                            <div class="user-info d-flex align-items-center">
                                <span class="me-2">{{ Auth::guard('teacher')->user()->name }}</span>
                                @if(Auth::guard('teacher')->user()->photo)
                                    <img src="{{ Storage::url(Auth::guard('teacher')->user()->photo) }}" alt="Profile"
                                        class="rounded-circle" width="40" height="40">
                                @else
                                    <i class="fas fa-user-circle fa-2x"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="content-area">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>

</html>