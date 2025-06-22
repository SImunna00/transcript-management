@extends('layouts.students')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-exclamation-triangle"></i> Payment Cancelled</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-warning">Payment Cancelled</h3>
                    <p class="lead">You have cancelled the payment process.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('transcript.create') }}" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Try Again
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection