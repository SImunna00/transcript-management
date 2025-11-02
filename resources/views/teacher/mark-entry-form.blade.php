@extends('layouts.teacher')

@section('title', 'Enter Marks')

@section('page-title', 'Mark Entry System')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Student Search</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teacher.mark.search-student') }}" method="POST" x-data="{ loading: false }"
                            @submit="loading = true">
                            @csrf

                            {{-- Loading Indicator --}}
                            <div x-show="loading" class="text-center mb-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="ms-2">Searching for student...</span>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Search for a student by their ID or name to enter/edit marks.
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="search" class="form-label">Student ID or Name</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="Enter student ID or name" value="{{ old('search') }}" required>
                                    @error('search')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="session" class="form-label">Session</label>
                                    <select class="form-select" id="session" name="session" required>
                                        <option value="">Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session }}" {{ old('session') == $session ? 'selected' : '' }}>
                                                {{ $session }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" x-bind:disabled="loading">
                                    <span x-show="!loading"><i class="fas fa-search me-2"></i>Search</span>
                                    <span x-show="loading"><i class="fas fa-spinner fa-spin me-2"></i>Searching...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" x-data="{ show: true }"
                        x-show="show" x-init="setTimeout(() => { show = false }, 5000)">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                            @click="show = false"></button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" x-data="{ show: true }"
                        x-show="show" x-init="setTimeout(() => { show = false }, 5000)">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                            @click="show = false"></button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection