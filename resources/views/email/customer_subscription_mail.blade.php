@extends('email.layout')

@section('title', 'RUTI Self Checkout Subscription')
@section('content')
	<div>
		<h3 style="text-align: center;">${{$new_subscription->membershipItem->price}} payment for "{{$new_subscription->membership->name.' '.$new_subscription->membershipItem->billing_period.'ly'}} Subscription" was successful.</h3>
		<p>Dear {{$user->first_name.' '.$user->last_name}},</p>
		<br>
		<p>Thank you for subscribing the {{$new_subscription->membership->name}} membership.</p>
		<p>As a subscriber member, we introduce you to some of the additional features of our store that many customers find helpful.</p>
		@if($new_subscription->membership->code == 'bougie' && $old_subscription->is_used_bougie == 0)
			<p>Enjoy 30 days free trial for Bougie membership </p>
		@endif
		@if($new_subscription->membership->code == 'bougie' && $old_subscription->membership->code != 'explorer' && $old_subscription->is_used_bougie == 0)
			<p>We will adjust the proration price in your next billing.</p>
		@endif
		<br>
		<p>Thanks, <br> RUTI Self Checkout Team</p>
	</div>
@endsection