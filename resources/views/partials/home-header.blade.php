<style>
    .navbar-custom {
        background: linear-gradient(135deg, #0066cc 0%, #004080 50%, #003366 100%);
        border-bottom: 3px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        padding: 0.8rem 0;
        transition: all 0.3s ease;
    }

    .navbar-custom.scrolled {
        padding: 0.5rem 0;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        font-weight: 700;
        font-size: 1.3rem;
        color: white !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        transform: scale(1.05);
        color: #e3f2fd !important;
    }

    .navbar-brand img {
        height: 45px;
        width: auto;
        margin-right: 12px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        transition: all 0.3s ease;
    }

    .navbar-brand img:hover {
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
    }

    .university-name {
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .nav-link-custom {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        padding: 8px 16px !important;
        margin: 0 4px;
        border-radius: 25px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .nav-link-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.5s ease;
    }

    .nav-link-custom:hover::before {
        left: 100%;
    }

    .nav-link-custom:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .nav-link-custom i {
        font-size: 1rem;
        margin-right: 6px;
        transition: all 0.3s ease;
    }

    .nav-link-custom:hover i {
        transform: scale(1.1);
    }

    .btn-login {
        background: linear-gradient(45deg, #ffffff, #f8f9fa);
        color: #0066cc !important;
        border: 2px solid rgba(255, 255, 255, 0.8);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        margin-left: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-login:hover {
        background: linear-gradient(45deg, #0066cc, #004080);
        color: white !important;
        border-color: #0066cc;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
    }

    .btn-register {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white !important;
        border: 2px solid #28a745;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        margin-left: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-register:hover {
        background: linear-gradient(45deg, #20c997, #17a2b8);
        border-color: #20c997;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        color: white !important;
    }

    .btn-login i,
    .btn-register i {
        margin-right: 6px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-login:hover i,
    .btn-register:hover i {
        transform: scale(1.1);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .navbar-custom {
            padding: 0.6rem 0;
        }

        .navbar-brand img {
            height: 35px;
        }

        .university-name {
            font-size: 0.9rem;
        }

        .nav-link-custom {
            padding: 6px 12px !important;
            margin: 2px 0;
        }

        .btn-login,
        .btn-register {
            padding: 6px 16px;
            margin: 4px 0;
            margin-left: 0;
            width: 100%;
            justify-content: center;
        }
    }

    /* Active state */
    .nav-link-custom.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Animation for navbar */
    .navbar-custom {
        animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Dropdown effect (if needed) */
    .navbar-nav {
        align-items: center;
    }

    .navbar-toggler {
        border: none;
        padding: 4px 8px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <!-- University Logo and Name -->
        <a href="#" class="navbar-brand">
            <img src="{{ asset('assests/image/nstu-logo.png') }}" alt="NSTU Logo">
            <span class="university-name d-none d-md-inline">NSTU Portal</span>
        </a>

        <!-- Mobile menu toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <!-- Home Link -->
                <li class="nav-item">
                    <a class="nav-link-custom active" href="#">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                <!-- Departments Link -->
                <li class="nav-item">
                    <a class="nav-link-custom" href="#">
                        <i class="bi bi-building"></i>
                        <span>Departments</span>
                    </a>
                </li>

                <!-- About Link -->
                <li class="nav-item">
                    <a class="nav-link-custom" href="#">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>About</span>
                    </a>
                </li>

                <!-- Contact Link (Optional) -->
                <li class="nav-item">
                    <a class="nav-link-custom" href="#">
                        <i class="bi bi-envelope-fill"></i>
                        <span>Contact</span>
                    </a>
                </li>

                <!-- Login Button -->
                <li class="nav-item">
                    <a class="btn-login" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Login</span>
                    </a>
                </li>

                <!-- Register Button -->
                <li class="nav-item">
                    <a class="btn-register" href="{{ route('register') }}">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Register</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Add this script for scroll effect -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.navbar-custom');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>