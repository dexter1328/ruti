@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-tags"></i> --><span>Edit Brand</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{route('brand.update',$brand->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="vendor" class="form-control" id="vendor">
								<option value="">Select Vendor</option>
								@foreach($vendors as $vendor)
										<option value="{{$vendor->id}}"{{ (old("vendor", $brand->vendor_id) == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
								<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif	
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store" id="store" class="form-control">
								<option value="">Select Store</option>
							</select>
							@if ($errors->has('store_id'))
								<span class="text-danger">{{ $errors->first('store_id') }}</span>
							@endif	
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="name" placeholder="Enter Name" value="{{old('name',$brand->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-4">
							<textarea class="form-control" name="description">{{old('description',$brand->description)}}</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-13" name="image">
							@if($brand->image)
	                            <br>
	                            <a href="{{url('public/images/brands/'.$brand->image)}}" rel="prettyPhoto">
	                                <img src="{{url('public/images/brands/'.$brand->image)}}" style="width: 200px; height: auto;">
	                            </a>
	                        @endif
						</div>
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
										if($brand->status == 'enable'){
											$ac_status = 'selected="selected"';
										}elseif($brand->status == 'disable'){
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
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/brand')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script>
var vendor_id = "{{old('vendor', $brand->vendor_id)}}"; 
var store_id = "{{old('store', $brand->store_id)}}";

$(function() {

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