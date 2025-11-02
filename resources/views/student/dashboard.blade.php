@extends('layouts.students')
@section('title', 'Student Dashboard')

@push('style')
    <style>
        .dashboard-card {
            transition: transform 0.2s ease;
            border-radius: 0.5rem;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
        }

        .dashboard-stats {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .notification-item {
            border-left: 3px solid #4f46e5;
            padding-left: 0.75rem;
        }

        .deadline-item {
            border-left: 3px solid #ef4444;
        }

        .progress-bar {
            height: 0.5rem;
            border-radius: 0.25rem;
            background-color: #e5e7eb;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: #4f46e5;
            transition: width 0.5s ease;
        }

        .compact-text {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .compact-header {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 0.5rem;
            height: 100vh;
            padding: 0.5rem;
        }

        .grid-item {
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="grid-container">
        <!-- Row 1: Profile Section (Full Width) -->
        <div class="grid-item col-span-12 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg p-3">
            <div class="flex items-center space-x-4">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile photo"
                        class="h-12 w-12 rounded-full border-2 border-white">
                @else
                    <div class="h-12 w-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center border-2 border-white">
                        <span class="text-white text-sm font-semibold">{{ substr($user->name, 0, 2) }}</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-lg font-bold">{{ $user->name }}</h2>
                    <div class="flex space-x-4 text-xs opacity-90">
                        <span>ID: {{ $user->studentid }}</span>
                        <span>Dept: {{ $user->department ?? 'ICE' }}</span>
                        <span>Session: {{ $user->session }}</span>
                    </div>
                </div>
                <a href="{{ route('student.profile') }}"
                    class="px-3 py-1 bg-white bg-opacity-20 rounded text-xs hover:bg-opacity-30 transition-all">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Row 2: Summary Cards (4 columns, 3 rows each) -->
        <div class="grid-item col-span-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
            <div class="text-center">
                <div class="compact-text text-blue-600 mb-2">CGPA</div>
                <div class="dashboard-stats text-blue-800">{{ $academicStats['cgpa'] }}</div>
            </div>
        </div>

        <div class="grid-item col-span-3 bg-green-50 border border-green-200 rounded-lg p-3">
            <div class="text-center">
                <div class="compact-text text-green-600 mb-2">TGPA</div>
                <div class="dashboard-stats text-green-800">{{ $academicStats['tgpa'] }}</div>
            </div>
        </div>

        <div class="grid-item col-span-3 bg-amber-50 border border-amber-200 rounded-lg p-3">
            <div class="text-center">
                <div class="compact-text text-amber-600 mb-2">Credits</div>
                <div class="dashboard-stats text-amber-800">{{ $academicStats['credits_completed'] }}</div>
            </div>
        </div>

        <div class="grid-item col-span-3 bg-purple-50 border border-purple-200 rounded-lg p-3">
            <div class="text-center">
                <div class="compact-text text-purple-600 mb-2">Year</div>
                <div class="dashboard-stats text-purple-800">{{ $academicStats['current_year'] }}</div>
            </div>
        </div>

        <!-- Row 3: Results Table (8 columns) + Progress (4 columns) -->
        <div class="grid-item col-span-8 bg-gray-50 border border-gray-200 rounded-lg p-3">
            <div class="flex justify-between items-center mb-2">
                <h3 class="compact-header text-gray-900">Latest Results</h3>
                <a href="{{ route('student.viewResult') }}" class="compact-text text-indigo-600 hover:text-indigo-500">
                    View All Results
                </a>
            </div>
            <div class="overflow-auto h-32">
                <table class="w-full">
                    <thead class="bg-gray-100 sticky top-0">
                        <tr>
                            <th class="px-2 py-1 text-left compact-text text-gray-600">Session</th>
                            <th class="px-2 py-1 text-left compact-text text-gray-600">Year</th>
                            <th class="px-2 py-1 text-left compact-text text-gray-600">Term</th>
                            <th class="px-2 py-1 text-left compact-text text-gray-600">TGPA</th>
                            <th class="px-2 py-1 text-left compact-text text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($marksheets->isEmpty())
                            <tr>
                                <td colspan="5" class="px-2 py-2 text-center compact-text text-gray-500">
                                    No results available
                                </td>
                            </tr>
                        @else
                            @foreach($marksheets as $marksheet)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-1 compact-text">{{ $marksheet['session'] ?? '-' }}</td>
                                    <td class="px-2 py-1 compact-text">{{ $marksheet['academic_year'] ?? '-' }}</td>
                                    <td class="px-2 py-1 compact-text">{{ $marksheet['term'] ?? '-' }}</td>
                                    <td class="px-2 py-1 compact-text font-semibold">{{ $marksheet['tgpa'] }}</td>
                                    <td class="px-2 py-1 compact-text">{{ $marksheet['status'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid-item col-span-4 bg-indigo-50 border border-indigo-200 rounded-lg p-3">
            <h3 class="compact-header text-indigo-900 mb-3">Academic Progress</h3>
            <div class="flex justify-between mb-2">
                <span class="compact-text text-indigo-600">Credits Completed</span>
                <span class="compact-text text-indigo-800 font-semibold">
                    {{ $academicStats['credits_completed'] }} / {{ $academicStats['total_credits'] }}
                </span>
            </div>
            <div class="progress-bar mb-3">
                <div class="progress-fill"
                     style="width: {{ $academicStats['credits_completed'] / ($academicStats['total_credits'] ?: 120) * 100 }}%">
                </div>
            </div>
            @if($hasTranscript)
                <a href="{{ route('student.transcript.download') }}"
                   class="w-full inline-flex justify-center items-center px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                    Download Transcript
                </a>
            @endif
        </div>

        <!-- Row 4: Notifications (Full Width) -->
        <div class="grid-item col-span-12 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
            <h3 class="compact-header text-yellow-900 mb-3">Notifications</h3>
            <div class="grid grid-cols-3 gap-3">
                <div class="notification-item bg-white rounded p-3 border">
                    <h4 class="compact-text font-semibold text-gray-900 mb-1">Transcript Request Deadline</h4>
                    <p class="compact-text text-gray-600 mb-1">The deadline for requesting transcripts for the upcoming graduation ceremony is July 20, 2025.</p>
                    <p class="text-xs text-gray-400">Jul 10, 2025</p>
                </div>
                <div class="notification-item bg-white rounded p-3 border">
                    <h4 class="compact-text font-semibold text-gray-900 mb-1">New System Features</h4>
                    <p class="compact-text text-gray-600 mb-1">We've updated the transcript management system with new features! Check out document requests and notifications.</p>
                    <p class="text-xs text-gray-400">Jul 12, 2025</p>
                </div>
                <div class="deadline-item bg-white rounded p-3 border">
                    <h4 class="compact-text font-semibold text-gray-900 mb-1">Upcoming: Result Publication</h4>
                    <p class="compact-text text-gray-600 mb-1">Results for the Spring 2025 semester will be published on July 15, 2025.</p>
                    <p class="text-xs text-gray-400">Jul 13, 2025</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-3 py-2 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-3 py-2 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
@endsection