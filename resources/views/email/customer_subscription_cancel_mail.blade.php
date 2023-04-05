@extends('email.layout')

@section('title', 'Nature Checkout Subscription')
@section('content')
	<div>
		<h3 style="text-align: center;">Your "{{$user->membership_name.' '.$user->billing_period.'ly'}} Subscription" has been expired.</h3>
		<p>Dear {{$user->first_name.' '.$user->last_name}},</p>
		<br>
		<p>There is an automated notification to let you know that your {{$user->membership_name}} subscription plan has been expired and your account has been downgraded to the free plan.</p>
		<br>
		<p>Thanks, <br> Nature Checkout Team</p>
	</div>
@endsection
