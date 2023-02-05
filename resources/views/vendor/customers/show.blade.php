@extends('vendor.layout.main')

@section('content')
<section>
	<div class="card listing">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-4">
					<div class="box box-info">
						<div class="box-body">
							<fieldset>
								<legend>Customer Info
									
								</legend>
								<div class="col-sm-12"> 
									<div class="person-info" align="center"> 

										@if($user->image)
											<img src="{{asset('public/user_photo/'.$user->image)}}" height="100" width="100">
										@else
											<img src="{{asset('public/images/no-image.jpg')}}" height="100" width="100">
										@endif
											<br />
											<b>{{$user->first_name}} {{$user->last_name}}</b><br />
											@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
											{{$user->mobile}}<br />{{$user->email}} </br></br>
											@endif
											<p> Customer Since @php echo date("Y", strtotime($user->created_at)); @endphp</p>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Address
								</legend>
								<div class="col-sm-12">
									<div class="row">
										@if(!empty($user->address))
											<p>{{$user->address}}, {{$user->country}}, <br /> {{$user->state}}, {{$user->city}} {{$user->pincode}} </p>
										@else
											<p>-</p>
										@endif
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Reward Point
								</legend>
								<div class="col-sm-12">
									<div class="row">
										<label>Earn Reward Point: @if(!empty($user->point)){{$user->point}}@else 0 @endif</label>
										<label>Used Reward Point: @if(!empty($user->used_point)){{$user->used_point}}@else 0 @endif</label>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="box box-info">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
		                        	<fieldset>
			                            <!-- <div class="service-content">
			                                <legend>Orders</legend>
			                            </div>
			                            <div class="feedback-content">
			                                <legend>Feedback</legend>
			                            </div> -->
			                            <div class="service_fieldset">
			                                <legend>Review Products</legend>
			                            </div>
		                            </fieldset>
		                        	<div class="service_fieldset">
										<fieldset>
											<div class="col-sm-12">
			                                	<div class="row">
			                                        @foreach($product_reviews as $product_review)
			                                        	<div class="main-div">
			                                                <div class="service-content details">
			                                                    <div>
				                                                    <b><a href="{{ route('products.edit', $product_review->id) }}">{{$product_review->title}}</a></b>
				                                                    <label>Price: ${{$product_review->price}}</label>
				                                                    <p>Store: {{$product_review->name}} </p>
				                                                </div>
			                                                </div>
			                                                <div class="feedback-content">
			                                                    <div>
				                                                    <p>{{$product_review->comment}}</p>
				                                                    <div class="star">
																	@php for($i=1;$i<=5;$i++) {
																		$selected = "";
																		if(!empty($product_review->rating) && $i<=$product_review->rating) {
																			$selected = "selected";@endphp
																			<i class="fa fa-star selected_rating" style="color:#ffc900;"></i>
																		@php }else{ @endphp
																			<i class="fa fa-star"></i>
																		@php }
																	}  @endphp
																	</div>
				                                                </div>
			                                                </div>
			                                                <div style="clear:both;"></div>
			                                            </div>
			                                        @endforeach
			                                        <div class="main-div">
			                                        	<div class="float-right">{{ $product_reviews->links() }}</div>
			                                        </div>
			                                    </div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection