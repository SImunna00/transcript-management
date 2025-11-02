<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assests/image/nstu-logo.png') }}" alt="NSTU Logo"
                class="brand-image opacity-75 shadow img-fluid w-100 h-auto" style="object-fit: contain;" />
            <!--end::Brand Image-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!-- Student Information -->
            <div class="user-panel d-flex flex-column align-items-center py-3 mb-3 text-white">
                <div class="image mb-2">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assests/image/2.jpg') }}"
                        class="avatar img-circle elevation-2" alt="User Image"
                        style="width: 60px; height: 60px; object-fit: cover;">
                </div>
                <div class="info text-center">
                    <div class="d-block fw-bold">{{ auth()->user()->name }}</div>
                    <div class="text-sm">ID: {{ auth()->user()->studentid }}</div>
                    <div class="text-sm">{{ auth()->user()->department }}</div>
                </div>
            </div>

            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link for Students -->
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}"
                        class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Results Section -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>
                            Academic Results
                            <i class="end bi bi-chevron-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('student.applyResult') }}"
                                class="nav-link {{ request()->routeIs('student.applyResult') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Transcript Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.viewResult') }}"
                                class="nav-link {{ request()->routeIs('student.viewResult') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-eye"></i>
                                <p>Update Request</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Documents Section -->
            

                <!-- User Account Section -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person"></i>
                        <p>
                            Account
                            <i class="end bi bi-chevron-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('student.profile') }}"
                                class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-vcard"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.settings') }}"
                                class="nav-link {{ request()->routeIs('student.settings') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <!-- Logout -->
                        <li class="nav-item">
                            <a href="#" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Logout</p>
                            </a>
                            <!-- Logout Form -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>