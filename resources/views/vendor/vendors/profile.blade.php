@extends('vendor.layout.main')
@section('content')
<style type="text/css">
	#cardListContent .font-weight-bold {font-size: 13px !important;}
	.more-toggle::after{display: none;}
	.more-menu.show{transform: translate3d(-140px, 20px, 0px) !important;}
	.card .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{border-bottom: 2px solid #000;}
	.card-badge-default {font-size: 10px; padding: 3px; background: #003366;color: #fff; font-weight: 500; border-radius: 5px;}
	.card-badge-expired {font-size: 10px; padding: 3px; background: #f5365c;color: #fff; font-weight: 500; border-radius: 5px;}
	.card-action {position: absolute; right: 7px; bottom: 4px;}
	.card-action .action-list {border: 2px solid #b5b5b5;border-radius: 5px; padding: 0px 0px 0px 5px;}
	.card-action .action-item {list-style-type: none; display: inline-block;border-right: 2px solid #b5b5b5; padding: 3px 0px 0px 3px;}
	.card-action .action-item-last {list-style-type: none; display: inline-block;padding: 3px 0px 0px 3px;}
	.action-item-last .dropdown-item { padding-bottom: 0px; }
	.action-item-last .dropdown-menu {transform: translate3d(-141px, 20px, 0px) !important;}
	div#editCardModal {
		width: 30%;
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
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
		<h3 class="page-title">User Profile</h3>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="card card-small mb-4 pt-3">
			<div class="card-header border-bottom text-center">
				<div class="mb-3 mx-auto">
					@if($vendor->image)
						@php $image = asset('public/images/vendors/'.$vendor->image); @endphp
						<img class="rounded-circle" src="{{$image}}" alt="User Avatar" width="110">
					@endif
				</div>
				<h4>{{$vendor->name}}</h4>
				{{-- <span class="text-muted d-block mb-2">{{$vendor->role_name}}</span> --}}
			</div>
			{{-- <div class="list-group">
				<a href="javascript:void(0);" class="list-group-item">
					<div class="progress-wrapper">
						<strong class="text-muted d-block mb-2 text-center">
							@if($data['percentage'] == 100)
								Profile Completed
							@else
								Profile Completeness
							@endif
						</strong>
						<div class="progress" style="height: auto;">
							<div class="progress-bar bg-success" style="width: {{$data['percentage']}}%;">
								<span class="progress-value">{{$data['percentage']}}%</span>
							</div>
						</div>
					</div>
				</a>
				@foreach($data['checklist'] as $item)
					@php
					if($item['is_completed'] == 'no'){
						$class = '';
						$status = 'Pending';
						$status_class = 'badge-warning';
					}else{
						$class = 'list-group-item-primary';
						$status = 'Completed';
						$status_class = 'badge-success';
					}
					@endphp
					<a href="{{$item['url']=='' ? 'javascript:void(0)' : $item['url']}}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action {{$class}}">
						{{$item['title']}}
						<span class="badge {{$status_class}}">{{$status}}</span>
					</a>
				@endforeach
			</div> --}}
		</div>
		{{-- @if(Auth::user()->parent_id == '0')
		<div class="card card-small" id="manage-card">
			<div class="card-header">
				<h5 class="m-0">Manage Cards</h5>
				<ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="#cardList" role="tab" aria-controls="cardList" aria-selected="true">Card List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link"  href="#addCard" role="tab" aria-controls="addCard" aria-selected="false">Add Card</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				@php // echo '<pre>'; print_r($cards); echo '</pre>'; @endphp
				<div id="error" class="text-danger"></div>
				<div id="success" class="text-success"></div>
				<div class="tab-content">
            		<div class="tab-pane active" id="cardList" role="tabpanel"></div>
					<div class="tab-pane" id="addCard" role="tabpanel" aria-labelledby="addCard-tab">
						<form method="post" id="addCardForm">
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

										</select>
										<select name="year" id="year" class="form-control" required>
											<option value=""> --Select--</option>

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
		@endif --}}
	</div>
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header">
				<h5 class="m-0">Edit Profile</h5>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ url('vendor/profile') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="name" class="col-sm-3 col-form-label">@if(Auth::user()->parent_id == 0) Administrator @else Name @endif<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{old('name',$vendor->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{old('email',$vendor->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					@if(Auth::user()->parent_id == 0)
						<div class="form-group row">
	                        <label for="input-12" class="col-sm-3 col-form-label">Business Name<span class="text-danger">*</span></label>
	                        <div class="col-sm-9">
	                            <input type="text" name="business_name" class="form-control" value="{{old('business_name',$vendor->business_name)}}" placeholder="Enter Business Name">
	                            @if ($errors->has('business_name'))
	                            <span class="text-danger">{{ $errors->first('business_name') }}</span>
	                            @endif
	                        </div>
	                    </div>
						<div class="form-group row">
	                        <label for="input-12" class="col-sm-3 col-form-label">Tax ID (EIN)<span class="text-danger">*</span></label>
	                        <div class="col-sm-9">
	                            <input type="text" name="tax_id" class="form-control" value="{{old('tax_id',$vendor->tax_id)}}" placeholder="Enter Tax ID">
	                            @if ($errors->has('tax_id'))
	                                <span class="text-danger">{{ $errors->first('tax_id') }}</span>
	                            @endif
	                        </div>
	                    </div>
	                    <div class="form-group row">
							<label for="input-13" class="col-sm-3 col-form-label">Bank Name<span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="bank_name" class="form-control" value="{{old('bank_name',$vendor->bank_name)}}">
								@if ($errors->has('bank_name'))
									<span class="text-danger">{{ $errors->first('bank_name') }}</span>
								@endif
							</div>
						</div>
		                <div class="form-group row">
							<label for="input-13" class="col-sm-3 col-form-label">Bank Account Number<span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="bank_account_number" class="form-control" value="{{old('bank_account_number',$vendor->bank_account_number)}}">
								@if ($errors->has('bank_account_number'))
									<span class="text-danger">{{ $errors->first('bank_account_number') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-12" class="col-sm-3 col-form-label">Bank Routing Number<span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="bank_routing_number" class="form-control" value="{{old('bank_routing_number',$vendor->bank_routing_number)}}">
								@if ($errors->has('bank_routing_number'))
									<span class="text-danger">{{ $errors->first('bank_routing_number') }}</span>
								@endif
							</div>
						</div>
					@endif
					<div class="form-group row">
						<label for="input-13" class="col-sm-3 col-form-label">Mobile Number<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number',$vendor->mobile_number)}}">
							@if ($errors->has('mobile_number'))
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">Phone Number</label>
						<div class="col-sm-9">
							<input type="text" name="phone_number" class="form-control" value="{{old('phone_number',$vendor->phone_number)}}">
							@if ($errors->has('phone_number'))
								<span class="text-danger">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<textarea class="form-control" id="input-8" name="address">{{old('address',$vendor->address)}}
							</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-3 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
									<option value="{{$country->id}}"{{ (old("country", $vendor->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('country'))
								<span class="text-danger">{{ $errors->first('country') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">State<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<select class="form-control" id="state" name="state" value="{{old('state')}}">
								<option value="">Select State</option>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-3 col-form-label">City<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<select class="form-control" id="city" name="city" value="{{old('city')}}">
								<option value="">Select City</option>
							</select>
							@if ($errors->has('city'))
								<span class="text-danger">{{ $errors->first('city') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">Zip Code<span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="pincode" class="form-control" value="{{old('pincode',$vendor->pincode)}}">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">Website link</label>
						<div class="col-sm-9">
							<input type="text" name="website_link" class="form-control" value="{{old('website_link',$vendor->website_link)}}">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-3 col-form-label">Image</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="input-8" name="image" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
							@php /* @endphp
							@if($vendor->image)
								@php $image = asset('public/images/vendors/'.$vendor->image); @endphp
								<br>
								<img class="img-responsive" id="imagePreview" src="{{$image}}" height="100" width="100">
							@endif
							@php */ @endphp
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/home')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row-->

<!-- thank you modal -->
<div class="modal fade" id="editCardModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Card</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="edit_error" class="text-danger"></div>
				<form method="post" id="editCardForm">
					<input type="hidden" name="card_id" id="card_id">
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label>Expiry Month / Year<span class="text-danger">*</span></label>
							<div class="input-group">
								<select name="month" id="edit_exp_month" class="form-control" required>
									<option value=""> --Select--</option>
									<?php for ($i=1; $i<=12; $i++) {
										$month = str_pad($i, 2, "0", STR_PAD_LEFT);?>
										<option value="<?php echo $month; ?>"><?php echo $month ?></option>
									<?php } ?>
								</select>
								<select name="year" id="edit_exp_year" class="form-control" required>
									<option value=""> --Select--</option>
									<?php $start_year = date('Y'); $end_year = date('Y') + 20;
									for ($i=$start_year; $i<=$end_year; $i++) { ?>
										<option value="<?php echo substr($i, 2); ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary px-5" id="editCardBtn" onClick="updateCard(event);">Update Card</button>
						<span id="editProcessing" style="display: none;">Processing...</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

var countryID = "{{old('country', $vendor->country)}}";
var stateID = "{{old('state', $vendor->state)}}";
var cityID = "{{old('city', $vendor->city)}}";

$(function() {

	setTimeout(function(){ getState(); }, 500);
	setTimeout(function(){ getCity(); }, 500);

	$("#country").change(function() {
		countryID = $(this).val();
		getState();
	});

	$("#state").change(function() {
		stateID = $(this).val();
		getCity();
	});

	$('#bologna-list a').on('click', function (e) {
		e.preventDefault()
		$(this).tab('show')
	});

	getCard();
});

function getState(){
	if(countryID != ''){
		$.ajax({
			data: {
			"_token": "{{ csrf_token() }}"
			},
			url: "{{ url('/get-state') }}/"+countryID,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$('#state').empty();
				$.each(data, function(i, val) {
					$("#state").append('<option value=' +val.id + '>' + val.name + '</option>');
				});
				if($("#state option[value='"+stateID+"']").length > 0){
                    $('#state').val(stateID);
                }
			},
			error: function (data) {
			}
		});
	}else{
		 $("#country").val('');
	}
}

function getCity(){
	if(stateID != ''){
		$.ajax({
			data: {
			"_token": "{{ csrf_token() }}"
			},
			url: "{{ url('/get-city') }}/"+stateID,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$('#city').empty();
				$.each(data, function(i, val) {
					$("#city").append('<option value=' +val.id + '>' + val.name + '</option>');
				});
				if($("#city option[value='"+cityID+"']").length > 0){
                    $('#city').val(cityID);
                }
			},
			error: function (data) {
			}
		});
	}else{
		$("#state").val('');

	}
}

//Manage Credit/Debit Card Script Start

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
		$("#error").html("All fields are required");
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
		saveCard(token);
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
				$('#addCardForm')[0].reset();
				getCard();
				activaTab('cardList');
			}
		}
	});
}

function getCard() {

	$.ajax({
		type: "GET",
		url: "{{url('/vendor/get-vendor-card')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		dataType: "json",
		success: function(result){

			$("#cardList").html(result.data.cardlist);
		}
	});
}

function editCard(cid, em, ey) {

	$("#edit_error").html("");
	$('#card_id').val(cid);
	$('#edit_exp_month').val(em);
	$('#edit_exp_year').val(ey);
	$("#editCardModal").modal("show");
}

function updateCard(e) {

	e.preventDefault();
	$('#editCardBtn').hide();
	$('#editProcessing').show();
	$.ajax({
		type: "POST",
		url: "{{url('/vendor/edit-vendor-card/')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: $('#editCardForm').serialize(),
		dataType: "json",
		success: function(result){

			$('#editCardBtn').show();
			$('#editProcessing').hide();
			if(result.status == 'error'){
				$("#edit_error").html(result.message);
			}else{
				$("#edit_error").html("");
				$("#editCardModal").modal("hide");
				getCard();
				activaTab('cardList');
			}
		}
	});
}

function deleteCard(cid) {

	if (confirm("Are you sure!") == true) {

		$.ajax({
			type: "POST",
			url: "{{url('/vendor/delete-vendor-card/')}}/",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {card_id: cid},
			dataType: "json",
			success: function(result){
				if(result.status == 'error'){
					$("#error").html(result.message);
				}else{
					$("#error").html("");
					getCard();
				}
			}
		});
	}
}

function setDefaultCard(cid) {

	$.ajax({
		type: "POST",
		url: "{{url('/vendor/set-vendor-default-card/')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {card_id: cid},
		dataType: "json",
		success: function(result){
			if(result.status == 'error'){
				$("#error").html(result.message);
			}else{
				$("#error").html("");
				getCard();
			}
		}
	});
}

function activaTab(tab){
	$('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
// End
</script>

@endsection

