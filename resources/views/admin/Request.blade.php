
{{-- resources/views/admin/requests.blade.php --}}
@extends('layouts.admin')

@section('title', 'Transcript Requests')
@section('page-title', 'Transcript Requests Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Transcript Requests</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>Filter Requests
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.requests') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter_year">Academic Year</label>
                                    <select name="year" id="filter_year" class="form-control">
                                        <option value="">All Years</option>
                                        <option value="1st" {{ request('year') == '1st' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd" {{ request('year') == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd" {{ request('year') == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th" {{ request('year') == '4th' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter_term">Term</label>
                                    <select name="term" id="filter_term" class="form-control">
                                        <option value="">All Terms</option>
                                        <option value="1st Term" {{ request('term') == '1st Term' ? 'selected' : '' }}>1st Term</option>
                                        <option value="2nd Term" {{ request('term') == '2nd Term' ? 'selected' : '' }}>2nd Term</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter_payment">Payment Status</label>
                                    <select name="payment_status" id="filter_payment" class="form-control">
                                        <option value="">All Payments</option>
                                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter_status">Admin Status</label>
                                    <select name="admin_status" id="filter_status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('admin_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ request('admin_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="approved" {{ request('admin_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ request('admin_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter_search">Search Student</label>
                                    <input type="text" name="search" id="filter_search" class="form-control" 
                                           placeholder="Name or ID" value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.requests') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Transcript Requests Management
            </h3>
            <div class="card-tools">
                <span class="badge badge-primary">{{ $requests->total() ?? 0 }} Total Requests</span>
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

            @if(isset($requests) && $requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Request ID</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Academic Year</th>
                                <th>Term</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Admin Status</th>
                                <th>Request Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td><strong>#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>
                                        <i class="fas fa-user text-primary mr-1"></i>
                                        {{ $request->user->name ?? 'N/A' }}
                                    </td>
                                    <td>{{ $request->user->student_id ?? 'N/A' }}</td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-info mr-1"></i>
                                        {{ $request->year ?? $request->academic_year ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-book text-info mr-1"></i>
                                        {{ $request->term ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <strong>৳{{ number_format($request->amount ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            @if($request->payment_status === 'paid')
                                                <i class="fas fa-check-circle"></i> Paid
                                            @elseif($request->payment_status === 'pending')
                                                <i class="fas fa-clock"></i> Pending
                                            @elseif($request->payment_status === 'failed')
                                                <i class="fas fa-times-circle"></i> Failed
                                            @else
                                                <i class="fas fa-question-circle"></i> Unknown
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            @if($request->admin_status === 'approved')
                                                <i class="fas fa-check"></i> Approved
                                            @elseif($request->admin_status === 'pending')
                                                <i class="fas fa-hourglass-half"></i> Pending
                                            @elseif($request->admin_status === 'processing')
                                                <i class="fas fa-cog fa-spin"></i> Processing
                                            @elseif($request->admin_status === 'rejected')
                                                <i class="fas fa-times"></i> Rejected
                                            @else
                                                <i class="fas fa-question"></i> Not Reviewed
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $request->created_at->format('M d, Y') }}<br>
                                            {{ $request->created_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- View Details -->
                                            <button type="button" class="btn btn-sm btn-info" 
                                                    data-toggle="modal" data-target="#detailModal{{ $request->id }}"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Update Status -->
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-toggle="modal" data-target="#statusModal{{ $request->id }}"
                                                    title="Update Status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Upload Transcript (only for paid requests) -->
                                            @if($request->payment_status === 'paid')
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-toggle="modal" data-target="#uploadModal{{ $request->id }}"
                                                        title="Upload Transcript">
                                                    <i class="fas fa-upload"></i>
                                                </button>
                                            @endif

                                            <!-- Download Transcript (if exists) -->
                                            @if($request->result_file && file_exists(storage_path('app/' . $request->result_file)))
                                                <a href="{{ route('admin.download-transcript', $request->id) }}" 
                                                   class="btn btn-sm btn-primary"
                                                   title="Download Transcript">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                @include('admin.modals.request-detail', ['request' => $request])

                                <!-- Status Update Modal -->
                                @include('admin.modals.status-update', ['request' => $request])

                                <!-- Upload Transcript Modal -->
                                @if($request->payment_status === 'paid')
                                    @include('admin.modals.upload-transcript', ['request' => $request])
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($requests->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <small class="text-muted">
                                Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} 
                                of {{ $requests->total() }} requests
                            </small>
                        </div>
                        <div>
                            {{ $requests->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No Requests Found</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['year', 'term', 'payment_status', 'admin_status', 'search']))
                            No transcript requests match your filter criteria.
                        @else
                            No transcript requests have been submitted yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['year', 'term', 'payment_status', 'admin_status', 'search']))
                        <a href="{{ route('admin.requests') }}" class="btn btn-primary">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: none;
}

.text-success {
    color: #28a745 !important;
}

.btn-group .btn {
    margin-right: 2px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

/* Hide pagination arrows */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    display: none;
}

.fa-spin {
    animation: fa-spin 2s infinite linear;
}

@keyframes fa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush
