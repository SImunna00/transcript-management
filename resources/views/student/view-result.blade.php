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
                                    {{-- @for($i = date('Y'); $i >= 2015; $i--) --}}
                                        {{-- <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option> --}}
                                    {{-- @endfor --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter_term">Term</label>
                                <select name="term" id="filter_term" class="form-control">
                                    <option value="">All Terms</option>
                                    {{-- <option value="1st Semester" {{ request('term') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd Semester" {{ request('term') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="Summer" {{ request('term') == 'Summer' ? 'selected' : '' }}>Summer</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter_status">Status</label>
                                <select name="status" id="filter_status" class="form-control">
                                    <option value="">All Status</option>
                                    {{-- <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option> --}}
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
                    {{-- <span class="badge badge-primary">{{ $requests->total() ?? 0 }} Total Requests</span> --}}
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                {{-- @if(isset($requests) && $requests->count() > 0) --}}
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
                            {{-- @foreach($requests as $request) --}}
                                <tr>
                                    <td><strong>{{-- #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }} --}}</strong></td>
                                    <td><i class="fas fa-calendar-alt text-primary mr-1"></i> {{-- {{ $request->year }} --}}</td>
                                    <td><i class="fas fa-book text-info mr-1"></i> {{-- {{ $request->term }} --}}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{-- {{ $request->created_at->format('M d, Y') }} --}}<br>
                                            {{-- {{ $request->created_at->format('h:i A') }} --}}
                                        </small>
                                    </td>
                                    <td>
                                        {{-- @if($request->payment_status === 'paid') --}}
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Paid</span>
                                        {{-- @elseif($request->payment_status === 'pending') --}}
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                        {{-- @else --}}
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Failed</span>
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        {{-- @if($request->admin_status === 'approved') --}}
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Approved</span>
                                        {{-- @elseif($request->admin_status === 'pending') --}}
                                            <span class="badge badge-info"><i class="fas fa-hourglass-half"></i> Under Review</span>
                                        {{-- @elseif($request->admin_status === 'rejected') --}}
                                            <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                                        {{-- @else --}}
                                            <span class="badge badge-secondary"><i class="fas fa-question"></i> Not Reviewed</span>
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{-- {{ $request->id }} --}}"><i class="fas fa-eye"></i></button>

                                            {{-- @if($request->payment_status === 'pending' || $request->payment_status === 'failed') --}}
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-credit-card"></i></a>
                                            {{-- @endif --}}

                                            {{-- @if($request->admin_status === 'approved' && $request->result_file) --}}
                                                <a href="#" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
                                            {{-- @endif --}}

                                            {{-- @if($request->payment_status !== 'paid') --}}
                                                <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            {{-- @endif --}}
                                        </div>
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                {{-- <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1"> --}}
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            {{-- <h4 class="modal-title">Request Details - #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</h4> --}}
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{-- <strong>Academic Year:</strong> {{ $request->year }}<br>
                                                    <strong>Term:</strong> {{ $request->term }}<br>
                                                    <strong>Request Date:</strong> {{ $request->created_at->format('M d, Y h:i A') }}<br>
                                                    <strong>Payment Amount:</strong> ৳500<br> --}}
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <strong>Payment Status:</strong> 
                                                    <span class="badge badge-warning">{{ ucfirst($request->payment_status) }}</span><br>
                                                    <strong>Admin Status:</strong> 
                                                    <span class="badge badge-info">{{ ucfirst($request->admin_status) }}</span><br>
                                                    @if($request->admin_notes)
                                                        <strong>Admin Notes:</strong><br>
                                                        <p class="text-muted">{{ $request->admin_notes }}</p>
                                                    @endif --}}
                                                </div>
                                            </div>
                                            {{-- @if($request->additional_info)
                                                <hr>
                                                <strong>Additional Information:</strong>
                                                <p>{{ $request->additional_info }}</p>
                                            @endif --}}
                                        </div>
                                        <div class="modal-footer">
                                            {{-- @if($request->admin_status === 'approved' && $request->result_file)
                                                <a href="#" class="btn btn-success"><i class="fas fa-download"></i> Download Result</a>
                                            @endif --}}
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                {{-- @else --}}
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Result Requests Found</h5>
                        <p class="text-muted">You haven't made any result requests yet.</p>
                        <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Make Your First Request</a>
                    </div>
                {{-- @endif --}}
            </div>

            {{-- @if(isset($requests) && $requests->hasPages()) --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{-- {{ $requests->links() }} --}}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            {{-- Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} requests --}}
                        </small>
                    </div>
                </div>
            {{-- @endif --}}
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-body text-center">
                <h5>Need to make a new request?</h5>
                <a href="#" class="btn btn-primary btn-lg"><i class="fas fa-plus mr-2"></i> Request New Results</a>
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
.badge {
    font-size: 0.8em;
}
</style>
@endpush
