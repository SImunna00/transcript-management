@extends('layouts.students')

@section('title', 'View Results')
@section('page-title', 'View Results')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">View Results</li>
@endsection

@section('content')
    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>Filter Results
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('student.viewResult') }}">
                        <div class="row">



                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_year">Year</label>
                                    <select name="year" id="filter_year" class="form-control">
                                        <option value="">All Years</option>
                                        <option value="1st" {{ request('year') == '1st' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd" {{ request('year') == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd" {{ request('year') == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th" {{ request('year') == '4th' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_term">Term</label>
                                    <select name="term" id="filter_term" class="form-control">
                                        <option value="">All Terms</option>
                                        <option value="1st Term" {{ request('term') == '1st Term' ? 'selected' : '' }}>1st
                                            Term</option>
                                        <option value="2nd Term" {{ request('term') == '2nd Term' ? 'selected' : '' }}>2nd
                                            Term</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_status">Status</label>
                                    <select name="status" id="filter_status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('student.viewResult') }}" class="btn btn-secondary">
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

    <!-- Results Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>Your Result Requests
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">{{ $requests->total() ?? 0 }} Total Requests</span>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    @if(isset($requests) && $requests->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>Request ID</th>
                                    <th>Academic Year</th>
                                    <th>Term</th>
                                    <th>Request Date</th>
                                    <th>Payment Status</th>
                                    <th>Admin Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td><strong>#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-primary mr-1"></i>
                                            {{ $request->year ?? $request->academic_year ?? 'N/A' }}
                                        </td>
                                        <td><i class="fas fa-book text-info mr-1"></i> {{ $request->term }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $request->created_at->format('M d, Y') }}<br>
                                                {{ $request->created_at->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="text-success">
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
                                            <span class="text-success">
                                                @if($request->admin_status === 'approved')
                                                    <i class="fas fa-check"></i> Approved
                                                @elseif($request->admin_status === 'pending')
                                                    <i class="fas fa-hourglass-half"></i> Under Review
                                                @elseif($request->admin_status === 'rejected')
                                                    <i class="fas fa-times"></i> Rejected
                                                @elseif($request->admin_status === 'processing')
                                                    <i class="fas fa-cog fa-spin"></i> Processing
                                                @else
                                                    <i class="fas fa-question"></i> Not Reviewed
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- View Details Button -->
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#detailModal{{ $request->id }}" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Retry Payment Button (for pending/failed payments) -->
                                                @if($request->payment_status === 'pending' || $request->payment_status === 'failed')
                                                    <a href="{{ route('payment.initiate', $request->id) }}"
                                                        class="btn btn-sm btn-warning" title="Retry Payment">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>
                                                @endif

                                                <!-- Download Result Button (for approved requests with files) -->
                                                @if($request->admin_status === 'approved' && $request->result_file)
                                                    <a href="{{ route('student.downloadResult', $request->id) }}"
                                                        class="btn btn-sm btn-success" title="Download Result">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif

                                                <!-- Delete Request Button (for unpaid requests only) -->
                                                @if($request->payment_status !== 'paid')
                                                    <form action="{{ route('student.deleteRequest', $request->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this request?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Request">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Request Details -
                                                        #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong>Academic Year:</strong> {{ $request->year }}<br>
                                                            <strong>Term:</strong> {{ $request->term }}<br>
                                                            <strong>Request Date:</strong>
                                                            {{ $request->created_at->format('M d, Y h:i A') }}<br>
                                                            <strong>Payment Amount:</strong>
                                                            ৳{{ number_format($request->amount, 2) }}<br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Payment Status:</strong>
                                                            <span class="text-success">
                                                                @if($request->payment_status === 'paid')
                                                                    <i class="fas fa-check-circle"></i> Paid
                                                                @elseif($request->payment_status === 'pending')
                                                                    <i class="fas fa-clock"></i> Pending
                                                                @elseif($request->payment_status === 'failed')
                                                                    <i class="fas fa-times-circle"></i> Failed
                                                                @else
                                                                    <i class="fas fa-question-circle"></i> Unknown
                                                                @endif
                                                            </span><br>
                                                            <strong>Admin Status:</strong>
                                                            <span class="text-success">
                                                                @if($request->admin_status === 'approved')
                                                                    <i class="fas fa-check"></i> Approved
                                                                @elseif($request->admin_status === 'pending')
                                                                    <i class="fas fa-hourglass-half"></i> Under Review
                                                                @elseif($request->admin_status === 'rejected')
                                                                    <i class="fas fa-times"></i> Rejected
                                                                @elseif($request->admin_status === 'processing')
                                                                    <i class="fas fa-cog fa-spin"></i> Processing
                                                                @else
                                                                    <i class="fas fa-question"></i> Not Reviewed
                                                                @endif
                                                            </span><br>
                                                            @if($request->admin_notes)
                                                                <strong>Admin Notes:</strong><br>
                                                                <p class="text-muted">{{ $request->admin_notes }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($request->additional_info)
                                                        <hr>
                                                        <strong>Additional Information:</strong>
                                                        <p>{{ $request->additional_info }}</p>
                                                    @endif
                                                    @if($request->transaction_id)
                                                        <hr>
                                                        <strong>Transaction ID:</strong> {{ $request->transaction_id }}
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    @if($request->admin_status === 'approved' && $request->result_file)
                                                        <a href="{{ route('student.downloadResult', $request->id) }}"
                                                            class="btn btn-success">
                                                            <i class="fas fa-download"></i> Download Result
                                                        </a>
                                                    @endif
                                                    @if($request->payment_status === 'pending' || $request->payment_status === 'failed')
                                                        <a href="{{ route('payment.initiate', $request->id) }}" class="btn btn-warning">
                                                            <i class="fas fa-credit-card"></i> Retry Payment
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Result Requests Found</h5>
                            <p class="text-muted">You haven't made any result requests yet.</p>
                            <a href="{{ route('student.applyResult') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Make Your First Request
                            </a>
                        </div>
                    @endif
                </div>

                @if(isset($requests) && $requests->hasPages())
                    <div class="card-footer clearfix">
                        <div class="float-right">
                            {{ $requests->appends(request()->query())->links() }}
                        </div>
                        <div class="float-left">
                            <small class="text-muted">
                                Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }}
                                requests
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body text-center">
                    <h5>Need to make a new request?</h5>
                    <a href="{{ route('student.applyResult') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus mr-2"></i> Request New Results
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table th {
            border-top: none;
        }

        /* Status text styling */
        .text-success {
            color: #28a745 !important;
            font-weight: 500;
        }

        /* Remove hover effects on table rows */
        .table-hover tbody tr:hover {
            color: inherit;
            background-color: rgba(0, 0, 0, .075);
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .modal-body strong {
            color: #495057;
        }

        /* Hide pagination arrows */
        .pagination .page-link {
            border: 1px solid #dee2e6;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            display: none;
        }

        /* Alternative: Just hide the arrow symbols */
        .pagination .page-item:first-child .page-link::before,
        .pagination .page-item:last-child .page-link::after {
            display: none;
        }

        /* Ensure all table content is always visible */
        .table td {
            position: relative;
        }

        /* Spinning animation for processing status */
        .fa-spin {
            animation: fa-spin 2s infinite linear;
        }

        @keyframes fa-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush