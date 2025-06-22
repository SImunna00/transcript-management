{{-- resources/views/admin/modals/upload-transcript.blade.php --}}
<div class="modal fade" id="uploadModal{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.upload-transcript', $request->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-upload mr-2"></i>Upload Transcript
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Student:</strong> {{ $request->user->name ?? 'N/A' }}<br>
                        <strong>Request:</strong> {{ $request->year ?? 'N/A' }} - {{ $request->term ?? 'N/A' }}<br>
                        <strong>Payment Status:</strong> 
                        <span class="text-success"><i class="fas fa-check-circle"></i> Paid</span>
                    </div>
                    
                    @if($request->result_file)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Current File:</strong> A transcript has already been uploaded. 
                            Uploading a new file will replace the existing one.
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="transcript{{ $request->id }}">
                            Transcript File <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="result_file" id="transcript{{ $request->id }}" 
                               class="form-control-file" accept=".pdf" required>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Only PDF files are allowed. Maximum file size: 10MB
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="auto_approve{{ $request->id }}" 
                                   name="auto_approve" value="1" checked>
                            <label class="form-check-label" for="auto_approve{{ $request->id }}">
                                Automatically approve this request after upload
                            </label>
                        </div>
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
