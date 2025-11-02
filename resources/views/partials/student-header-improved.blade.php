<style>
    .user-footer .btn {
        margin-top: 10px;
        width: 100%;
        font-weight: bold;
    }

    .notification-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
    }

    .dropdown-notifications {
        width: 320px;
    }

    .notification-item {
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .notification-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .notification-item.unread {
        border-left-color: #4f46e5;
        background-color: rgba(79, 70, 229, 0.05);
    }

    .notification-time {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .navbar .nav-item .nav-link {
        color: #374151;
    }

    .navbar .nav-item .nav-link:hover {
        color: #111827;
    }
</style>

<nav class="app-header navbar navbar-expand bg-secondary-subtle">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('student.dashboard') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">My Documents</a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
                <a class="nav-link text-black position-relative" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>
                    @php
                        $notificationCount = 0; // Removed DocumentRequest notifications
                    @endphp
                    @if($notificationCount > 0)
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge">
                            {{ $notificationCount }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end dropdown-notifications">
                    <span class="dropdown-header">{{ $notificationCount }} Notifications</span>
                    <div class="dropdown-divider"></div>

                    @php
                        $notifications = collect(); // Empty collection since DocumentRequest is removed
                    @endphp

                    @forelse($notifications as $notification)
                        <a href="#"
                            class="dropdown-item notification-item">
                            <div class="d-flex align-items-center">
                                @else
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                @endif
                                <div>
                                    <p class="mb-0">Your {{ $notification->document_type }} request has been
                                        {{ $notification->status }}!
                                    </p>
                                    <span class="notification-time">{{ $notification->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <span class="dropdown-item">No new notifications</span>
                        <div class="dropdown-divider"></div>
                    @endforelse

                    <a href="#" class="dropdown-item dropdown-footer">See
                        All
                        Notifications</a>
                </div>
            </li>
            <!--end::Notifications Dropdown Menu-->

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link text-black" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img id="photoPreview"
                        src="{{  auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assests/image/2.jpg') }}"
                        class="user-image rounded-circle shadow" alt="User Image" />
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        <img id="photoPreview"
                            src="{{  auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assests/image/2.jpg') }}"
                            class="rounded-circle shadow" alt="User Image" />
                        <p>
                            {{ auth()->user()->name }}
                            <small>{{ auth()->user()->studentid }}</small>
                            <small>{{ auth()->user()->email }}</small>
                        </p>
                    </li>
                    <!--end::User Image-->

                    <!--begin::Menu Body-->
                    <li class="user-body border-top border-bottom">
                        <div class="row">
                            <div class="col-6 text-center">
                                <a href="#">Documents</a>
                            </div>
                            <div class="col-6 text-center">
                                <a href="#">Results</a>
                            </div>
                        </div>
                    </li>
                    <!--end::Menu Body-->

                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('student.profile') }}" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('student.settings') }}" class="btn btn-default btn-flat">Settings</a>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-flat ms-auto d-block">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>