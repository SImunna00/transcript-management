<style>

.navbar-nav .login-link:hover {
    color: #007bff; 
    text-decoration: underline; 
}
/* Hover effect for Register Link */
.navbar-nav .register-link:hover {
    background-color: #007bff; 
    color: white; 
    text-decoration: none; 
}


</style>


<nav class="app-header navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <!-- University Logo -->
        <a href="#" class="navbar-brand">
            <img src="{{ asset('assests/image/nstu-logo.png') }}" alt="NSTU" style="height: 40px;">
        </a>

        <!-- Navbar items (right-aligned) -->
        <ul class="navbar-nav ms-auto align-items-center">

            <!-- Home Link -->
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-house-door me-1"></i> Home
                </a>
            </li>

            <!-- Departments Link -->
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-building me-1"></i> Departments
                </a>
            </li>

            <!-- About Link -->
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-info-circle me-1"></i> About
                </a>
            </li>

           <li class="nav-item">
                <a class="btn btn-light btn-sm ms-2 fw-semibold register-link" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            </li>

            <!-- Register Link -->
            <li class="nav-item">
                <a class="btn btn-light btn-sm ms-2 fw-semibold register-link" href="{{route('register')}}">
                    <i class="bi bi-person-plus-fill me-1"></i> Register
                </a>
            </li>
            
        </ul>
    </div>
</nav>
