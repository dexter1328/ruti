@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-star"></i> --><span>Edit Review</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
                    <form id="signupForm" method="post" action="{{route('customer_reviews.update',$customer_review->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="vendor_id" class="form-control" id="vendor_id">
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{$vendor->id}}"{{ (old("vendor_id", $customer_review->vendor_id) == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
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
                            <label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="customer_id" class="form-control">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"{{ (old("customer_id", $customer_review->customer_id) == $customer->id ? "selected":"") }}>{{$customer->first_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('customer_id'))
                                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                @endif
                            </div>
                            <label for="input-12" class="col-sm-2 col-form-label">review<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <textarea class="form-control" name="review">{{old('review',$customer_review->review)}}</textarea>
                                @if ($errors->has('review'))
                                    <span class="text-danger">{{ $errors->first('review') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    @php $verified = ''; $unverified = '';
                                        if(old('status')){
                                            if(old('status')=='verified'){
                                                $verified = 'selected="selected"';
                                            }elseif(old('status')=='unverified'){
                                                $unverified = 'selected="selected"';
                                            }
                                        }
                                        else{
                                            if($customer_review->status == 'verified'){
                                                $verified = 'selected="selected"';
                                            }elseif($customer_review->status == 'unverified'){
                                                $unverified = 'selected="selected"';
                                            }
                                        }
                                    @endphp
                                    <option value="verified"{{$verified}}>Verified</option>
                                    <option value="unverified"{{$unverified}}>Un Verified</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <center>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                <a href="{{url('admin/customer_reviews')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                            </div>
                        </center>
                    </form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script type="text/javascript">
  var vendor_id = "{{old('vendor_id', $customer_review->vendor_id)}}"; 
var store_id = "{{old('store_id', $customer_review->store_id)}}";

$(document).ready(function() {

    setTimeout(function(){ getStores(); }, 500);
   
    $("#vendor_id").change(function() {
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
</script>
@endsection 