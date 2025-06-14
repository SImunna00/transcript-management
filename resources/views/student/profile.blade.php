@extends('layouts.students')

@section('title', 'Profile')

@section('content')

<!-- Profile Update Form Container -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-light rounded">
                <div class="card-header text-center bg-light">
                    <h3>Update Your Profile</h3>
                </div>
                <div class="card-body">
                    <!-- Profile Update Form -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('student.profile.store') }}">
                        @csrf

                        <!-- Full Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}" placeholder="Enter your full name" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        


                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" placeholder="Enter your email" required />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ auth()->user()->phone }}" placeholder="Enter your phone number" />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Profile Image Field -->
                        <div class="mb-4">
                            <label for="photo" class="form-label fw-bold">Profile Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*" />
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
