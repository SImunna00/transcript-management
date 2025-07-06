
{{-- resources/views/admin/requests.blade.php --}}
@extends('layouts.admin')

@section('title', 'Student Requests')
@section('page-title', 'Student Transcript Requests')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Student Requests
            </h3>
        </div>
        <div class="card-body">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Error Alert --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if(isset($requests) && $requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Academic Year</th>
                                <th>Term</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Transaction ID</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                                    <td>{{ $request->user->studentid ?? 'N/A' }}</td>
                                    <td>{{ $request->year ?? $request->academic_year ?? 'N/A' }}</td>
                                    <td>{{ $request->term }}</td>
                                    <td>৳{{ number_format($request->amount, 2) }}</td>
                                    <td>
                                        @if($request->payment_status === 'paid')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Paid
                                            </span>
                                        @elseif($request->payment_status === 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $request->transaction_id ?? 'Pending' }}</td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(isset($request->transcript_path) && $request->transcript_path)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-hourglass"></i> Pending Upload
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->payment_status === 'paid')
                                            @if(isset($request->transcript_path) && $request->transcript_path)
                                                <a href="{{ Storage::url($request->transcript_path) }}" 
                                                   class="btn btn-info btn-sm" target="_blank">
                                                    <i class="fas fa-download"></i> View
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        data-toggle="modal" data-target="#uploadModal{{ $request->id }}">
                                                    <i class="fas fa-upload"></i> Upload Transcript
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted">Payment Required</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Upload Modals --}}
                @foreach($requests as $request)
                    @if($request->payment_status === 'paid' && (!isset($request->transcript_path) || !$request->transcript_path))
                        <!-- Upload Modal for Request {{ $request->id }} -->
                        <div class="modal fade" id="uploadModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel{{ $request->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.upload', $request->id) }}" enctype="multipart/form-data" id="uploadForm{{ $request->id }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="uploadModalLabel{{ $request->id }}">
                                                <i class="fas fa-upload mr-2"></i>Upload Transcript
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- Student Information --}}
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="card bg-light">
                                                        <div class="card-body">
                                                            <h6 class="card-title">Student Information</h6>
                                                            <p class="card-text mb-1"><strong>Name:</strong> {{ $request->user->name ?? 'N/A' }}</p>
                                                            <p class="card-text mb-1"><strong>ID:</strong> {{ $request->user->studentid ?? 'N/A' }}</p>
                                                            <p class="card-text mb-1"><strong>Academic Year:</strong> {{ $request->year ?? $request->academic_year ?? 'N/A' }}</p>
                                                            <p class="card-text mb-0"><strong>Term:</strong> {{ $request->term }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card bg-light">
                                                        <div class="card-body">
                                                            <h6 class="card-title">Request Details</h6>
                                                            <p class="card-text mb-1"><strong>Amount:</strong> ৳{{ number_format($request->amount, 2) }}</p>
                                                            <p class="card-text mb-1"><strong>Payment:</strong> {{ ucfirst($request->payment_status) }}</p>
                                                            <p class="card-text mb-1"><strong>Transaction:</strong> {{ $request->transaction_id ?? 'N/A' }}</p>
                                                            <p class="card-text mb-0"><strong>Request Date:</strong> {{ $request->created_at->format('M d, Y') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- File Upload Section --}}
                                            <div class="form-group">
                                                <label for="transcript{{ $request->id }}" class="font-weight-bold">
                                                    <i class="fas fa-file-pdf mr-2"></i>Select PDF Transcript
                                                </label>
                                                <input type="file" 
                                                       name="transcript" 
                                                       id="transcript{{ $request->id }}" 
                                                       class="form-control" 
                                                       accept="application/pdf,.pdf"
                                                       required>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Only PDF files are allowed. Maximum file size: 10MB
                                                </small>
                                            </div>

                                            {{-- File Preview (Optional - shows selected file name) --}}
                                            <div id="filePreview{{ $request->id }}" class="mt-3" style="display: none;">
                                                <div class="alert alert-info">
                                                    <h6 class="alert-heading">
                                                        <i class="fas fa-file-pdf mr-2"></i>Selected File
                                                    </h6>
                                                    <p class="mb-0"><strong>File:</strong> <span id="fileName{{ $request->id }}"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times mr-2"></i>Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-upload mr-2"></i>Upload Transcript
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No Requests Found</h5>
                    <p class="text-muted">No student requests have been submitted yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Optional: Simple JavaScript for file preview only --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin upload system initialized');
    
    @foreach($requests as $request)
        @if($request->payment_status === 'paid' && (!isset($request->transcript_path) || !$request->transcript_path))
        // Simple file preview for request {{ $request->id }}
        (function() {
            const fileInput = document.getElementById('transcript{{ $request->id }}');
            const filePreview = document.getElementById('filePreview{{ $request->id }}');
            const fileName = document.getElementById('fileName{{ $request->id }}');
            
            // Show selected file name (optional)
            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    filePreview.style.display = 'block';
                } else {
                    filePreview.style.display = 'none';
                }
            });
            
            // Reset on modal close
            $('#uploadModal{{ $request->id }}').on('hidden.bs.modal', function () {
                document.getElementById('uploadForm{{ $request->id }}').reset();
                filePreview.style.display = 'none';
            });
        })();
        @endif
    @endforeach
});
</script>
@endsection
