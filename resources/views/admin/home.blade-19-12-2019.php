@extends('admin.layout.main')

@section('content')
<style type="text/css">
    .small-box .icon i {
font-size: 60px !important;
}

.date_range{
    width: auto;
    float: right;
    margin:10px 0 0 0;
}
.box{
    border-top: 3px solid #f39c12;
}
.date_range {
    display: inline-flex;
    clear: both;
    float: right;
}
.date_range input.btn.btn-primary {
    border-radius: 0;
}
.range_inputs button.applyBtn.btn.btn-sm.btn-success {
    background: #3c8dbc;
}
.sales-range{
	width: 589px;
	clear: both;
	display: inline-flex;
	margin-right: 34px;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script src="{{ asset('public/js/index.js') }}"></script>
<div class="container-fluid">
	<div class="col-xs-12">
        <form class="date_range" method="post" action="{{url('/admin/home')}}">
            @csrf
			<div id="dateragne-picker">
				<div class="input-daterange input-group">
					<input type="text" class="form-control" name="start">
					<div class="input-group-prepend">
						<span class="input-group-text">to</span>
					</div>
					<input type="text" class="form-control" name="end">
				</div>
			</div>
            <select class="form-control" name="vendor">
            	<option>Select Vendor</option>
            	@foreach($vendor_datas as $vendor_data)
            		<option value="{{$vendor_data->id}}">{{$vendor_data->name}}</option>
            	@endforeach
            </select>
            <input type="submit" class="btn btn-primary" value="submit" name="submit">
        </form>
    </div>
    <div class="clearfix"></div>
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
					<form class="sales-range" method="post" action="{{url('/admin/home')}}">
            			@csrf
			            <select class="form-control" name="categories[]" id="categories" multiple="multiple">
			            	
			            </select>
			            <select class="form-control" name="product">
			            	<option>Select Product</option>
							@foreach($product_title as $product)
								<option value="{{$product['id']}}">{{$product['title']}}</option>
							@endforeach
			            </select>
            			<input type="submit" class="btn btn-primary" value="submit" name="submit">
        			</form>
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
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
				<div class="card-header">Total Earning
					<div class="card-action">
					<h3 class="box-title" style="float:right;"><a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
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
				<div class="card-header">Stores Selling
					<div class="card-action">
						<h3 class="box-title" style="float:right;"><a href="{{url('admin/vendor_store')}}"><button class="btn btn-block btn-primary">View All</button></a></h3>
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

		$('#categories').multiselect({
			nonSelectedText: 'Select Categories',
			buttonWidth: '100%',
			maxHeight: 500,
		});

		var response = '<?php echo json_encode($selling_array);?>';
		console.log(response);
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

		var earning_response = '<?php echo json_encode($earning_array);?>';
		var ctx = document.getElementById('myChart_earning').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		    	type: 'line',
		        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun','July','Aug','Sep','Oct','Nov','Desc'],
		        datasets: [{
		            label: 'Total Earning',
		            data: $.parseJSON(earning_response),
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

		var category = <?php echo json_encode($result);?>;
		$("#categories").append(category);
		$('#categories').multiselect('rebuild');

		$('#dateragne-picker .input-daterange').datepicker({
       });
	});
</script>     
@endsection
