@extends('pages.main')

@section('title', 'Order Dashboard')
@push('scripts')
	<script defer src="/js/home.js"></script>
@endpush

@push('links')
    <link rel="stylesheet" href="/css/home.css">
@endpush

@section('content')	
    
<table id="orderOverview" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>Customer Status</th>
            <th>Total Order (Count: The last 3 months)</th>
            <th>Total Order (Amount: The last 3 months)</th>
        </tr>
    </thead>
</table>
    
@endsection
