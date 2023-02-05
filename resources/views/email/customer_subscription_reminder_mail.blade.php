@extends('email.layout')

@section('title', 'RUTI Self Checkout Subscription')
@section('content')
	<div>
		<p>Dear {{$user->first_name.' '.$user->last_name}},</p>
		<br>
		<p>Thank you for using our {{$user->membership_name}} subscription. We love having you as our subscibe member. Your {{$user->membership_name}} subscription plan will expire in {{$days}} day(s).</p>
		<p>If you want to continue taking advantage of this plan and retain all your data and preferences, you need to add amount in wallet.</p>
		<br>
		<p>Thanks, <br> RUTI Self Checkout Team</p>
	</div>
@endsection