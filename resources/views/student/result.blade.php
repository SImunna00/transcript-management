@extends('layouts.students')

@section('title', 'Request Results')
@section('page-title', 'Request Results')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Request Results</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Request Your Academic Results
                </h3>
            </div>
            
            <form action="{{ route('payment.initiate') }}" method="POST" id="requestForm">
                @csrf
                <div class="card-body">
                    <!-- Academic Year Selection -->
                    <div class="form-group">
                        <label for="year">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Academic Year <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('year') is-invalid @enderror" 
                                id="year" name="year" required>
                            <option value="">-- Select Academic Year --</option>
                            <option value="1" {{ old('year') == '1' ? 'selected' : '' }}>
                                1st Year
                            </option>
                            <option value="2" {{ old('year') == '2' ? 'selected' : '' }}>
                                2nd Year
                            </option>
                            <option value="3" {{ old('year') == '3' ? 'selected' : '' }}>
                                3rd Year
                            </option>
                            <option value="4" {{ old('year') == '4' ? 'selected' : '' }}>
                                4th Year
                            </option>
                        </select>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Term/Semester Selection -->
                    <div class="form-group">
                        <label for="term">
                            <i class="fas fa-book mr-1"></i>
                            Term/Semester <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('term') is-invalid @enderror" 
                                id="term" name="term" required>
                            <option value="">-- Select Term/Semester --</option>
                            <option value="1st Semester" {{ old('term') == '1st Semester' ? 'selected' : '' }}>
                                1st Semester
                            </option>
                            <option value="2nd Semester" {{ old('term') == '2nd Semester' ? 'selected' : '' }}>
                                2nd Semester
                            </option>
                        </select>
                        @error('term')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount Input Field -->
                    <div class="form-group">
                        <label for="amount">
                            <i class="fas fa-money-bill-alt mr-1"></i>
                            Amount <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                               id="amount" name="amount" value="{{ old('amount') }}" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Information -->
                    <div class="form-group">
                        <label for="additional_info">
                            <i class="fas fa-info-circle mr-1"></i>
                            Additional Information (Optional)
                        </label>
                        <textarea class="form-control" id="additional_info" name="additional_info" 
                                  rows="3" placeholder="Any specific requirements or notes...">{{ old('additional_info') }}</textarea>
                    </div>

                    <!-- Check for existing requests -->
                    <div id="existingRequestAlert" class="alert alert-warning" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Notice:</strong> You already have a request for this year and term. 
                        Please check your <a href="{{ route('student.viewResult') }}">View Results</a> page.
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset Form
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-credit-card mr-2"></i>
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Check for existing requests when year and term are selected
    $('#year, #term').change(function() {
        var year = $('#year').val();
        var term = $('#term').val();
        
        if (year && term) {
            checkExistingRequest(year, term);
        }
    });

    function checkExistingRequest(year, term) {
        $.ajax({
            url: "#",  // Replace with actual URL
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                year: year,
                term: term
            },
            success: function(response) {
                if (response.exists) {
                    $('#existingRequestAlert').show();
                    $('#submitBtn').prop('disabled', true).text('Request Already Exists');
                } else {
                    $('#existingRequestAlert').hide();
                    $('#submitBtn').prop('disabled', false).html('<i class="fas fa-credit-card mr-2"></i>Proceed to Payment');
                }
            }
        });
    }

    // Form submission with loading state
    $('#requestForm').submit(function() {
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
    });
});

function resetForm() {
    $('#requestForm')[0].reset();
    $('#existingRequestAlert').hide();
    $('#submitBtn').prop('disabled', false).html('<i class="fas fa-credit-card mr-2"></i>Proceed to Payment');
}
</script>
@endpush
