<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration - Transcript Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px 0;
            min-height: 100vh;
        }

        .register-container {
            max-width: 800px;
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

        .btn-register {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 10px;
            font-size: 16px;
        }

        .btn-register:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .link-login {
            color: #0d6efd;
            text-decoration: none;
        }

        .link-login:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <img src="{{ asset('assests/image/nstu-logo.png') }}" alt="NSTU Logo" class="logo">
                <h3>Teacher Registration</h3>
                <p>Transcript Management System</p>
            </div>
            <div class="card-body p-4">
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

                <form method="POST" action="{{ route('teacher.register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" name="department"
                                value="{{ old('department') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-register">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <p class="mb-0">Already have an account?
                    <a href="{{ route('teacher.login') }}" class="link-login">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </p>
                <a href="{{ url('/') }}" class="link-login d-block mt-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>