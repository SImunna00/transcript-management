@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Transcript Requests Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Academic Year</th>
                <th>Term</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Requested At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transcriptRequests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->user->name ?? 'N/A' }}</td>
                <td>{{ $request->academic_year }}</td>
                <td>{{ $request->term }}</td>
                <td>{{ $request->payment_status }}</td>
                <td>{{ $request->status }}</td>
                <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection