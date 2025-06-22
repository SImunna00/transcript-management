{{-- resources/views/admin/modals/status-update.blade.php --}}
<div class="modal fade" id="statusModal{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.update-status', $request->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>Update Request Status
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Student:</strong> {{ $request->user->name ?? 'N/A' }}<br>
                        <strong>Request:</strong> {{ $request->year ?? 'N/A' }} - {{ $request->term ?? 'N/A' }}<br>
                        <strong>Payment:</strong> 
                        <span class="text-success font-weight-bold">
                            @if($request->payment_status === 'paid')
                                <i class="fas fa-check-circle"></i> Paid
                            @else
                                <i class="fas fa-clock"></i> {{ ucfirst($request->payment_status) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="status{{ $request->id }}">Admin Status <span class="text-danger">*</span></label>
                        <select name="admin_status" id="status{{ $request->id }}" class="form-control" required>
                            <option value="pending" {{ $request->admin_status === 'pending' ? 'selected' : '' }}>
                                Pending Review
                            </option>
                            <option value="processing" {{ $request->admin_status === 'processing' ? 'selected' : '' }}>
                                Processing
                            </option>
                            <option value="approved" {{ $request->admin_status === 'approved' ? 'selected' : '' }}>
                                Approved
                            </option>
                            <option value="rejected" {{ $request->admin_status === 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_notes{{ $request->id }}">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes{{ $request->id }}" 
                                  class="form-control" rows="4" 
                                  placeholder="Add any notes for the student or for internal reference...">{{ $request->admin_notes }}</textarea>
                        <small class="form-text text-muted">
                            These notes will be visible to the student in their request details.
                        </small>
                    </div>

                    @if($request->payment_status !== 'paid')
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Note:</strong> Payment is not completed yet. Consider this when updating the status.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
