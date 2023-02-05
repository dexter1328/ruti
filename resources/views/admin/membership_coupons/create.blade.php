@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-group"></i> --><span>Add Memership Coupon</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('membership-coupons.store') }}" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Coupon Code<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="stripe_coupon_id" id="stripe_coupon_id" class="form-control">
									<option value="">Select Coupon Code</option>
									@foreach($coupons as $key => $coupon)
										<option value="{{$key}}" @if(old('stripe_coupon_id')==$key) selected="selected" @endif>{{$coupon}}</option>
									@endforeach
								</select>
								@if ($errors->has('stripe_coupon_id'))
									<span class="text-danger">{{ $errors->first('stripe_coupon_id') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{old('name')}}">
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Discount(%)<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="discount" name="discount" placeholder="Enter Discount" value="{{old('discount')}}" readonly="readonly">
								@if ($errors->has('discount'))
									<span class="text-danger">{{ $errors->first('discount') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="vendor" id="vendor" class="form-control">
									<option value="">Select Vendor</option>
									@foreach($vendors as $vendor)
										<option value="{{$vendor->id}}" @if(old('vendor')==$vendor->id) selected="selected" @endif>{{$vendor->name}}</option>
									@endforeach
								</select>
								@if ($errors->has('vendor'))
									<span class="text-danger">{{ $errors->first('vendor') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="store" id="store" class="form-control">
									<option value="">Select Store</option>
								</select>
								@if ($errors->has('store'))
									<span class="text-danger">{{ $errors->first('store') }}</span>
								@endif
							</div>
						</div>
						@php /* @endphp
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="type" id="type" class="form-control">
									<option value="">Select Type</option>
										<option value="percentage_discount" @if(old('type')=='percentage_discount') selected="selected" @endif>Percentage discount</option>
										<option value="fixed_amount_discount" @if(old('type')=='fixed_amount_discount') selected="selected" @endif>Fixed amount discount</option>
								</select>
								@if ($errors->has('type'))
									<span class="text-danger">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Amount<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="amount" placeholder="Enter value based on type" value="{{old('amount')}}">
								@if ($errors->has('amount'))
									<span class="text-danger">{{ $errors->first('amount') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Duration<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="duration" id="duration" class="form-control">
									<option value="">Select Duration</option>
										<option value="forever" @if(old('duration')=='forever') selected="selected" @endif>Forever</option>
										<option value="once" @if(old('duration')=='once') selected="selected" @endif>Once</option>
										<option value="repeating" @if(old('duration')=='repeating') selected="selected" @endif>Multiple months</option>
								</select>
								@if ($errors->has('duration'))
									<span class="text-danger">{{ $errors->first('duration') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row" id="number_of_month_div" @if(!old('duration') || old('duration')!='repeating') style="display: none;" @endif>
							<label for="input-10" class="col-sm-2 col-form-label">Number of month(s)<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="number_of_month" placeholder="Enter number of month(s)" value="{{old('number_of_month')}}">
								@if ($errors->has('number_of_month'))
									<span class="text-danger">{{ $errors->first('number_of_month') }}</span>
								@endif
							</div>
						</div>
						@php */ @endphp
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/membership-coupons/')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var vendor_id = "{{old('vendor')}}";
	var store_id = "{{old('store')}}";
	
	$(document).ready(function(){
		$('#stripe_coupon_id').change(function(){
			$('#name').val($(this).find("option:selected").text());
			var sid = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('/admin/membership-coupons/retrive') }}/"+sid,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function (response) {
					console.log(response.percent_off);
					$('#discount').val(response.percent_off);
				},
				error: function (error) {
				}
			});
		});

		/*$('#duration').change(function(){
			if($(this).val() == 'repeating'){
				$('#number_of_month_div').show();
			}else{
				$('#number_of_month_div').hide();
			}
		});*/

		setTimeout(function(){ getStores(); }, 500);

		$("#vendor").change(function() {
			vendor_id = $(this).val();
			getStores();
		});
	});

	function getStores(){

		if(vendor_id != ''){
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
</script>
@endsection 