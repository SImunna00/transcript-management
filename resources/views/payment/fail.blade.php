@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4><i class="fas fa-times-circle"></i> Payment Failed</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-danger">Payment Failed!</h3>
                    <p class="lead">Unfortunately, your payment could not be processed.</p>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Try Again
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Go to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection