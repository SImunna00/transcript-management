{{-- resources/views/admin/requests.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Transcript Requests Management
            </h3>
        </div>
        <div class="card-body">
            {{-- @if(session('success')) --}}
                {{-- <div class="alert alert-success alert-dismissible fade show"> --}}
                    {{-- {{ session('success') }} --}}
                    {{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
                {{-- </div> --}}
            {{-- @endif --}}

            {{-- @if($requests->isEmpty()) --}}
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No Requests Found</h5>
                    <p class="text-muted">No transcript requests have been submitted yet.</p>
                </div>
            {{-- @else --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Academic Year</th>
                                <th>Term</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Request Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($requests as $request) --}}
                                <tr>
                                    <td>{{-- {{ $request->user->name }} --}}</td>
                                    <td>{{-- {{ $request->user->student_id ?? 'N/A' }} --}}</td>
                                    <td>{{-- {{ $request->academic_year }} --}}</td>
                                    <td>{{-- {{ $request->term }} --}}</td>
                                    <td>
                                        <span class="badge {{-- {{ $request->payment_status_badge }} --}}">
                                            {{-- {{ ucfirst($request->payment_status) }} --}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{-- {{ $request->status_badge }} --}}">
                                            {{-- {{ ucfirst($request->status) }} --}}
                                        </span>
                                    </td>
                                    <td>{{-- {{ $request->created_at->format('M d, Y') }} --}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" 
                                                    data-toggle="modal" data-target="#statusModal{{-- {{ $request->id }} --}}">
                                                <i class="fas fa-edit"></i> Status
                                            </button>
                                            
                                            {{-- @if($request->payment_status === 'paid') --}}
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-toggle="modal" data-target="#uploadModal{{-- {{ $request->id }} --}}">
                                                    <i class="fas fa-upload"></i> Upload
                                                </button>
                                            {{-- @endif --}}
                                        </div>
                                    </td>
                                </tr>

                                {{-- Status Update Modal --}}
                                <div class="modal fade" id="statusModal{{-- {{ $request->id }} --}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{-- {{ route('admin.update-status', $request->id) }} --}}">
                                                {{-- @csrf --}}
                                                {{-- @method('PUT') --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Request Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Student: {{-- {{ $request->user->name }} --}}</label>
                                                        <br><small class="text-muted">{{-- {{ $request->academic_year }} --}} - {{-- {{ $request->term }} --}}</small>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="pending" {{-- {{ $request->status === 'pending' ? 'selected' : '' }} --}}>Pending</option>
                                                            <option value="processing" {{-- {{ $request->status === 'processing' ? 'selected' : '' }} --}}>Processing</option>
                                                            <option value="completed" {{-- {{ $request->status === 'completed' ? 'selected' : '' }} --}}>Completed</option>
                                                            <option value="rejected" {{-- {{ $request->status === 'rejected' ? 'selected' : '' }} --}}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="admin_notes">Admin Notes (Optional)</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" 
                                                                placeholder="Add any notes for the student...">{{-- {{ $request->admin_notes }} --}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Upload Transcript Modal --}}
                                {{-- @if($request->payment_status === 'paid') --}}
                                <div class="modal fade" id="uploadModal{{-- {{ $request->id }} --}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{-- {{ route('admin.upload-transcript', $request->id) }} --}}" enctype="multipart/form-data">
                                                {{-- @csrf --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Upload Transcript</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Student: {{-- {{ $request->user->name }} --}}</label>
                                                        <br><small class="text-muted">{{-- {{ $request->academic_year }} --}} - {{-- {{ $request->term }} --}}</small>
                                                    </div>
                                                    
                                                    {{-- @if($request->transcript_file) --}}
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle mr-2"></i>
                                                            A transcript has already been uploaded. Uploading a new file will replace the existing one.
                                                        </div>
                                                    {{-- @endif --}}
                                                    
                                                    <div class="form-group">
                                                        <label for="transcript">Transcript File (PDF only)</label>
                                                        <input type="file" name="transcript" class="form-control-file" accept=".pdf" required>
                                                        <small class="form-text text-muted">Maximum file size: 10MB</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-upload mr-2"></i>Upload Transcript
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{-- {{ $requests->links() }} --}}
                </div>
            {{-- @endif --}}
        </div>
    </div>
</div>

{{-- Custom CSS for better styling --}}
<style>
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.badge {
    font-size: 0.875em;
}

.btn-group .btn {
    margin-right: 2px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection
