@extends('email.layout')

@section('title', 'Invoice Failed')
@section('content')
	@php
		/*$description = explode(' ', $user->description);
		$plan_type = $description[2];
		$interval= ucfirst(substr(end($description),0,-1));*/
		if (strpos($user->description, ' × ') !== false) {
			$description_arr = explode(' × ', $user->description);
			$description = $description_arr[1];
		}else{
			$description = $user->description;
		}
	@endphp
	<div>
		<h3 style="text-align: center;">${{number_format(($user->total/100),2,".","")}} payment for "{{$description}}" was unsuccessful</h3>
		<h4 style="text-align: center;">{{$card->brand}} ending in {{$card->last4}}</h4>
		<p>Dear {{$user->name}},</p>
		<p>This could be because</p>
		<ul>
			<li>You have insufficient funds in your account</li>
			<li>Your payment card has expired</li>
			<li>There is a problem with your bank</li>
		</ul>
		<br>
		<p><!-- We will attempt to charge you again on {{date("jS F Y", strtotime("+1 day"))}}.  -->Please update your payment information if necessary.</p>
		<br>
		<p>Thanks, <br> RUTI Self Checkout Team</p>
	</div>
@endsection