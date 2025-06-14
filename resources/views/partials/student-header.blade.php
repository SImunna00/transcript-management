<style>

.user-footer .btn {
    margin-top: 10px;
    width: 100%;
    font-weight:bold; 
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
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>

        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->

        <ul class="navbar-nav ms-auto">

            <!--begin::Messages Dropdown Menu-->

            <!--end::Messages Dropdown Menu-->
            <!--begin::Notifications Dropdown Menu-->

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
                    <img id="photoPreview" src="{{  auth()->user()->photo ? asset('storage/' . auth()->user()->photo):  asset('assests/image/2.jpg')}}" class="user-image rounded-circle shadow"
                        alt="User Image" />

                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        <img id="photoPreview" src="{{  auth()->user()->photo ? asset('storage/' . auth()->user()->photo) :  asset('assests/image/2.jpg')}}" class="rounded-circle shadow" alt="User Image" />
                        <p>
                        {{ auth()->user()->name }}
                            <small>{{ auth()->user()->email }}</small>
                        </p>
                    </li>
                    <!--end::User Image-->
                    <!--begin::Menu Body-->

                    <!--end::Menu Body-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('student.profile') }}" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('student.settings') }}" class="btn btn-default btn-flat">Settings</a>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-flat ms-auto d-block">
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