@extends('layouts.admin')

@section('title', 'Transcript Request Details')
@section('page-title', 'Transcript Request Details')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-alt mr-2"></i>Request Details for {{ $request->user->name ?? 'N/A' }}
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.transcript-requests.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Requests
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

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

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Student Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $request->user->name ?? 'N/A' }}</p>
                            <p><strong>Student ID:</strong> {{ $request->user->studentid ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $request->user->email ?? 'N/A' }}</p>
                            <p><strong>Academic Year:</strong> {{ $request->academic_year ?? 'N/A' }}</p>
                            <p><strong>Term:</strong> {{ $request->term ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Request Details</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Amount:</strong> ৳{{ number_format($request->amount, 2) }}</p>
                            <p><strong>Payment Status:</strong> 
                                @if($request->payment_status === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($request->payment_status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </p>
                            <p><strong>Transaction ID:</strong> {{ $request->transaction_id ?? 'N/A' }}</p>
                            <p><strong>Request Date:</strong> {{ $request->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Additional Info:</strong> {{ $request->additional_info ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-success card-outline">
                <div class="card-header">
                    <h5 class="card-title">Transcript Status & Actions</h5>
                </div>
                <div class="card-body">
                    <p><strong>Current Status:</strong> 
                        @if($request->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($request->status === 'pending')
                            <span class="badge badge-warning">Pending Upload</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst($request->status) }}</span>
                        @endif
                    </p>

                    @if($request->payment_status === 'paid')
                        @if($request->transcript_path)
                            <p><strong>Uploaded Transcript:</strong> 
                                <a href="{{ Storage::url($request->transcript_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> View/Download Transcript
                                </a>
                            </p>
                        @else
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#uploadModal">
                                <i class="fas fa-upload"></i> Upload Transcript
                            </button>
                        @endif
                    @else
                        <p class="text-muted">Transcript upload is available after payment is confirmed.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('upload', $request->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Transcript for {{ $request->user->name ?? 'N/A' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="transcript_file">Select Transcript PDF</label>
                        <input type="file" class="form-control-file" id="transcript_file" name="transcript" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection