@extends('layouts.students')
@section('title', 'Student Dashboard')

@section('content')
    <div class="py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Student Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}!</p>
        </div>
    </div>
@endsection
