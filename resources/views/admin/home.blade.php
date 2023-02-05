@extends('admin.layout.main')

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
	<div class="col-xs-12">
        <form class="date_range" method="post" action="{{url('/admin/home')}}">
            @csrf
            <div class="row">
            	<div class="col-xs-12 col-md-3">&nbsp;</div>
                <div class="col-xs-12 col-md-4">
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
                <div class="col-xs-12 col-md-2">
                    <select class="form-control" name="vendor" id="vendor">
                    <option value="">Select Vendor</option>
                    @foreach($vendor_datas as $vendor_data)
                        <option value="{{$vendor_data->id}}">{{$vendor_data->name}}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-xs-12 col-md-2">
                    <select class="form-control" name="store" id="store">
                    	<option value="">Select Store</option>
                	</select>
                </div>
                <div class="col-xs-12 col-md-1">
                    <input type="submit" class="btn btn-primary" value="submit" name="submit">
                </div>    
            </div>
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
					<a href="{{url('admin/vendor')}}"><p class="mb-0 text-white small-font">Total Vendors</p></a>
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
					<a href="{{url('admin/vendor_store')}}"><p class="mb-0 text-white small-font">Total Stores</p></a>
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
					<a href="{{url('admin/orders')}}"><p class="mb-0 text-white small-font">Total Orders</p></a>
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
					<a href="{{url('admin/customer')}}"><p class="mb-0 text-white small-font">Total Users</p></a>
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
							<!-- 	<div class="col-lg-4">
									<select class="form-control categories" name="categories[]" id="categories" multiple="multiple">
			            			</select>
								</div>
								<div class="col-lg-4">
									<select class="form-control product" name="product" id = "product">
										<option value="">Select Product</option>
											@foreach($product_title as $product)
										<option value="{{$product['id']}}">{{$product['title']}}</option>
											@endforeach
									</select>
								</div>
								<div class="col-lg-2">
									<button class="btn btn-block btn-primary" name="submit" id="submit">Submit</button></a>
								</div> -->
								<div class="col-lg-12">
									<a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a>
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
								<!-- <div class="col-lg-4">
									<select class="form-control categories" name="categories[]" id="categories" multiple="multiple">
			           				</select>
								</div>
								<div class="col-lg-4">
									<select class="form-control product" name="product" id = "product">
										<option value="">Select Product</option>
											@foreach($product_title as $product)
										<option value="{{$product['id']}}">{{$product['title']}}</option>
											@endforeach
									</select>
								</div>
								<div class="col-lg-2">
									<button class="btn btn-block btn-primary" name="submit" id="earning_submit">Submit</button>
								</div> -->
								<div class="col-lg-12">
									<a href="{{url('admin/orders')}}"><button class="btn btn-block btn-primary">View All</button></a>
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
								<th>Vendor</th>
								<th>Income</th>
							</tr>
						</thead>
						<tbody>
							@foreach($store_earn as $value)
							<tr>
								<td> 
									<img src="{{asset('public/images/stores').'/'.$value->image}}" width="50" height="50">
									{{$value->name}}</td>
								<td>{{$value->vendor_name}}</td>
								<td>${{number_format($value->total_price,2)}}</td>
							</tr>
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
					@foreach($customer_reviews as $review)
					<li class="list-group-item">
						<div class="media align-items-center">
							@if(!empty($review->image))
								<img src="{{asset('public/user_photo/'.$review->image)}}" alt="user avatar" class="customer-img rounded-circle">
							@else
								<img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded-circle">
							@endif
							<div class="media-body ml-3">
								<h6 class="mb-0">{{$review->product}}<small class="ml-4"><?php echo date('H:i:s',strtotime($review->created_at));?></small>
								</h6>
								<p class="mb-0 small-font">{{$review->username}} : @if(!empty($review->comment)){{$review->comment}} @else - @endif</p>
							</div>
							<div class="star">
								@php
								  for($i=1;$i<=5;$i++) {
								  $selected = "";
								  if(!empty($review["rating"]) && $i<=$review["rating"]) {
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
	var vendor_id = "{{(isset($input['vendor']) ? $input['vendor']: '')}}"; 
	var store_id = "{{(isset($input['store']) ? $input['store']: '')}}";
	$(function() {
	    $(".knob").knob();
	});
	$( document ).ready(function() {

		setTimeout(function(){ getStores(); }, 500);
		$('.categories').multiselect({
			nonSelectedText: 'Select Categories',
			buttonWidth: '100%',
			maxHeight: 500,
		});
		$("#vendor").change(function() {
        	vendor_id = $(this).val();
        	getStores();
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

		//total store graph
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
		    markers : @php echo json_encode($total_store_graph); @endphp,
		    hoverOpacity: null,
		    normalizeFunction: 'linear',
		    scaleColors: ['#b6d6ff', '#005ace'],
		    selectedColor: '#c9dfaf',
		    selectedRegions: [],
		    showTooltip: true,
		}); 

		var category = <?php echo json_encode($result);?>;
		$(".categories").append(category);
		$('.categories').multiselect('rebuild');

		$('#start_date').datepicker('setDate', '{{date("m/d/Y", strtotime($start_date))}}');
		$('#end_date').datepicker('setDate', '{{date("m/d/Y", strtotime($end_date))}}');
		
	});

function getStores(){

    if(vendor_id != ''){

    	$('#vendor').val(vendor_id);
        $.ajax({
            type: "get",
            url: "{{ url('/get-stores') }}/"+vendor_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#store').empty();
                $("#store").append('<option value="">Select Store</option>');
                $.each(data, function(i, val) {
                    $("#store").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if($("#store option[value='"+store_id+"']").length > 0){
                    $('#store').val(store_id);
                }
            },
            error: function (data) {
            }
        });
    }else{
    
        $("#vendor").val('');
    }
}


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
