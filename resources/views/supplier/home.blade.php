@extends('supplier.layout.main')

@section('content')
<style type="text/css">
	.small-box .icon i {
		font-size: 60px !important;
	}
	.box{
	    border-top: 3px solid #f39c12;
	}
	.date_range{
	    margin:10px 0 0 0; display:inline-block; width:100%;
	}
	.date_range input.btn.btn-primary {
	    width: 100%;
	    padding: 11px 0;
	}
	.range_inputs button.applyBtn.btn.btn-sm.btn-success {
	    background: #3c8dbc;
	}
	.date_range .input-group>.form-control,
	.date_range select{background:#fff;}
	.sales-range{
		display: inline-flex;
	}
</style>

<div class="container-fluid">
	{{-- <div class="col-xs-12">
        <form class="date_range" method="post" action="{{url('/supplier/home')}}">
            @csrf
            <div class="row justify-content-end">
            	<div class="col-xs-12 col-md-3">
            		&nbsp;
            	</div>
                <div class="col-xs-12 col-md-6">
                    <div id="daterange-picker">
                    <div class="input-daterange input-group">
                        <input type="text" class="form-control" name="start" id = "start_date" placeholder="Start Date">
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <input type="text" class="form-control" name="end" id = "end_date" placeholder="End Date">
                    </div>
                </div>
                </div>
                <div class="col-xs-12 col-md-1">
                    <input type="submit" class="btn btn-primary" value="submit" name="submit">
                </div>
            </div>
        </form>
    </div> --}}
    <div class="clearfix"></div>
	<div class="row mt-3">
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-deepblue">
				<div class="card-body">
					<h5 class="text-white mb-0" id="vendor">{{$vendor}}<span class="float-right"><i class="fa fa-shopping-cart"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="vendor_progress"></div>
					</div>
					<a href="{{url('supplier/suppliers')}}"><p class="mb-0 text-white small-font">Total Employees</p></a>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-orange">
				<div class="card-body">
					<h5 class="text-white mb-0" id="store">{{$product_count??0}}<span class="float-right"><i class="fa fa-usd"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="store_progress"></div>
					</div>
					<a href="{{url('supplier/stores')}}"><p class="mb-0 text-white small-font">Total Products</p></a>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-ohhappiness">
				<div class="card-body">
					<h5 class="text-white mb-0" id="order">{{$order}} <span class="float-right"><i class="fa fa-eye"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="order_progress"></div>
					</div>
					<a href="{{url('supplier/orders')}}"><p class="mb-0 text-white small-font">Total Orders</p></a>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-ibiza">
				<div class="card-body">
					<h5 class="text-white mb-0" id="user">{{$user}}<span class="float-right"><i class="fa fa-envira"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="user_progress"></div>
					</div>
					<a href="{{url('supplier/customer')}}"><p class="mb-0 text-white small-font">Total Customer</p></a>
				</div>
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-lg-2">Total Sales</div>
						<div class="col col-lg-10">
							<div class="card-action sales-range">
								<div class="col-lg-12">
									<a href="{{url('supplier/orders')}}"><button class="btn btn-block btn-primary">View All</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
							</div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="myChart" height="253" width="661" class="chartjs-render-monitor" style="display: block; width: 100%; height: 100%;"></canvas>
				</div>
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-lg-2">Total Earning</div>
						<div class="col col-lg-10">
							<div class="card-action sales-range">
								<div class="col-lg-12">
									<a href="{{url('supplier/orders')}}"><button class="btn btn-block btn-primary">View All</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
							</div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="myChart_earning" height="253" width="661" class="chartjs-render-monitor" style="display: block; width: 100%; height: 100%;"></canvas>
				</div>
			</div>
		</div>
	</div><!--End Row-->

    <div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">Customer Review
					<div class="card-action">
						<h3 class="box-title" style="float:right;"><a href="{{url('supplier/product_reviews')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
					</div>
				</div>
				<ul class="list-group list-group-flush">
					@foreach($customer_reviews as $review)
					<li class="list-group-item">
						<div class="media align-items-center">
							@if(!empty($review->image))
								<img src="{{asset('public/user_photo/'.$review->image)}}" alt="user avatar" class="customer-img rounded-circle">
							@else
								<img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded-circle">
							@endif
							<div class="media-body ml-3">
								<h6 class="mb-0">{{$review->product->title}}<small class="ml-4">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</small>
								</h6>
								<p class="mb-0 small-font">{{$review->user_name}} : @if(!empty($review->comment)){{$review->comment}} @else - @endif</p>
							</div>
							<div class="star">
								@php
								  for($i=1;$i<=5;$i++) {
								  $selected = "";
								  if(!empty($review["star"]) && $i<=$review["star"]) {
									$selected = "selected";@endphp
									<i class="fa fa-star selected_rating"></i>
									@php
								  }else{@endphp

								  	 <i class="fa fa-star"></i>
								  	 @php
								  }
								  @endphp
								@php }  @endphp
							</div>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12">
			<div class="card">
				<div class="card-header border-0">Recent Order Tables
					<div class="card-action">
						<h3 class="box-title" style="float:right;"><a href="{{url('supplier/orders')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table align-items-center table-flush">
						<thead>
							<tr>
								<th>Customer</th>
								<th>Order No</th>
								<th>Amount</th>
							<!-- 	<th>Completion</th> -->
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recent_orders as $recent_order)
							<tr>
								<td>{{$recent_order->user->first_name}} {{$recent_order->user->last_name}}</td>
								<td>{{$recent_order->w2bOrder->order_id}}</td>
								<td>{{$recent_order->w2bOrder->total_price}}</td>
								<td> {{date('d F Y',strtotime($recent_order->created_at))}} </td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!--End Row-->
