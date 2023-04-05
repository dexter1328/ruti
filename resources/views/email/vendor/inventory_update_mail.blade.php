@extends('email.layout')

@section('title', 'RUTI Self Checkout Inventory Reminder')
@section('content')
	<div>
		<p>Dear {{$user->name}},</p>
		<br>
		<p>You haven't updated inventory for your "{{$user->store_name}}" store since last week<./p>
		<p>It is time to update inventory. Please follow the steps to complete the process.</p>
		<br>
		<p>Thanks, <br> RUTI Self Checkout Team</p>
	</div>
@endsection