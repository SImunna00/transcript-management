{{-- resources/views/admin/marksheets/show.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marksheet Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                            <a href="{{ route('admin.marksheets.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Marksheets</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">Details</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Marksheet Header -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Marksheet Information</h3>
                                    <p class="text-sm text-gray-600 mt-1">Generated on {{ $marksheet->created_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $marksheet->file_path ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $marksheet->file_path ? 'Available' : 'Processing' }}
                                    </span>
                                    @if($marksheet->download_count > 0)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Downloaded {{ $marksheet->download_count }}x
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Student Information -->
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-3">Student Information</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                                <span class="text-blue-600 font-medium text-lg">
                                                    {{ substr($marksheet->student->name ?? 'N', 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $marksheet->student->name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $marksheet->student->studentid ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $marksheet->student->email ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Department</label>
                                                <p class="text-gray-900">{{ $marksheet->student->department ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Faculty</label>
                                                <p class="text-gray-900">{{ $marksheet->student->faculty ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information -->
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-3">Academic Information</h4>
                                    <div class="grid grid-cols-1 gap-3 text-sm">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Session</label>
                                                <p class="text-gray-900 font-medium">{{ $marksheet->session }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Academic Year</label>
                                                <p class="text-gray-900 font-medium">{{ $marksheet->academicYear->name ?? 'N/A' }} Year</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Term</label>
                                                <p class="text-gray-900 font-medium">{{ $marksheet->term->name ?? 'N/A' }} Term</p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Marksheet Type</label>
                                                <p class="text-gray-900 font-medium">{{ ucfirst($marksheet->marksheet_type ?? 'official') }}</p>
                                            </div>
                                        </div>

                                        @if($marksheet->notes)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Notes</label>
                                            <p class="text-gray-900">{{ $marksheet->notes }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Marks Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Course Marks</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marks</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Point</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if(isset($marks) && count($marks) > 0)
                                        @foreach($marks as $mark)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $mark->course->code ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $mark->course->name ?? 'N/A' }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $mark->course->credits ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{ $mark->total_marks ?? 0 }}</span>
                                                    <span class="text-gray-500 mx-1">/</span>
                                                    <span>100</span>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $mark->total_marks ? number_format($mark->total_marks, 1) . '%' : 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @switch($mark->grade ?? 'F')
                                                        @case('A+') bg-green-100 text-green-800 @break
                                                        @case('A') bg-green-100 text-green-800 @break
                                                        @case('A-') bg-blue-100 text-blue-800 @break
                                                        @case('B+') bg-blue-100 text-blue-800 @break
                                                        @case('B') bg-yellow-100 text-yellow-800 @break
                                                        @case('B-') bg-yellow-100 text-yellow-800 @break
                                                        @case('C+') bg-orange-100 text-orange-800 @break
                                                        @case('C') bg-orange-100 text-orange-800 @break
                                                        @case('D') bg-red-100 text-red-800 @break
                                                        @case('F') bg-red-100 text-red-800 @break
                                                        @case('I') bg-gray-100 text-gray-800 @break
                                                        @default bg-gray-100 text-gray-800
                                                    @endswitch">
                                                    {{ $mark->grade ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ number_format($mark->grade_point ?? 0, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                No course marks available
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- GPA Summary -->
                        @if(isset($marksheet->gpa) || isset($marksheet->cgpa))
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                @if(isset($marksheet->total_credit_hours))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $marksheet->total_credit_hours }}</div>
                                    <div class="text-sm text-gray-600">Total Credits</div>
                                </div>
                                @endif
                                
                                @if(isset($marksheet->gpa))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ number_format($marksheet->gpa, 2) }}</div>
                                    <div class="text-sm text-gray-600">GPA</div>
                                </div>
                                @endif
                                
                                @if(isset($marksheet->cgpa))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ number_format($marksheet->cgpa, 2) }}</div>
                                    <div class="text-sm text-gray-600">CGPA</div>
                                </div>
                                @endif
                                
                                @if(isset($marksheet->class_rank))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ $marksheet->class_rank }}</div>
                                    <div class="text-sm text-gray-600">Class Rank</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- PDF Preview -->
                    @if($marksheet->file_path)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">PDF Preview</h3>
                                <div class="flex space-x-2">
                                    <button onclick="toggleFullscreen()" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-expand"></i> Fullscreen
                                    </button>
                                    <a href="{{ route('admin.marksheets.download', $marksheet->id) }}" 
                                       class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div id="pdf-container" class="border border-gray-200 rounded-lg">
                                <iframe src="{{ route('admin.marksheets.preview-pdf', $marksheet->id) }}" 
                                        class="w-full h-96 rounded-lg"
                                        frameborder="0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @if($marksheet->file_path)
                                <a href="{{ route('admin.marksheets.download', $marksheet->id) }}" 
                                   class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                    <i class="fas fa-download mr-2"></i>Download PDF
                                </a>
                                
                                <a href="{{ route('admin.marksheets.preview-pdf', $marksheet->id) }}" 
                                   target="_blank"
                                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                    <i class="fas fa-external-link-alt mr-2"></i>Open in New Tab
                                </a>
                                
                                <button onclick="sendEmail()" 
                                        class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-envelope mr-2"></i>Email to Student
                                </button>
                            @endif
                            
                            <button onclick="regenerateMarksheet()" 
                                    class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-redo mr-2"></i>Regenerate
                            </button>
                            
                            <a href="{{ route('admin.marksheets.create') }}?duplicate={{ $marksheet->id }}" 
                               class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-center">
                                <i class="fas fa-copy mr-2"></i>Duplicate
                            </a>
                            
                            <button onclick="deleteMarksheet()" 
                                    class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </div>
                    </div>

                    <!-- File Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">File Information</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">File Name:</span>
                                <span class="text-sm font-medium text-gray-900">{{ basename($marksheet->file_path ?? 'N/A') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">File Size:</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $marksheet->file_size ? number_format($marksheet->file_size / 1024, 1) . ' KB' : 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Pages:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $marksheet->total_pages ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Generated:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $marksheet->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Generated By:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $marksheet->generatedBy->name ?? 'System' }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Downloads:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $marksheet->download_count ?? 0 }} times</span>
                            </div>
                            
                            @if($marksheet->last_downloaded_at)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Last Download:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $marksheet->last_downloaded_at->diffForHumans() }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Related Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Related Information</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Student Profile</label>
                                @if($marksheet->student)
                                <a href="{{ route('admin.students.index') }}?search={{ $marksheet->student->studentid }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Student Details
                                </a>
                                @else
                                <span class="text-gray-500 text-sm">Student information not available</span>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Other Marksheets</label>
                                @if(isset($other_marksheets) && count($other_marksheets) > 0)
                                    <div class="space-y-1">
                                        @foreach($other_marksheets as $other)
                                        <a href="{{ route('admin.marksheets.show', $other->id) }}" 
                                           class="block text-sm text-blue-600 hover:text-blue-800">
                                            {{ $other->session }} - {{ $other->academicYear->name ?? '' }} Year
                                        </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No other marksheets</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    @if(isset($activity_log) && count($activity_log) > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Activity Log</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($activity_log as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-800">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['created_at'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Send Email Modal -->
    <div id="emailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Send Marksheet via Email</h3>
                <form id="emailForm" method="POST" action="{{ route('admin.marksheets.email', $marksheet->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Email</label>
                        <input type="email" name="email" value="{{ $marksheet->student->email ?? '' }}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject" 
                               value="Your Academic Transcript - {{ $marksheet->session }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2" required>Dear {{ $marksheet->student->name ?? 'Student' }},

Please find attached your academic transcript for {{ $marksheet->session }} - {{ $marksheet->academicYear->name ?? '' }} Year, {{ $marksheet->term->name ?? '' }} Term.

Best regards,
Academic Office</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEmailModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFullscreen() {
            const iframe = document.querySelector('#pdf-container iframe');
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.webkitRequestFullscreen) {
                iframe.webkitRequestFullscreen();
            } else if (iframe.msRequestFullscreen) {
                iframe.msRequestFullscreen();
            }
        }

        function sendEmail() {
            document.getElementById('emailModal').classList.remove('hidden');
        }

        function closeEmailModal() {
            document.getElementById('emailModal').classList.add('hidden');
        }

        function regenerateMarksheet() {
            if (confirm('Are you sure you want to regenerate this marksheet? This will replace the current file.')) {
                fetch(`/admin/marksheets/{{ $marksheet->id }}/regenerate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        alert('Marksheet regeneration started. Please refresh the page in a few moments.');
                        location.reload();
                    } else {
                        alert('Error regenerating marksheet.');
                    }
                });
            }
        }

        function deleteMarksheet() {
            if (confirm('Are you sure you want to delete this marksheet? This action cannot be undone.')) {
                fetch(`/admin/marksheets/{{ $marksheet->id }}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        alert('Marksheet deleted successfully.');
                        window.location.href = '{{ route("admin.marksheets.index") }}';
                    } else {
                        alert('Error deleting marksheet.');
                    }
                });
            }
        }

        // Email form submission
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    alert('Email sent successfully!');
                    closeEmailModal();
                } else {
                    alert('Error sending email.');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Error sending email.');
            }).finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Track PDF view
        window.addEventListener('load', function() {
            fetch(`/admin/marksheets/{{ $marksheet->id }}/track-view`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>