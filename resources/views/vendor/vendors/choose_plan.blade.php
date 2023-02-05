@extends('vendor.layout.main')
@section('content')
<style type="text/css">
.btn-outline-primary:not(:disabled):not(.disabled).active, .btn-outline-primary:not(:disabled):not(.disabled):active, .show > .btn-outline-primary.dropdown-toggle {
    color: #fff !important;
    background-color: #ec6224 !important;
    border-color: #ec6224 !important;
}
div#cardModal {
	width: 50%;
	margin: 0 auto;
}

div#thnksModal {
	width: 45%;
	margin: 0 auto;
}
</style>
@if(session()->get('success'))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success') }}</span>
		</div>
	</div>
@endif
@php
//echo '<pre>';
/*foreach($features as $key => $feature){
	print_r($feature['label']);
}*/
//print_r($features);
//print_r($memberships->toArray());
//echo '</pre>';
//exit();
@endphp
<div id="currentPlanAlert" style="display: none;">
	<div class="alert alert-dark" role="alert">
		<div class="alert-message" id="currentPlanMsg">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card mb-4 box-shadow">
			<div class="card-header">
				<div class="row">
					<div class="col-4">
						<div class="left">
							<span>Subscription Plans</span>
						</div>
					</div>
					<div class="col-8">
						<div class="right">
							<div class="row">
								<div class="col-6">
									<select name="store" id="store" class="form-control">
										<option value="">--Select Store--</option>
										@foreach($stores as $store)
											<option value="{{$store->id}}">{{$store->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-6">
									<div class="btn-group btn-group-toggle" data-toggle="buttons">
										<label class="btn btn-outline-primary btn-toggle active">
											<input type="radio" name="options" id="option1" autocomplete="off" value="month" checked> Monthly
										</label>
										<label class="btn btn-outline-primary btn-toggle">
											<input type="radio" name="options" id="option2" autocomplete="off" value="year"> Yearly
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table class="table">
					@php $i = 1; @endphp
					@foreach($features as $key => $feature)
						@if($i == 1)
							<tr>
								<th class="border-0" style="vertical-align: bottom !important;">
									<p><span class="h4">Features</span></p>
								</th>
								@foreach($memberships as $membership)
									<th class="text-center border-0">
										<h6>{{$membership->name}}</h6>
										<p class="font-weight-bold">
											$<span class="h2 membership_price" id="price_{{$membership->code}}">{{$membership->monthMembershipItem->price}}</span>
											<input type="hidden" id="membership_actual_price_{{$membership->code}}" value="{{$membership->monthMembershipItem->price}}">
										</p>
										<p class="small">Per <span class="interval_span">month</span></p>
									</th>
								@endforeach
							</tr>
						@endif
						<tr>
							<td>
								@if($feature['type'] == 'array')
									{{$feature['label']}}
									<table>
										@foreach($feature['values'] as $value)
										<tr>
											<td class="border-0" style="padding: 5px 30px;"> - {{$value['label']}}</td>
										</tr>
										@endforeach
									</table>
								@else
									{{$feature['label']}}
								@endif
							</td>
							@foreach($memberships as $membership)
								<td class="text-center">
									@if($feature['type'] == 'array')
										<table width="100%" style="margin-top: 20px;">
											@foreach($feature['values'] as $key2 => $value)
												@php $membership_description_key = (array)$membership->description->$key; @endphp
												@if(array_key_exists($key2, $membership_description_key))
													<tr>
														<td class="border-0" style="padding: 5px 30px;">{{$membership->description->$key->$key2}}</td>
													</tr>
												@else
													<tr>
														<td class="border-0" style="padding: 5px 30px;">&nbsp;</td>
													</tr>
												@endif
											@endforeach
										</table>
									@else
										@if(is_string($membership->description->$key))
											{{$membership->description->$key}}
										@endif
									@endif
								</td>
							@endforeach
						</tr>
						@if($i == count($features))

							<tr>
								<td colspan="3">
									One Time Setup Fee: ${{$one_time_setup_fee->discountMembershipItem->price}} per store
								</td>
								@php /* @endphp
								<td class="text-center"> 
									<span id="promo_code"></span>
									<br>
									<span id="promo_description"></span>
								</td>
								<td colspan="{{count($memberships)}}-1" class="text-center">
									<div id="promo_code_btn" style="display: none;">
										<input type="hidden" id="membership_coupon_id">
										<input type="hidden" id="promo_code_id">
										<input type="hidden" id="promo_code_name">
										<input type="hidden" id="promo_code_discount">
										<input type="button" class="btn-success" id="apply_promo_btn" value="Apply">
										<input type="button" class="btn-danger" id="remove_promo_btn" value="Remove" style="display: none;">
									</div>
								</td>
								@php */ @endphp
							</tr>
							<tr>
								<td colspan="3">
									Admin fee of 3% apply to every purchase transactions remitted.
								</td>
							</tr>
							<tr>
								<td colspan="{{count($memberships)+1}}">&nbsp;</td>
							</tr>
							<tr>
								<th colspan="{{count($memberships)+1}}">
									ADDITIONAL FEES
								</th>
							</tr>
							<tr>
								<td>
									Additional license per user/month
								</td>
								<td class="text-center">
									$41.99
								</td>
								<td colspan="{{count($memberships)-1}}">
									<select id="extra_license" name="extra_license" class="form-control">
										<option value="">Select Extra License</option>
										<option value="1">One Extra License</option>
										<option value="2">Two Extra License</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="{{count($memberships)+1}}">&nbsp;</td>
							</tr>
							<tr>
								<th colspan="{{count($memberships)+1}}">INCENTIVES</th>
							</tr>
							<tr>
								<td colspan="{{count($memberships)+1}}">
									15% off for every ( 2 ) additional licenses permitted to users to download app
								</td>
							</tr>
							<tr>
								<td colspan="{{count($memberships)+1}}">15% off for annual payment</td>
							</tr>
							<tr>
								<td colspan="{{count($memberships)+1}}">
									15% discount on next payment for  vendor referral, when new vendor registers
								</td>
							</tr>
							<tr id="btn-row" style="display: none;">
								<td>&nbsp;</td>
								@foreach($memberships as $membership)
									<td class="text-center">
										<form method="POST" class="sbscrtnFrm" id="{{$membership->code}}_form">
											<input type="hidden" name="membership_id" value="{{$membership->id}}">
											<input type="hidden" name="membership_code" value="{{$membership->code}}">
											<input type="hidden" id="item_id_{{$membership->code}}" name="membership_item_id" value="{{$membership->monthMembershipItem->id}}">
											<input type="hidden" id="price_id_{{$membership->code}}" name="stripe_price_id" value="{{$membership->monthMembershipItem->stripe_price_id}}">
											<button type="button" id="sub_btn_{{$membership->code}}" class="btn btn-block btn-outline-primary btn-rounded btnSbscrtnFrm" value="{{$membership->code}}" onclick="selectPlan('{{$membership->code}}');">Choose Plan</button>
										</form>
									</td>
								@endforeach
							</tr>
							<tr id="processing-row" style="display: none;">
								<td align="center" colspan="{{count($memberships)+1}}">
									<h5>Processing...</h5>
								</td>
							</tr>
							<tr id="error-row" style="display: none;">
								<td align="center" colspan="{{count($memberships)+1}}">
									<span id="error-text" class="text-danger"></span>
								</td>
							</tr>
						@endif
						@php $i++; @endphp
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<!-- card modal -->
<div class="modal fade" id="cardModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Card Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="error" class="text-danger"></div>
				<div id="success" class="text-success"></div>
				<input type="radio" name="cardSelection" value="cardList" checked="checked"> Card List
				<input type="radio" name="cardSelection" value="addCard"> Add New Card
				<div id="cardListDiv">
					<input type="hidden" id="card_count" name="card_count" value="{{count($cards)}}">
					<table class="table table-bordered mt-2">
						<thead>
							<tr>
								<th>Defualt</th>
								<th>Card Detail</th>
								<th>Expiry Date</th>
							</tr>
						</thead>
						<tbody id="cardListBody">
							@if(!empty($cards))
								@foreach($cards as $card)
									<tr>
										<td align="center">
											<input type="radio" name="card" value="{{$card['id']}}" @if($card['default'] == 1) checked @endif>
										</td>
										<td>
											{{$card['brand']}} ending in {{$card['last4']}}
										</td>
										<td align="right">
											{{sprintf("%02d", $card['exp_month'])}}/{{$card['exp_year']}}
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="3">No Cards Found.</td>
								</tr>
							@endif
						</tbody>
					</table>
					<button type="button" class="btn btn-primary px-5" id="subscriptionBtn">Subscribe</button>
					<span id="in_progress" style="display: none;">
						Processing...
						<br>Please do not close or refresh the tab.
					</span>
				</div>
				<div id="addCardDiv" style="display: none;">
					<form method="post">
						<div class="form-group">
							<label for="card-number">Card Number<span class="text-danger">*</span></label>
							<input type="text" id="card-number" name="card-number" class="form-control" required>
						</div>
						<div class="form-row">
							<div class="col-md-9 mb-3">
								<label>Expiry Month / Year<span class="text-danger">*</span></label>
								<div class="input-group">
									<select name="month" id="month" class="form-control" required>
										<option value=""> --Select--</option>
										<?php for ($i=1; $i<=12; $i++) { 
											$month = str_pad($i, 2, "0", STR_PAD_LEFT);?>
											<option value="<?php echo $month; ?>"><?php echo $month ?></option>
										<?php } ?>
									</select> 
									<select name="year" id="year" class="form-control" required>
										<option value=""> --Select--</option>
										<?php $start_year = date('Y'); $end_year = date('Y') + 20;
										for ($i=$start_year; $i<=$end_year; $i++) { ?>
											<option value="<?php echo substr($i, 2); ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3 mb-3">
								<label for="cvc">CVC<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="cvc" name="cvc" required>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary px-5" id="addCardBtn" onClick="addCard(event);">Add Card</button>
							<span id="processing" style="display: none;">Processing...</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>     
<!-- end modal -->
<!-- thank you modal -->
<div class="modal fade" id="thnksModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 id="thnksMsg" class="text-success" style="margin: 25px;"></h3>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	var setup_fee_required = '';
	var activeFrmID = '';
	var coupon_id = '';
	var calculate_discount = false;
	var subscriptionData = [];
	var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	
	function selectPlan(code) {
		var store = $("#store").val();
		if(store == ''){
			$("#store").focus();
		}else{
			activeFrmID = code+'_form';
			$("#"+activeFrmID).append("<input type='hidden' name='store_id' value='" + store + "' />");
			$('#cardModal').modal('show');
		}
	}

	function cardValidation() {

		var valid = true;
		var cardNumber = $('#card-number').val();
		var month = $('#month').val();
		var year = $('#year').val();
		var cvc = $('#cvc').val();

		if (cardNumber.trim() == "") {
			valid = false;
		}

		if (month.trim() == "") {
			valid = false;
		}
		if (year.trim() == "") {
			valid = false;
		}
		if (cvc.trim() == "") {
			valid = false;
		}
		
		if(valid == false) {
			$("#error").html("All Fields are required");
		}

		return valid;
	}

	//set your publishable key
	Stripe.setPublishableKey("{{Config::get('services.stripe.key')}}");

	//callback to handle the response from stripe
	function stripeResponseHandler(status, response) {
		if (response.error) {
			//enable the submit button
			$("#addCardBtn").show();
			$( "#processing" ).css("display", "none");
			//display the errors on the form
			$("#error").html(response.error.message).show();
		} else {

			//get token id
			var token = response['id'];
			/*//insert the token into the form
			$("#"+activeFrmID).append("<input type='hidden' name='stripe_card_token' value='" + token + "' />");
			//submit form to the server
			$("#"+activeFrmID).submit();*/

			saveCard(token);
		}
	}

	function addCard(e) {

		e.preventDefault();
		$("#error").html("");
		$("#success").html("");
		var valid = cardValidation();

		if(valid == true) {
			$("#addCardBtn").hide();
			$( "#processing" ).css("display", "inline-block");
			Stripe.createToken({
				number: $('#card-number').val(),
				cvc: $('#cvc').val(),
				exp_month: $('#month').val(),
				exp_year: $('#year').val()
			}, stripeResponseHandler);

			//submit from callback
			return false;
		}
	}

	function saveCard(token){

		$.ajax({
			type: "POST",
			url: "{{url('/vendor/save-vendor-card')}}/", 
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				stripeToken: token
			},
			dataType: "json",
			success: function(result){
				// console.log(result);
				$("#addCardBtn").show();
				$("#processing").css("display", "none");
				if(result.status == 'error'){
					$("#error").html(result.message);				
				}else{
					var card = result.data;
					var exp_month = ('0' + card.exp_month).slice(-2);
					$('input[type=radio][name=card]').prop('checked', false);
					var card_is_check = '';
					if($('#card_count').val() == 0){
						card_is_check == 'checked';
					}

					var str = '';
					str += '<tr>';
						str += '<td align="center">';
							str += '<input type="radio" name="card" value="'+card.id+'" '+card_is_check+'>';
						str += '</td>';
						str += '<td>';
							str += card.brand + ' ending in ' + card.last4;
						str += '</td>';
						str += '<td align="right">';
							str += exp_month + '/' + card.exp_year;
						str += '</td>';
					str += '</tr>';
					$('#success').html(result.message);
					if($('#card_count').val() > 0){
						$('#cardListBody').append(str);
					}else{
						$('#cardListBody').html(str);
					}
					$('input[type=radio][name=cardSelection][value=cardList]').prop('checked', true);
					$('#cardListDiv').show();
					$('#addCardDiv').hide();
				}
			}
		});
	}

	$(document).ready(function(){

		$('input[type=radio][name=options]').change(function() {

			getPlanByIntervalLicense();
		});

		$('input[type=radio][name=cardSelection]').change(function() {
			if (this.value == 'addCard') {
				$('#addCardDiv').show();
				$('#cardListDiv').hide();
			} else if (this.value == 'cardList') {
				$('#addCardDiv').hide();
				$('#cardListDiv').show();
			}
		});

		$('#subscriptionBtn').click(function() {

			var card_id = $("input[name='card']:checked").val();

			$('#subscriptionBtn').hide();
			$("#in_progress").show();

			if(setup_fee_required == 'no') {

				var extra_license = $('#extra_license').val();
				if(extra_license != '') {
					$("#"+activeFrmID).append("<input type='hidden' name='extra_license' value='" + extra_license + "' />");
				}
				$("#"+activeFrmID).append("<input type='hidden' name='stripe_card_id' value='" + card_id + "' />");

				// create subscription
				$.ajax({
					type: "POST",
					url: "{{route('vendor.create-subscription')}}",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: $("#"+activeFrmID).serialize(),
					dataType: "json",
					success: function(result){
						// console.log(result);
						$("#in_progress").hide();
						$('#subscriptionBtn').show();
						if(result.status == 'error'){
							$("#error").html(result.message);				
						}else{
							$("#error").html('');
							$("#thnksMsg").html(result.message);
							$("#cardModal").modal("hide");
							$("#thnksModal").modal("show");
						}
					}
				});
			} else {

				var store_id = $("#store").val();
				if(store_id != '') {

					$.ajax({
						type: "POST",
						url: "{{url('vendor/one-time-setup-fee')}}/"+store_id,
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: {card_id: card_id},
						dataType: "json",
						success: function(result){
							// console.log(result);
							$("#in_progress").hide();
							$('#subscriptionBtn').show();
							if(result.status == 'error'){
								$("#error").html(result.message);				
							}else{
								$("#error").html('');
								$("#thnksMsg").html(result.message);
								$("#cardModal").modal("hide");
								$("#thnksModal").modal("show");
							}
						}
					});
				} else {
					alert('Please select store.');
				}
			}
		});

		$('#extra_license').change(function() {
			getPlanByIntervalLicense();			
		});

		$('#thnksModal').on('hidden.bs.modal', function () {
			//location.reload();
			window.location.href = "{{url('/vendor/choose-plan')}}";
		})

		$('#store').change(function() {
			// var store_id = $(this).val();
			// checkSetUpFee(store_id);
			getSubscription();		
		});

		$('#apply_promo_btn').click(function(){
			coupon_id = $('#promo_code_id').val();
			var promo_name = $('#promo_code_name').val();
			$('#promo_code').html('Coupon <label id="promo_code_lbl">"'+promo_name+'"</label> applied!');
			$('#apply_promo_btn').hide();
			$('#remove_promo_btn').show();
			addCouponDiscount();
		});

		$('#remove_promo_btn').click(function(){
			coupon_id = '';
			var promo_name = $('#promo_code_name').val();
			$('#promo_code').html('Coupon <label id="promo_code_lbl">"'+promo_name+'"</label>');
			$('#apply_promo_btn').show();
			$('#remove_promo_btn').hide();
			removeCouponDiscount();
		});
	});

	function getPlanByIntervalLicense()
	{
		var interval = $('input[type=radio][name=options]:checked').val();
		$('.interval_span').text(interval);
		var license = $('#extra_license').val();

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{url('/vendor/get-plan-by-interval-license')}}/"+interval+"/"+license, 
			dataType: "json",
			success: function(result){
				var membership = result.membership;
				// var annual_coupon = result.coupon;
				// console.log(result);
				$.each(membership, function(i, item) {
					// console.log(item);
					if(interval == 'month'){

						if (item.hasOwnProperty('month_membership_item')) {
							var itemID = item.month_membership_item.id;
							var priceID = item.month_membership_item.stripe_price_id;
							var price = item.month_membership_item.price;
						}else if(item.hasOwnProperty('month_membership_item_one_license')) {
							var itemID = item.month_membership_item_one_license.id;
							var priceID = item.month_membership_item_one_license.stripe_price_id;
							var price = item.month_membership_item_one_license.price;
						}else if(item.hasOwnProperty('month_membership_item_two_license')) {
							var itemID = item.month_membership_item_two_license.id;
							var priceID = item.month_membership_item_two_license.stripe_price_id;
							var price = item.month_membership_item_two_license.price;
						}
					}else if(interval == 'year'){

						if (item.hasOwnProperty('year_membership_item')) {
							var itemID = item.year_membership_item.id;
							var priceID = item.year_membership_item.stripe_price_id;
							var price = item.year_membership_item.price;
						}else if (item.hasOwnProperty('year_membership_item_one_license')) {
							var itemID = item.year_membership_item_one_license.id;
							var priceID = item.year_membership_item_one_license.stripe_price_id;
							var price = item.year_membership_item_one_license.price;
						}else if (item.hasOwnProperty('year_membership_item_two_license')) {
							var itemID = item.year_membership_item_two_license.id;
							var priceID = item.year_membership_item_two_license.stripe_price_id;
							var price = item.year_membership_item_two_license.price;
						}
						/*if(annual_coupon != null){
							if(annual_coupon.type == "percentage_discount"){
								var dicount_price = (parseFloat(annual_coupon.amount) / 100) * parseFloat(price);
							}else {
								var dicount_price = parseFloat(annual_coupon.amount);
							}
							price = parseFloat(price) - dicount_price;
						}*/
					}
					$("#item_id_"+item.code).val(itemID);
					$("#price_id_"+item.code).val(priceID);
					$("#price_"+item.code).text(price.toFixed(2));
					$('#membership_actual_price_'+item.code).val(price.toFixed(2));
				});
				calculate_discount = false;
				addCouponDiscount();
				getSubscription();
			}
		});
	}

	function getSubscription()
	{
		$("#error-text").html('');
		$("#error-row").hide();
		var store_id = $('#store').val();
		if(store_id != ''){

			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{url('/vendor/get-subscription')}}/"+store_id,
				dataType: "json",
				success: function(result){

					setup_fee_required = result.is_setup_required;
					if(result.is_setup_required == 'no') {

						$("#btn-row").show();
						$('#subscriptionBtn').html('Subscribe');
						// console.log(result);
						var current_subscription = result.current_subscription;
						var pending_subscription = result.pending_subscription;

						// fetch the assign coupon here
						/*if($.isEmptyObject(current_subscription) && $.isEmptyObject(pending_subscription)){

							$.ajax({
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								url: "{{url('/vendor/get-assigned-coupon')}}/"+store_id,
								dataType: "json",
								success: function(response){

									// console.log(response);
									if($.isEmptyObject(response)){
										$('#membership_coupon_id').val();
										$('#promo_code_id').val('');
										$('#promo_code_name').val('');
										$('#promo_code_discount').val('');
										$('#promo_code').html('');
										$('#promo_code_btn').hide();
										$('#promo_description').html('');
									}else{
										$('#membership_coupon_id').val(response.id);
										$('#promo_code_id').val(response.stripe_coupon_id);
										$('#promo_code_name').val(response.name);
										$('#promo_code_discount').val(response.discount);
										$('#promo_code').html('Coupon <label id="promo_code_lbl">"'+response.name+'"<label>');
										$('#promo_code_btn').show();
										$('#promo_description').html('Apply to get '+response.discount+'% discount on first billing.');
									}
								}
							});
						}*/
						
						if($.isEmptyObject(current_subscription)){
							$('#currentPlanAlert').hide();
							$('#currentPlanMsg').html('');
						}else{
							var cancel_str = '';
							if(current_subscription.is_cancelled == 'yes'){
								cancel_str = 'Your plan is valid till '+current_subscription.end_date;
							}
							var license_str = '';
							if(current_subscription.extra_license != null){
								number_str = '';
								if(current_subscription.extra_license == 1){
									number_str = 'one';
								}else if(current_subscription.extra_license == 2){
									number_str = 'two';
								}
								license_str = ' with '+number_str+' extra license';
							}
							var str = "<strong>Current Plan: "+current_subscription.name+" ($"+current_subscription.price+"/"+current_subscription.billing_period+")" + license_str + ". "+ cancel_str +"</strong>";
							$('#currentPlanAlert').show();
							$('#currentPlanMsg').html(str);
						}
						if(!$.isEmptyObject(current_subscription) && current_subscription.is_cancelled == 'yes') {

							$("#error-text").html('You cancelled subscription plan for this store. ' + cancel_str);
							$("#error-row").show();
							$("#btn-row").hide();
						} else {

							if($.isEmptyObject(pending_subscription)){

								$('.btnSbscrtnFrm').each(function(){
									var membership_code = $(this).val();
									if($.isEmptyObject(current_subscription)){
										$(this).text('Choose Plan');
										$(this).attr('onclick', 'selectPlan("'+membership_code+'")');
									}else{
										$(this).text('Switch Plan');
										// var current_plan_price = 155.53;
										// var current_plan_license = 2;
										// var current_membership_code = 'sprout';
										var current_plan_price = current_subscription.price;
										var current_plan_license = current_subscription.extra_license;
										var current_membership_code = current_subscription.membership_code; 
										var extra_license = $('#extra_license').val();
										var plan_price = $('#membership_actual_price_'+membership_code).val();
										// console.log('current_subscription_membership_code: '+current_membership_code);
										// console.log('membership_code: '+membership_code);
										// console.log('current_plan_license: '+current_plan_license);
										// console.log('extra_license: '+extra_license);
										if(current_plan_price > plan_price) {
											// console.log('if');
											$(this).attr('onclick', 'alert("You can cancel your plan but can\'t downgrade.")');	
										} else if(current_membership_code == 'blossom' && membership_code == 'sprout') {
											$(this).attr('onclick', 'alert("You can cancel your plan but can\'t downgrade.")');	
										} else if(current_plan_license > extra_license) {
											$(this).attr('onclick', 'alert("You can cancel your plan but can\'t downgrade.")');	
										} else {
											// console.log('else');
											$(this).attr('onclick', 'changePlan("'+membership_code+'")');
											var item_id = $('#item_id_'+current_subscription.membership_code).val();
											if(item_id == current_subscription.membership_item_id){
												$('#sub_btn_'+current_subscription.membership_code).text('Your Plan');
												$('#sub_btn_'+current_subscription.membership_code).attr('onclick', '');
											}
										}
									}
								});
							}else{

								$("#error-text").html('This store subscription plan is in progress.');
								$("#error-row").show();
								$("#btn-row").hide();
							}
						}
					} else {

						$('#subscriptionBtn').html('Pay $399 for One Time Setup Fee');
						$('#cardModal').modal('show');
					}
				}
			});
		}
	}

	function changePlan(code)
	{
		activeFrmID = code+'_form';
		var r = confirm("Are you sure to switch the plan?");
		if (r == true) {
			var store = $("#store").val();
			$("#"+activeFrmID).append("<input type='hidden' name='store_id' value='" + store + "' />");
			var extra_license = $('#extra_license').val();
			if(extra_license != '') {
				$("#"+activeFrmID).append("<input type='hidden' name='extra_license' value='" + extra_license + "' />");
			}
			var card_id = $("input[name='card']:checked").val();
			/*if (coupon_id != '') {
				var membership_coupon_id = $('#membership_coupon_id').val();
				$("#"+activeFrmID).append("<input type='hidden' name='membership_coupon_id' value='" + membership_coupon_id + "' />");
			}
			$("#"+activeFrmID).append("<input type='hidden' name='stripe_coupon_id' value='" + coupon_id + "' />");*/
			// $("#"+activeFrmID).append("<input type='hidden' name='stripe_card_id' value='" + card_id + "' />");
			$("#error-row").hide();
			$("#error-text").html('');
			$("#btn-row").hide();
			$("#processing-row").show();
			$.ajax({
				type: "POST",
				url: "{{route('vendor.change-subscription')}}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: $("#"+activeFrmID).serialize(),
				dataType: "json",
				success: function(result){
					if(result.status == 'error'){
						$("#btn-row").show();
						$("#processing-row").hide();
						$("#error-text").html(result.message);	
						$("#error-row").show();			
					}else{
						$("#thnksMsg").html(result.message);
						$("#thnksModal").modal("show");
					}
				}
			});
		}
	}

	function addCouponDiscount() 
	{
		if(calculate_discount == false && coupon_id != '') {

			$('.membership_price').each(function() {
				var m_price = parseFloat($(this).text());
				var c_discount = parseFloat($('#promo_code_discount').val());
				var sale_price = (m_price - ( m_price * c_discount / 100 )).toFixed(2);
				$(this).text(sale_price);

			});
			calculate_discount = true;
		}
	}

	function removeCouponDiscount() 
	{
		if(calculate_discount == true && coupon_id == '') {

			$('.membership_price').each(function() {
				var this_id = $(this).attr('id');
				var actual_price = $('#membership_actual_'+this_id).val();
				$(this).text(actual_price);
			});
			calculate_discount = false;
		}
	}
</script>

@endsection