</div>

<!-- modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:53%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Bank Detail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div style="display: none;" id="bank_success" class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<div class="alert-icon">
						<i class="fa fa-check"></i>
					</div>
					<div class="alert-message">
						<span><strong>Success!</strong> Bank Detail has been added.</span>
					</div>
				</div>
				<form id="signupForm" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-12" class="col-sm-4 col-form-label">Bank Name<span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="bank_name" name="bank_name" class="form-control" value="{{old('bank_name')}}" placeholder="Enter Bank Name">
							<span class="text-danger" id="bank_name_error" style="display: none;">Please Enter Bank Name</span>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-4 col-form-label">Bank Account Number<span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="bank_account_no" name="bank_account_no" class="form-control" value="{{old('bank_account_no')}}" placeholder="Enter Bank Account Number">
							<span class="text-danger" id="account_error" style="display: none;">Please Enter Bank Account Number</span>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-4 col-form-label">Bank Routing Number<span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="bank_routing_no" name="bank_routing_no" class="form-control" value="{{old('bank_routing_no')}}" placeholder="Enter Bank Routing Number">
							<span class="text-danger" id="routing_error" style="display: none;">Please Enter Bank Routing Number</span>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-4 col-form-label"></label>
						<div class="col-sm-8">
							<button type="button" id="btn_save" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
						</div>
					</div>
					<div class="form-group row text-center">
						<label class="col-sm-12 col-form-label">Note: For daily transaction remittance, enter your bank account information</label>
					</div>
				</form>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<!-- modal -->

