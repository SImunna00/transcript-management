@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-check-circle"></i> Payment Successful</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-success">Payment Completed Successfully!</h3>
                    <p class="lead">Your transcript request has been processed.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <strong>Transaction ID:</strong><br>
                            <span class="text-muted">{{ $transactionId }}</span>
                        </div>
                        @isset($order)
                        <div class="col-md-6">
                            <strong>Request ID:</strong><br>
                            <span class="text-muted">#{{ $order->id }}</span>
                        </div>
                        @endisset
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Go to Home
                        </a>
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list"></i> Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection