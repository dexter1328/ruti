@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-tag"></i> --><span>Edit Unverified Coupon</span></div>
			</div>
			<div class="card-body">
                <div class="alert alert-danger alert-dismissible error_date" role="alert" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <div class="alert-icon">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="alert-message">
                        <span class="ajax-error-date"></span>
                    </div>
                </div>
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{route('vendor_coupons.update',$vendor_coupon->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="vendor_id" class="form-control" id="vendor_id">
								<option value="">Select Vendor</option>
								@foreach($vendors as $vendor)
								<option value="{{$vendor->id}}" {{ (old("vendor_id", $vendor_coupon->vender_id) == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
							<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store_id" class="form-control" id="store_id">
								<option value="">Select store</option>
							</select>
							@if ($errors->has('store_id'))
							<span class="text-danger">{{ $errors->first('store_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="brand" class="col-sm-2 col-form-label">Brand</label>
                        <div class="col-sm-4">
                            <select name="brand" id="brand" class="form-control">
                                <option value="">Select Brand</option>
                            </select>
                            @if ($errors->has('brand')) 
                                <span class="text-danger">{{ $errors->first('brand') }}</span> 
                            @endif 
                        </div>
						<label for="input-10" class="col-sm-2 col-form-label">Categories</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                            </select>
                            @if ($errors->has('categories'))
                            <span class="text-danger">{{ $errors->first('categories') }}</span>
                            @endif
                        </div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Coupon Code<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="coupon_code" placeholder="Enter Coupon Code" 
                            value="{{old('coupon_code',$vendor_coupon->coupon_code)}}">
							@if ($errors->has('coupon_code'))
							<span class="text-danger">{{ $errors->first('coupon_code') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Discount<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="input-13" name="discount" placeholder="Enter Amount" 
                            value="{{old('discount',$vendor_coupon->discount)}}">
                            @if ($errors->has('discount'))
                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                            @endif
                        </div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Discription</label>
                        <div class="col-sm-4">
                           <textarea name="description" class="form-control">{{old('description',$vendor_coupon->description)}}</textarea>
                            @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Start Date<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control start_date" id="autoclose-datepicker" name="start_date" placeholder="Enter Start Date" 
                            value="{{old('start_date',date('m/d/Y', strtotime($vendor_coupon->start_date)))}}">
                            @if ($errors->has('start_date'))
                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">End Date<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control end_date" id="autoclose-datepicker1" name="end_date" placeholder="Enter End Date" value="{{old('end_date',date('m/d/Y', strtotime($vendor_coupon->end_date)))}}">
							@if ($errors->has('end_date'))
							<span class="text-danger">{{ $errors->first('end_date') }}</span>
							@endif
						</div>
                        <label for="input-13" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="input-13" name="image">
                            @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                            @if($vendor_coupon->image)
                            <br>
                            <a href="{{url('public/images/vendors_coupan/'.$vendor_coupon->image)}}" rel="prettyPhoto">
                                <img src="{{url('public/images/vendors_coupan/'.$vendor_coupon->image)}}" style="width: 100px; height: auto;">
                            </a>
                            @endif
                        </div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
                                @php $ac_status = ''; $de_status = '';
                                    if(old('status')){
                                        if(old('status')=='enable'){
                                            $ac_status = 'selected="selected"';
                                        }elseif(old('status')=='disable'){
                                            $de_status = 'selected="selected"';
                                        }
                                    }
                                    else{
                                        if($vendor_coupon->status == 'enable'){
                                            $ac_status = 'selected="selected"';
                                        }elseif($vendor_coupon->status == 'disable'){
                                            $de_status = 'selected="selected"';
                                        }
                                    }
                                @endphp
								<option value="enable"{{$ac_status}}>Enable</option>
								<option value="disable"{{$de_status}}>Disable</option>
							</select>
							@if ($errors->has('status'))
							<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
                        <label for="input-12" class="col-sm-2 col-form-label">Verify Coupon</label>
                        <div class="col-sm-4">
                            <select name="coupon_status" class="form-control">
                                <option value="unverified" selected>Unverify</option>
                                <option value="verified">Verify</option>
                            </select>
                        </div>
                       
                    </div>
                    <!--  -->
                        <div class="form-group row">
                             <label for="title" class="col-sm-2 control-label">Type<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="input-7" name="type">
                                    <option value="">Select Type</option>
                                    @php $single = ''; $multiple = '';
                                        if(old('type')){
                                            if(old('type')=='single'){
                                                $single = 'selected="selected"';
                                            }elseif(old('type')=='multiple'){
                                                $multiple = 'selected="selected"';
                                            }
                                        }
                                        else{
                                            if($vendor_coupon->type == 'single'){
                                                $single = 'selected="selected"';
                                            }elseif($vendor_coupon->type == 'multiple'){
                                                $multiple = 'selected="selected"';
                                            }
                                        }
                                    @endphp
                                    <option value="single"{{$single}}>Single</option>
                                    <option value="multiple"{{$multiple}}>Multiple</option>
                                </select>
                            </div>
                            <label for="title" class="col-sm-2 control-label">Coupon for<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="discount_for" id="discount_for">
                                    <option value="">Select Coupon for</option>
                                    @php $all = ''; $selected = '';
                                        if(!empty($discount_users)){
                                            $selected = 'selected="selected"';
                                        }
                                        else{
                                            $all = 'selected="selected"';
                                        }
                                    @endphp
                                    <option value="all"{{$all}}>All</option>
                                    <option value="selected"{{$selected}}>Selected</option>
                                </select>
                            </div>
                            @if(empty($discount_users))
                                <style type="text/css">
                                    .selected_div{display: none;}
                                </style>
                            @endif
                            <label for="title" class="col-sm-2 control-label selected_div">User<span class="text-danger">*</span></label>
                            <div class="col-sm-4 selected_div">
                                <select name="users[]" class="form-control" multiple="multiple" id="users" >
                                    @foreach($users as $user)
                                        @php $selected = (in_array($user['id'], $discount_users) ? 'selected="selected"' : ''); @endphp
                                        <option value="{{$user->id}}" {{$selected}}>{{$user->first_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                            <a href="{{url('admin/vendor_coupons/unverified')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var vendor_id = "{{old('vendor_id', $vendor_coupon->vender_id)}}"; 
var store_id = "{{old('store_id', $vendor_coupon->store_id)}}";
var brand_id = "{{old('brand', $vendor_coupon->brand_id)}}";
var category_ids = {!! json_encode(old('categories', explode(',', $vendor_coupon->category_id))) !!};
var discount_for = "{{old('discount_for')}}";

if(discount_for != ''){
    $("#discount_for option[value='" + discount_for + "']").prop("selected", true);
    if(discount_for == 'selected'){
        $('.selected_div').show();
    }

    var users = {!! json_encode(old('users')) !!};
    if(users != null && users != ''){
        $.each(users, function(index, value){
            if($("#users option[value='"+value+"']").length > 0){
                $("#users option[value='" + value + "']").prop("selected", true);
            }
        });
    }

}

$(document).ready(function() {

    $('#categories').multiselect({
        nonSelectedText: 'Select Categories',
        buttonWidth: '100%',
        maxHeight: 500,
    });
    
    setTimeout(function(){ getStores(); }, 500);
    setTimeout(function(){ getBrands(); }, 600);
    setTimeout(function(){ getCategoriesDropDown(); }, 700);

    $("#vendor_id").change(function() {
        vendor_id = $(this).val();
        getStores();
    });

    $("#store_id").change(function() {
        store_id = $(this).val();
        getBrands();
        getCategoriesDropDown();
    });

    $('#users').multiselect({
        nonSelectedText: 'Select User',
        buttonWidth: '100%',
        maxHeight: 500
    });

    $( "#discount_for" ).change(function() {
        if($(this).val() == 'selected'){
            $('.selected_div').show();
        }else{
            $('.selected_div').hide();
        }
    });

    $('.start_date').change(function(){
        if($('.start_date').val() != '' && $('.end_date').val() != ''){
            if($('.start_date').val() > $('.end_date').val() ){
                 alert($('.start_date').val());
                console.log('Please select valid start date');
                $('.error_date').show();
                $('.ajax-error-date').html('Please select valid start date');
            }
        }
    });

    $('.end_date').change(function(){
        if($('.end_date').val() < $('.start_date').val() ){
            console.log('Please select valid end date');
            $('.error_date').show();
            $('.ajax-error-date').html('Please select valid end date');
        }
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
                $('#store_id').empty();
                $("#store_id").append('<option value="">Select Store</option>');
                $.each(data, function(i, val) {
                    $("#store_id").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if($("#store_id option[value='"+store_id+"']").length > 0){
                    $('#store_id').val(store_id);
                }
            },
            error: function (data) {
            }
        });
    }else{
    
        $("#vendor_id").val('');
    }
}

function getBrands(){

    if(store_id != ''){

        $.ajax({
            type: "get",
            url: "{{ url('/get-brands') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#brand').empty();
                $("#brand").append('<option value="">Select Brand</option>');
                $.each(data, function(i, val) {
                    $("#brand").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if($("#brand option[value='"+brand_id+"']").length > 0){
                    $('#brand').val(brand_id);
                }
            },
            error: function (data) {
            }
        });
    }
}

function getCategoriesDropDown(){

    if(store_id != ''){

        $.ajax({
            type: "get",
            url: "{{ url('/get-categories-dropdown') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#categories').empty();
                $("#categories").append(data.categories);
                if(category_ids != null && category_ids != ''){
                    $.each(category_ids, function(index, value){
                        console.log(value);
                        if($("#categories option[value='"+value+"']").length > 0){
                            $("#categories option[value='" + value + "']").prop("selected", true);
                        }
                    });
                }
                $('#categories').multiselect('rebuild');
            },
            error: function (data) {
            }
        });
    }else{
    
        $("#store_id").val('');
    }
}
</script>
@endsection 