<!-- START USER GUIDE MODAL -->
<div id="user_guide" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:70%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Virtual Guide</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="carouselExampleSlidesOnly" class="carousel slide" data-interval="false">
					<div class="carousel-inner">
						<div class="carousel-item active">
							@if(Auth::user()->parent_id != 0)
								Welcome {{Auth::user()->name}} to {{Auth::user()->getAssignStoreName(Auth::user()->id)}} Dashboard. I will be your virtual guide to ensure you are setup correctly. Follow my prompts…
							@else
								Welcome {{Auth::user()->name}} to your Dashboard. I will be your virtual guide to ensure you are setup correctly. Follow my prompts…
							@endif
							<br><br>
							Click <a href="{{url('supplier/profile')}}">here</a> to complete your Profile.
						</div>
						@if(Auth::user()->parent_id == 0)
							<div class="carousel-item">
								Congrats! It’s now time to make initial upfront fee of $399 and choose a plan. For an incentive, get 70% off if initial payment is made today. 50% off when you pay in a week from today. 30% off when you make initial payment two weeks from today. One more incentive - You also get 30 days of free use of the service from date of registration.
								<br><br>
								Click <a href="{{url('supplier/choose-plan')}}">Choose Plan</a>
								<br><br>
								Another incentive-15% off when you pay for annual service.
							</div>
							<div class="carousel-item">
								We need to remit funds to your business bank account on the same day. If you haven’t already done so, click <a href="{{url('supplier/profile')}}">bank info</a> to complete your bank name, routing and account.
							</div>
							<div class="carousel-item">
								Great job! Now let’s add your business details, business hours and locations.
								<br><br>
								Click <a href="{{url('supplier/stores')}}">Locations</a> to Add or Import(for multiple stores) all your locations. Please use the download sample CSV for the import format. You can also view the details to ensure you have the store name, store manager and store manager’s email contact correctly entered.
								<br><br>
								Click on <a href="{{url('supplier/suppliers')}}">Supplier details</a> to complete form. You can also import multiple suppliers if you have subsidiaries.
							</div>
							<div class="carousel-item">
								Now, we will send out email with link to your store/location managers to complete the process. Thank you for your part. For any questions or concerns, please contact our sales team<!-- or click on support and submit inquiry-->.
							</div>
						@elseif(Auth::user()->parent_id != 0 && Auth::user()->vendorRole()->exists())

							@if(Auth::user()->vendorRole->slug == 'store-manager')
								<div class="carousel-item">
									This step is for you, the store manager. Your administrator {{Auth::user()->getParentName(Auth::user()->parent_id)}} added your name to complete the setup process for your store. Let’s get started.
									<br><br>
									1. Click <a href="{{url('supplier/stores')}}">store hours</a> to include business schedule.
									<br><br>
									2. Click <a href="{{url('supplier/supplier_roles')}}">role/permission</a> to add staff and assign specific roles. Assign permission for website and mobile app accessibility.
									<br><br>
									3. Before we proceed, complete your <a href="{{url('supplier/profile')}}">profile</a> as a manager, and start the process for your employees who will use the app. We need one for a supervisor, security person, and floor clerk.
									<br><br>
									4. Now let’s setup your <a href="{{url('supplier/push_notifications')}}">notifications</a>.
								</div>
								<div class="carousel-item">
									Patience wins the crown. We are almost there. Wait, add more things to optimize your business
									<br><br>
									Click <a href="{{url('supplier/categories')}}">category</a> to specify which area you would classify your product.
									<br><br>
									Click <a href="{{url('supplier/attributes')}}">attribute</a> to specify what you want customers to know about your business.
									<br><br>
									Click <a href="{{url('supplier/brand')}}">brand</a> to add information that will increase customer awareness of your brand/business.
									<br><br>
									Click to <a href="{{url('supplier/supplier_coupons')}}">add coupons</a>. Coupons you post monthly to customers depends on the plan you choose. You can skip this point and add on later.
								</div>
								<div class="carousel-item">
									Click on <a href="{{url('supplier/products')}}">ADD inventory</a> at this point. Download sample CSV for the import format. Also click <a href="{{url('supplier/settings')}}">HERE</a> to set up inventory update reminder.
								</div>
								<div class="carousel-item">
									Scan QR code to install your vendor app. Make sure permissions are set up for employees who need to have access. This will let you see daily transactions without logging into your dashboard during business hours. Users need to install app onto their phone and test the functionality process. Scan and install now.
									<br><br>
									Android<br>
									<img src="{{asset('public/images/business_android_qrcode.png')}}">
									<br>
									iOS<br>
									<img src="{{asset('public/images/business_ios_qrcode.png')}}">
								</div>
								<div class="carousel-item">
									Thank you. It’s been a pleasure serving you in this setup process. <!-- For any questions and concerns, click on <a href="javascript:void(0);">support</a> to send us a message.  -->You can also give us a call for faster service.
									<br><br>
									Look forward to more features in the near future to increase convenience, security and increase your brand/business awareness.
									<br><br>
									Please click <a href="javascript:void(0);">here</a> to rate my service.
								</div>
							@endif
						@endif
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="user_guide_bk_btn" type="button" class="btn btn-default" disabled>Back</button>
				<button id="user_guide_nt_btn" type="button" class="btn btn-primary">Next</button>
			</div>
		</div>
	</div>
