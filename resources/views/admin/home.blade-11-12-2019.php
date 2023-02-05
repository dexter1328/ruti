@extends('admin.layout.main')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script src="{{ asset('public/js/index.js') }}"></script>
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-deepblue">
				<div class="card-body">
					<h5 class="text-white mb-0" id="vendor">{{$vendor}}<span class="float-right"><i class="fa fa-shopping-cart"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="vendor_progress"></div>
					</div>
					<p class="mb-0 text-white small-font">Total Vendors</p>
				</div>
			</div> 
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card gradient-orange">
				<div class="card-body">
					<h5 class="text-white mb-0" id="store">{{$store}}<span class="float-right"><i class="fa fa-usd"></i></span></h5>
					<div class="progress my-3" style="height:3px;">
						<div class="progress-bar" id="store_progress"></div>
					</div>
					<p class="mb-0 text-white small-font">Total Stores</p>
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
					<p class="mb-0 text-white small-font">Total Orders</p>
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
					<p class="mb-0 text-white small-font">Total Users</p>
				</div>
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">Total Sales
					<div class="card-action">
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
						<!-- <button type="button" class="btn btn-success"><a class="dropdown-item" href="{{url('admin/orders')}}">View All</a></button> -->

						<!-- <div class="dropdown">
							<a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
								<i class="icon-options"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="{{url('admin/orders')}}">Action</a>
								<a class="dropdown-item" href="javascript:void();">Another action</a>
								<a class="dropdown-item" href="javascript:void();">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void();">Separated link</a>
							</div>
						</div> -->
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
				<!-- <div class="row m-0 row-group text-center border-top border-light-3">
					<div class="col-12 col-lg-4">
						<div class="p-3">
							<h5 class="mb-0">45.87M</h5>
							<small class="mb-0">Overall Visitor <span> <i class="fa fa-arrow-up"></i> 2.43%</span></small>
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="p-3">
							<h5 class="mb-0">15:48</h5>
							<small class="mb-0">Visitor Duration <span> <i class="fa fa-arrow-up"></i> 12.65%</span></small>
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="p-3">
							<h5 class="mb-0">245.65</h5>
							<small class="mb-0">Pages/Visit <span> <i class="fa fa-arrow-up"></i> 5.62%</span></small>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">Stores Selling
					<div class="card-action">
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/vendor_store')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
						<!-- <div class="dropdown">
							<a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
								<i class="icon-options"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="{{url('admin/vendor_store')}}">View All</a>
								<a class="dropdown-item" href="javascript:void();">Another action</a>
								<a class="dropdown-item" href="javascript:void();">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void();">Separated link</a>
							</div>
						</div> -->
					</div>
				</div>
				<div class="card-body">
            		<div id="dashboard-map" style="height: 270px;">
            				<div class="jvectormap-zoomin">+</div>
            				<div class="jvectormap-zoomout">−</div>
            				<div class="jvectormap-legend-cnt jvectormap-legend-cnt-h">
            				</div>
            				<div class="jvectormap-legend-cnt jvectormap-legend-cnt-v">
            				</div>
            		</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped align-items-center">
						<thead>
							<tr>
								<th>Store</th>
								<th>Income</th>
							</tr>
						</thead>
						<tbody>
							@foreach($store_selling as $value)
							@php 
								$data = DB::table("vendor_stores")->where('id',$value->store_id)->get();
							@endphp
							@foreach($data as $key)
							<tr>
								<td> 
									<img src="{{asset('public/images/stores').'/'.$key->image}}" width="50" height="50">
									{{$key->name}}</td>
								<td>{{$value->count}}</td>
							</tr>
							@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!--End Row-->
	<div class="row">
		<div class="col-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-header">Customer Review
					<div class="card-action">
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/product_reviews')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
						<!-- <div class="dropdown">
							<a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
								<i class="icon-options"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="{{url('admin/product_reviews')}}">View All</a>
								<a class="dropdown-item" href="javascript:void();">Another action</a>
								<a class="dropdown-item" href="javascript:void();">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void();">Separated link</a>
							</div>
						</div> -->
					</div>
				</div>
				<ul class="list-group list-group-flush">
					@foreach($product_review as $review)
					<li class="list-group-item">
						<div class="media align-items-center">
							<img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded-circle">
							<div class="media-body ml-3">
								<h6 class="mb-0">{{$review->product}}<small class="ml-4"><?php echo date('H:i:s',strtotime($review->created_at));?></small>
								</h6>
								<p class="mb-0 small-font">{{$review->username}} : {{$review->comment}}</p>
							</div>
							<div class="star">
								<?php
								  for($i=1;$i<=5;$i++) {
								  $selected = "";
								  if(!empty($review["rating"]) && $i<=$review["rating"]) {
									$selected = "selected";?>
									<i class="fa fa-star selected_rating"></i>
									<?php
								  }else{?>

								  	 <i class="fa fa-star"></i>
								  	 <?php
								  }
								  ?>
								<?php }  ?>
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
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
						<!-- <div class="dropdown">
							<a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
								<i class="icon-options"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="{{url('admin/orders')}}">Action</a>
								<a class="dropdown-item" href="javascript:void();">Another action</a>
								<a class="dropdown-item" href="javascript:void();">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void();">Separated link</a>
							</div>
						</div> -->
					</div>
				</div>
				<div class="table-responsive">
					<table class="table align-items-center table-flush">
						<thead>
							<tr>
								<th>Store</th>
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
								<td>{{$recent_order->name}}</td>
								<td>{{$recent_order->first_name}} {{$recent_order->last_name}}</td>
								<td>{{$recent_order->order_no}}</td>
								<td>${{$recent_order->total_price}}</td>
								<td>@php 
									echo date('d F Y',strtotime($recent_order->created_at)) @endphp</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!--End Row-->
</div>
<script>
	$(function() {
	    $(".knob").knob();
	});
	$( document ).ready(function() {
		$.ajax({
	      	type:"GET",
	      	url:"{{url('admin/totalSelling')}}",
	      	success: function (response) {
	      		console.log(response);
      			
	      	},
			error: function (error) {
			}
		});

		var response = '<?php echo json_encode($selling_array);?>';
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		    	type: 'line',
		        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun','July','Aug','Sep','Oct','Nov','Desc'],
		        datasets: [{
		            label: 'Total Sales',
		            data: $.parseJSON(response),
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

		var store_response = '<?php echo json_encode($store_data);?>';
		jQuery('#dashboard-map').vectorMap(
		{
		    map: 'us_aea_en',
		    backgroundColor: 'transparent',
		    borderColor: '#818181',
		    borderOpacity: 0.25,
		    borderWidth: 1,
		    zoomOnScroll: true,
		    color: '#009efb',
		    regionStyle : {
		        initial : {
		          fill : '#14abef'
		        }
		      },
		    markerStyle: {
		      initial: {
		        r: 5,
		        'fill': '#fff',
		        'fill-opacity':1,
		        'stroke': '#000',
		        'stroke-width' : 5,
		        'stroke-opacity': 0.4
		                },
		                },
		    enableZoom: true,
		    hoverColor: '#009efb',
		    markers : $.parseJSON(store_response),
		    hoverOpacity: null,
		    normalizeFunction: 'linear',
		    scaleColors: ['#b6d6ff', '#005ace'],
		    selectedColor: '#c9dfaf',
		    selectedRegions: [],
		    showTooltip: true,
		}); 		

		$.ajax({
	      	type:"GET",
	      	url:"{{url('admin/totalstore')}}",
	      	success: function (response) {
	      	
	   			
	      	},
			error: function (error) {
			}
		});

		
	});
</script>     
@endsection
