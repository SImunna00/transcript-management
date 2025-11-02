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
                            <select class="form-control @error('year') is-invalid @enderror" id="year" name="year" required>
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

                        <!-- Session Input Field -->
                        <div class="form-group">
                            <label for="session">
                                <i class="fas fa-university mr-1"></i>
                                Session <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('session') is-invalid @enderror" id="session" name="session"
                                required>
                                <option value="">-- Select Session --</option>
                                <option value="2007-2008" {{ old('session') == '2007-2008' ? 'selected' : '' }}>2007-2008
                                </option>
                                <option value="2008-2009" {{ old('session') == '2008-2009' ? 'selected' : '' }}>2008-2009
                                </option>
                                <option value="2009-2010" {{ old('session') == '2009-2010' ? 'selected' : '' }}>2009-2010
                                </option>
                                <option value="2010-2011" {{ old('session') == '2010-2011' ? 'selected' : '' }}>2010-2011
                                </option>
                                <option value="2011-2012" {{ old('session') == '2011-2012' ? 'selected' : '' }}>2011-2012
                                </option>
                                <option value="2012-2013" {{ old('session') == '2012-2013' ? 'selected' : '' }}>2012-2013
                                </option>
                                <option value="2013-2014" {{ old('session') == '2013-2014' ? 'selected' : '' }}>2013-2014
                                </option>
                                <option value="2014-2015" {{ old('session') == '2014-2015' ? 'selected' : '' }}>2014-2015
                                </option>
                                <option value="2015-2016" {{ old('session') == '2015-2016' ? 'selected' : '' }}>2015-2016
                                </option>
                                <option value="2016-2017" {{ old('session') == '2016-2017' ? 'selected' : '' }}>2016-2017
                                </option>
                                <option value="2017-2018" {{ old('session') == '2017-2018' ? 'selected' : '' }}>2017-2018
                                </option>
                                <option value="2018-2019" {{ old('session') == '2018-2019' ? 'selected' : '' }}>2018-2019
                                </option>
                                <option value="2019-2020" {{ old('session') == '2019-2020' ? 'selected' : '' }}>2019-2020
                                </option>
                                <option value="2020-2021" {{ old('session') == '2020-2021' ? 'selected' : '' }}>2020-2021
                                </option>
                                <option value="2021-2022" {{ old('session') == '2021-2022' ? 'selected' : '' }}>2021-2022
                                </option>
                                <option value="2022-2023" {{ old('session') == '2022-2023' ? 'selected' : '' }}>2022-2023
                                </option>
                                <option value="2023-2024" {{ old('session') == '2023-2024' ? 'selected' : '' }}>2023-2024
                                </option>
                                <option value="2024-2025" {{ old('session') == '2024-2025' ? 'selected' : '' }}>2024-2025
                                </option>
                                <option value="2025-2026" {{ old('session') == '2025-2026' ? 'selected' : '' }}>2025-2026
                                </option>
                                <option value="2026-2027" {{ old('session') == '2026-2027' ? 'selected' : '' }}>2026-2027
                                </option>
                                <option value="2027-2028" {{ old('session') == '2027-2028' ? 'selected' : '' }}>2027-2028
                                </option>
                                <option value="2028-2029" {{ old('session') == '2028-2029' ? 'selected' : '' }}>2028-2029
                                </option>
                                <option value="2029-2030" {{ old('session') == '2029-2030' ? 'selected' : '' }}>2029-2030
                                </option>
                            </select>
                            @error('session')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Term/Semester Selection -->
                        <div class="form-group">
                            <label for="term">
                                <i class="fas fa-book mr-1"></i>
                                Term/Semester <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('term') is-invalid @enderror" id="term" name="term" required>
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
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                name="amount" value="50" readonly required>
                            <small class="form-text text-muted">Fixed fee: 50 taka</small>
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
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3"
                                placeholder="Any specific requirements or notes...">{{ old('additional_info') }}</textarea>
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
        $(document).ready(function () {
            // Check for existing requests when year, session, and term are selected
            $('#year, #session, #term').change(function () {
                var year = $('#year').val();
                var session = $('#session').val();
                var term = $('#term').val();

                if (year && session && term) {
                    checkExistingRequest(year, session, term);
                }
            });

            function checkExistingRequest(year, session, term) {
                $.ajax({
                    url: "{{ route('student.check-existing-request') }}",  // Create this route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        year: year,
                        session: session,
                        term: term
                    },
                    success: function (response) {
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
            $('#requestForm').submit(function () {
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