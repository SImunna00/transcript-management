{{-- resources/views/admin/modals/request-detail.blade.php --}}
<div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Request Details - #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-user mr-1"></i> Student Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $request->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Student ID:</strong></td>
                                <td>{{ $request->user->student_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $request->user->email ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-graduation-cap mr-1"></i> Academic Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Academic Year:</strong></td>
                                <td>{{ $request->year ?? $request->academic_year ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Term:</strong></td>
                                <td>{{ $request->term ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Request Date:</strong></td>
                                <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-credit-card mr-1"></i> Payment Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Amount:</strong></td>
                                <td>৳{{ number_format($request->amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Status:</strong></td>
                                <td>
                                    <span class="text-success font-weight-bold">
                                        @if($request->payment_status === 'paid')
                                            <i class="fas fa-check-circle"></i> Paid
                                        @elseif($request->payment_status === 'pending')
                                            <i class="fas fa-clock"></i> Pending
                                        @else
                                            <i class="fas fa-times-circle"></i> Failed
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @if($request->transaction_id)
                            <tr>
                                <td><strong>Transaction ID:</strong></td>
                                <td>{{ $request->transaction_id }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-tasks mr-1"></i> Processing Status</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Admin Status:</strong></td>
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
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>{{ $request->updated_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($request->additional_info)
                <hr>
                <h6 class="text-primary"><i class="fas fa-comment mr-1"></i> Additional Information</h6>
                <div class="bg-light p-3 rounded">
                    {{ $request->additional_info }}
                </div>
                @endif

                @if($request->admin_notes)
                <hr>
                <h6 class="text-primary"><i class="fas fa-sticky-note mr-1"></i> Admin Notes</h6>
                <div class="bg-warning p-3 rounded">
                    {{ $request->admin_notes }}
                </div>
                @endif

                @if($request->result_file)
                <hr>
                <h6 class="text-primary"><i class="fas fa-file-pdf mr-1"></i> Uploaded Transcript</h6>
                <div class="bg-success p-3 rounded text-white">
                    <i class="fas fa-check-circle mr-2"></i>
                    Transcript has been uploaded and is available for download.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                @if($request->result_file && file_exists(storage_path('app/' . $request->result_file)))
                    <a href="{{ route('admin.download-transcript', $request->id) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Transcript
                    </a>
                @endif
                <button type="button" class="btn btn-primary" 
                        data-dismiss="modal" data-toggle="modal" 
                        data-target="#statusModal{{ $request->id }}">
                    <i class="fas fa-edit"></i> Update Status
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
