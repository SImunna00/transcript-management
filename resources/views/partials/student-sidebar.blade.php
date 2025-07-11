<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('assests/image/nstu-logo.png') }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow img-fluid w-100 h-auto"
                 style="object-fit: contain;"
            />
            <!--end::Brand Image-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link for Students -->
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-house-door"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

               <!-- Result Section (Apply for Results) -->
                <li class="nav-item">
                    <a href="{{ route('student.applyResult') }}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>Apply for Result</p>
                    </a>
                </li>


                 <!-- View Result Section (After Applying) -->
                <li class="nav-item">
                    <a href="{{ route('student.viewResult') }}" class="nav-link">
                        <i class="nav-icon bi bi-eye"></i>
                        <p>View Result</p>
                    </a>
                </li>

                <!-- Profile Section -->
                <li class="nav-item">
                    <a href="{{ route('student.profile') }}" class="nav-link">
                        <i class="nav-icon bi bi-person"></i>
                        <p>Profile</p>
                    </a>
                </li>

                <!-- Settings Section -->
                <li class="nav-item">
                    <a href="{{ route('student.settings') }}" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <!-- Result Section -->
              

                <!-- Logout -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>

                    <!-- Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
