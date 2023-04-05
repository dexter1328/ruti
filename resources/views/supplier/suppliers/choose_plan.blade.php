@extends('supplier.layout.main')
@section('content')
    <style type="text/css">
        .btn-outline-primary:not(:disabled):not(.disabled).active,
        .btn-outline-primary:not(:disabled):not(.disabled):active,
        .show>.btn-outline-primary.dropdown-toggle {
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
   @elseif(session()->get('error'))
   <div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert">×</button>
       <div class="alert-icon">
           <i class="fa fa-check"></i>
       </div>
       <div class="alert-message">
           <span><strong>Error!</strong> {{ session()->get('error') }}</span>
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
        {{-- <div class="col-md-12">
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
										@foreach ($stores as $store)
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
					@foreach ($features as $key => $feature)
						@if ($i == 1)
							<tr>
								<th class="border-0" style="vertical-align: bottom !important;">
									<p><span class="h4">Features</span></p>
								</th>
								@foreach ($memberships as $membership)
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
								@if ($feature['type'] == 'array')
									{{$feature['label']}}
									<table>
										@foreach ($feature['values'] as $value)
										<tr>
											<td class="border-0" style="padding: 5px 30px;"> - {{$value['label']}}</td>
										</tr>
										@endforeach
									</table>
								@else
									{{$feature['label']}}
								@endif
							</td>
							@foreach ($memberships as $membership)
								<td class="text-center">
									@if ($feature['type'] == 'array')
										<table width="100%" style="margin-top: 20px;">
											@foreach ($feature['values'] as $key2 => $value)
												@php $membership_description_key = (array)$membership->description->$key; @endphp
												@if (array_key_exists($key2, $membership_description_key))
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
										@if (is_string($membership->description->$key))
											{{$membership->description->$key}}
										@endif
									@endif
								</td>
							@endforeach
						</tr>
						@if ($i == count($features))

							<tr>
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
									Admin fee of 25% apply to every purchase transactions remitted.
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
								@foreach ($memberships as $membership)
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
	</div> --}}
        <div class="container">
            <div class="card-deck mb-3 text-center">
				@foreach ($memberships as $membership)
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{$membership->name}}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">${{$membership->monthMembershipItem->price}}<small class="text-muted">/ month</small></h1>
                        <h1 class="card-title pricing-card-title">${{$membership->yearMembershipItem->price}}<small class="text-muted">/ year</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>{{$membership->description}}</li>

                        </ul>
                        <a type="button" href="{{route('supplier.payment-page',$membership->id)}}" class="btn btn-lg btn-block btn-outline-primary">Buy now!</a>
                    </div>
                </div>
				@endforeach
            </div>
        </div>


    @endsection
