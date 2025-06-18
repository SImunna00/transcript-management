@extends('layouts.students')

@section('content')
    <div class="alert alert-success">
        Payment was successful! Your transaction ID: {{ $transactionId }}
    </div>
@endsection