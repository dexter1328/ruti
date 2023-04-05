@extends('email.layout')

@section('title', 'RUTI Self Checkout Weekly Suggested Stores by Customer')
@section('content')
	<div>
		<p>Dear Joseph,</p>
		<br>
		<p>Here is the list of suggested stores by customer in the previous week.</p>
		<table border="1" cellpadding="5" cellspacing="5">
			<tr>
				<th>Store</th>
				<th>Address</th>
				<th>Email</th>
				<th>Phone</th>
			</tr>
			@foreach($suggested_stores as $suggested_store)
			<tr>
				<td>{{$suggested_store->store}}</td>
				<td>{{$suggested_store->address}}</td>
				<td>{{$suggested_store->email}}</td>
				<td>{{$suggested_store->mobile_no}}</td>
			</tr>
			@endforeach
		</table>
		<br>
		<p>Thanks, <br> RUTI Self Checkout Team</p>
	</div>
@endsection