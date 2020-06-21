@extends('pages.main')

@section('title', 'Order Dashboard')
@push('scripts')
	<script defer src="/js/home.js"></script>
@endpush

@section('content')	
    
<table id="orderOverview" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>Customer Status</th>
            <th>Total Order (count: The last 3 months)</th>
            <th>Total Order (Amount: The last 3 months)</th>
        </tr>
    </thead>
</table>
    
@endsection