</div>
<!-- END USER GUIDE MODAL -->

<script>
	function changeUserGuide()
	{
		$.ajax({
			type: "post",
			url: "{{ url('/supplier/complete-user-guide/'.Auth::user()->id) }}",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {status: 1},
			dataType: 'json',
			success: function (data) {
				$("#user_guide").modal('hide');
			}
		});
	}

	$( document ).ready(function() {

		// Start User Guide Modal Script
		var is_user_guide_completed = "{{Auth::user()->is_user_guide_completed}}";
		if(is_user_guide_completed == 0) {

			$("#user_guide").modal({
			backdrop: 'static',
			keyboard: false
			});
		}

		$('#user_guide_bk_btn').click(function (){
			var total_slide = $('.carousel-item').length;
			var currentIndex = $('.carousel-item.active').index() + 1;
			if(currentIndex >= 2) {
				if(currentIndex == 2) {
					$(this).prop('disabled', true);
				} else if(currentIndex == total_slide) {
					$('#user_guide_nt_btn').removeClass('btn-success');
					$('#user_guide_nt_btn').addClass('btn-primary');
					$('#user_guide_nt_btn').text('Next');
				}

				$('#carouselExampleSlidesOnly').carousel('prev');
			}
		});

		$('#user_guide_nt_btn').click(function (){
			var total_slide = $('.carousel-item').length;
			var currentIndex = $('.carousel-item.active').index() + 1;
			if(currentIndex <= total_slide-1) {
				if(currentIndex == 1) {
					$('#user_guide_bk_btn').prop('disabled', false);
				} else if(currentIndex == total_slide-1) {
					$(this).removeClass('btn-primary');
					$(this).addClass('btn-success');
					$(this).text('Finish');
				}
				$('#carouselExampleSlidesOnly').carousel('next');
			} else {
				// $("#user_guide").modal('hide');
				changeUserGuide();
			}
		});
		// End User Guide Modal Script

		var bankAccountNo = "{{ Auth::user()->bank_account_number }}";
		var bankRoutingNo = "{{ Auth::user()->bank_routing_number }}";
		var parent_id =  "{{Auth::user()->parent_id}}";
		if(parent_id == 0){
			if((bankAccountNo == '' || bankRoutingNo == '') && is_user_guide_completed == 1){
				$("#myModal").modal('show');
			}
		}
	});

	$("#btn_save").click(function(){
		if($("#bank_routing_no").val() == ''){
			$("#routing_error").show();
		}
		if($("#bank_account_no").val() == ''){
			$("#account_error").show();
		}
		if($("#bank_name").val() == ''){
			$("#bank_name_error").show();
		}
		if($("#bank_routing_no").val() != '' && $("#bank_account_no").val() != '' && $("#bank_name").val() != ''){
			$.ajax({
			    type: "post",
			    url: "{{ url('/supplier/suppliers/add_bank_detail') }}",
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    data:$( "#signupForm" ).serialize(),
			    dataType: 'json',
			    success: function (data) {
			    	$("#bank_success").show();
			    	$("#bank_name").val('');
			    	$("#bank_routing_no").val('');
			    	$("#bank_account_no").val('');
			    	$("#routing_error").hide();
			    	$("#account_error").hide();
			    	$("#bank_name_error").hide();
			    	setTimeout(function() {
                            window.location.reload();
                        }, 1000);
			    }
			});
		}
	});

	var store_id = "{{(isset($input['store']) ? $input['store']: '')}}";

	$(function() {
	    $(".knob").knob();
	});

	$( document ).ready(function() {
		$('.categories').multiselect({
			nonSelectedText: 'Select Categories',
			buttonWidth: '100%',
			maxHeight: 500,
		});

		//sales graph
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		    	type: 'line',
		        labels: @php echo json_encode($total_sales_graph_label); @endphp,
		        datasets: [{
		            label: 'Total Sales',
		            data: @php echo json_encode($total_sales_graph_data); @endphp,
		            backgroundColor:
		                "#14abef",

		            borderColor:
		                "transparent",
		        }]
		    },
		    options: {
		    	scales: {
					yAxes: [{
						ticks: {
							min: 0,
							interval:1
						}
					}]
		 		}
		    }
		});

		// earning graph
		var ctx = document.getElementById('myChart_earning').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		    	type: 'line',
		        labels: @php echo json_encode($total_earning_graph_label); @endphp,
		        datasets: [{
		            label: 'Total Earning in Dollar($)',
		            data: @php echo json_encode($total_earning_graph_data); @endphp,
		            backgroundColor:
		                "#14abef",

		            borderColor:
		                "transparent",
		        }]
		    },
		    options: {
		    	scales: {
					yAxes: [{
						ticks: {
							min: 0,
							interval:1
						}
					}]
		 		}
		    }
		});

		$('#start_date').datepicker('setDate', '{{date("m/d/Y", strtotime($start_date))}}');
		$('#end_date').datepicker('setDate', '{{date("m/d/Y", strtotime($end_date))}}');

	});

	$("#submit").click(function(){

	    $.ajax({
		    type: "post",
		    url: "{{ url('/admin/get-selling-chart') }}",
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    data:{"categories":$('.categories').val(),"product":$('.product').val()},
		    dataType: 'json',
		    success: function (data) {

				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
				    type: 'line',
				    data: {
				    	type: 'line',
				        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun','July','Aug','Sep','Oct','Nov','Desc'],
				        datasets: [{
				            label: 'Total Sales',
				            data: data,
				            backgroundColor:
				                "#14abef",

				            borderColor:
				                "transparent",
				        }]
				    },
				    options: {
				    	scales: {
							yAxes: [{
								ticks: {
									min: 0,
									interval:1
								}
							}]
				 		}
				    }
				});


		    },
		    error: function (data) {
		    }
		});
	});

	$("#earning_submit").click(function(){

	    $.ajax({
		    type: "post",
		    url: "{{ url('/admin/get-earning-chart') }}",
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    data:{"categories":$('.categories').val(),"product":$('.product').val()},
		    dataType: 'json',
		    success: function (data) {

				var ctx = document.getElementById('myChart_earning').getContext('2d');
				var myChart = new Chart(ctx, {
				    type: 'line',
				    data: {
				    	type: 'line',
				        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun','July','Aug','Sep','Oct','Nov','Desc'],
				        datasets: [{
				            label: 'Total Earning',
				            data: data,
				            backgroundColor:
				                "#14abef",

				            borderColor:
				                "transparent",
				        }]
				    },
				    options: {
				    	scales: {
							yAxes: [{
								ticks: {
									min: 0,
									interval:1
								}
							}]
				 		}
				    }
				});
		    },
		    error: function (data) {
		    }
		});
	});
</script>
@endsection
