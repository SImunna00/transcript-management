<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - Transcript Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            min-height: 100vh;
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
            padding: 15px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }

        .logo {
            margin-bottom: 15px;
            width: 80px;
            height: 80px;
        }

        .form-floating {
            margin-bottom: 15px;
        }

        .btn-login {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 10px;
            font-size: 16px;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .link-home {
            color: #0d6efd;
            text-decoration: none;
        }

        .link-home:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <img src="{{ asset('assests/image/nstu_logo.png') }}" alt="NSTU Logo" class="logo">
                <h3>Teacher Login</h3>

            </div>
            <div class="card-body p-4">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teacher.login') }}">
                    @csrf

                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                            required autofocus>
                        <label for="email">Email address</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                        <label for="password">Password</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary btn-login" type="submit">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <p class="mb-0">Don't have an account?
                    <a href="{{ route('teacher.register') }}" class="link-home">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                </p>
                <a href="{{ url('/') }}" class="link-home d-block mt-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>