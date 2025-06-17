@extends('layouts.app')

@section('title','Home')


@push('style')

    <style>


    </style>
@endpush

@section('content')

<div>
    <a href="{{ route('register') }}" class="btn btn-primary">
    Register
</a>
</div>


@endsection



@push('script')

    <script>
  
        
    </script>
@endpush