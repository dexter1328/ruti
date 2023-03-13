@extends('email.layout')

@section('title', 'Nature Checkout Subscription')
@section('content')
	<div>
		<h3 style="text-align: center;">${{$user->price}} payment for "{{$user->membership_name.' '.$user->billing_period.'ly'}} Subscription" was successful.</h3>
		<p>Dear {{$user->first_name.' '.$user->last_name}},</p>
		<br>
		<p>There is an automated notification to let you know that your {{$user->membership_name}} subscription plan has been renewed. Enjoy the subscription plan.</p>
		<br>
		<p>Thanks, <br> Nature Checkout Team</p>
	</div>
@endsection
