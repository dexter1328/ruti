@extends('email.layout')

@section('title', 'Nature Checkout Weekly Registered Retailers')
@section('content')
	<div>
		<p>Dear Joseph,</p>
		<br>
		<p>Here is the registered retailer list in the previous week.</p>
		<table border="1" cellpadding="5" cellspacing="5">
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>Zip code</th>
			</tr>
			@foreach($users as $user)
			<tr>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->mobile_number}}</td>
				<td>{{$user->address}}</td>
				<td>{{$user->city}}</td>
				<td>{{$user->state}}</td>
				<td>{{$user->country}}</td>
				<td>{{$user->pincode}}</td>
			</tr>
			@endforeach
		</table>
		<br>
		<p>Thanks, <br> Nature Checkout Team</p>
	</div>
@endsection
