@extends('vendor.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-tag"></i> --><span>Add Coupon</span></div>
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
                    <form id="signupForm" method="post" action="{{route('vendor.vendor_coupons.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="input-11" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                             <select name="store_id" class="form-control" id="store_id">
                                <option value="">Select store</option>
                                @foreach($vendor_stores as $vendor_store)
                                <option value="{{$vendor_store->id}}" {{ (old("store_id") == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('store_id'))
                            <span class="text-danger">{{ $errors->first('store_id') }}</span>
                            @endif
                        </div>
                        <label for="input-13" class="col-sm-2 col-form-label" id="userDDLabl">0 Coupon<span class="text-danger">*</span></label>
                        <div class="col-sm-4" id="userDDDiv">
                            <select name="users[]" class="form-control" multiple="multiple" id="users">
                            </select>
                            @if ($errors->has('users'))
                            <span class="text-danger">{{ $errors->first('users') }}</span>
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
                                @php /* @endphp
                                @foreach($vendor_categories as $vendor_category)
                                <option value="{{$vendor_category->id}}" {{ (old("categories") == $vendor_category->id ? "selected":"") }}>{{$vendor_category->name}}</option>
                                @endforeach
                                @php */ @endphp
                            </select>
                            @if ($errors->has('categories'))
                            <span class="text-danger">{{ $errors->first('categories') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">Coupon Code<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="input-13" name="coupon_code" placeholder="Enter Coupon Code" value="{{old('coupon_code')}}">
                            @if ($errors->has('coupon_code'))
                            <span class="text-danger">{{ $errors->first('coupon_code') }}</span>
                            @endif
                        </div>
                        <label for="input-13" class="col-sm-2 col-form-label">Discount<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="input-13" name="discount" placeholder="Enter Discount Percent" value="{{old('discount')}}">
                            @if ($errors->has('discount'))
                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" id="input-7" name="type">
                                <option value="">Select Type</option>
                                <option value="single" @if(old('type')=='single') selected="selected" @endif>Single</option>
                                <option value="multiple" @if(old('type')=='multiple') selected="selected" @endif>Multiple</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                           <textarea name="description" class="form-control">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">Start Date<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control start_date autoclose-datepicker" name="start_date" placeholder="Enter Start Date" value="{{old('start_date')}}">
                            @if ($errors->has('start_date'))
                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">End Date<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control end_date autoclose-datepicker" name="end_date" placeholder="Enter End Date" value="{{old('end_date')}}">
                            @if ($errors->has('end_date'))
                            <span class="text-danger">{{ $errors->first('end_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">   
                        <label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="enable" @if(old('status')=='enable' ) selected="selected" @endif>Enable</option>
                                <option value="disable" @if(old('status')=='disable' ) selected="selected" @endif>Disable</option>
                            </select>
                            @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <label for="input-13" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="input-13" name="image">
                            @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                        @php /* @endphp
                        <label for="input-12" class="col-sm-2 col-form-label">Coupon For<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="discount_for" id="discount_for">
                                <option value="">Select Coupon for</option>
                                <option value="all" @if(old('discount_for')=='all') selected="selected" @endif>All</option>
                                <option value="selected" @if(old('discount_for')=='selected') selected="selected" @endif>Selected</option>
                            </select>
                            @if ($errors->has('discount_for'))
                                <span class="text-danger">{{ $errors->first('discount_for') }}</span>
                            @endif
                        </div>
                        @php */ @endphp
                    </div>
                    @php /* @endphp
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label selected_div" style="display:none;">User<span class="text-danger">*</span></label>
                        <div class="col-sm-4 selected_div" id="selected_div" style="display:none;">
                            <select name="users[]" class="form-control" multiple="multiple" id="users">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{ (old("users") == $user->id ? "selected":"") }}>{{$user->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row"></div>
                    @php */ @endphp
                    <center>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                            <a href="{{url('admin/vendor_coupons')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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
var vendor_id = "{{old('vendor_id')}}"; 
var store_id = "{{old('store_id')}}";
var brand_id = "{{old('brand')}}";
// var discount_for = "{{old('discount_for')}}";

var category_ids = {!! json_encode(old('categories')) !!};
var user_ids = {!! json_encode(old('users')) !!};

/*if(discount_for == 'selected'){
    $('.selected_div').show();
    var users = {!! json_encode(old('users')) !!};
     if(users != null && users != ''){
        $.each(users, function(index, value){
            if($("#users option[value='"+value+"']").length > 0){
                $("#users option[value='" + value + "']").prop("selected", true);
            }
        });
    }
}*/

$(document).ready(function() {

    $('#users').multiselect({
        nonSelectedText: 'Select 0 Coupon (Free)',
        buttonWidth: '100%',
        maxHeight: 500
    });

    $('#categories').multiselect({
        nonSelectedText: 'Select Categories',
        buttonWidth: '100%',
        maxHeight: 500,
    });
    
    setTimeout(function(){ getStores(); }, 500);
    setTimeout(function(){ getBrands(); }, 600);
    setTimeout(function(){ getUserDropDown(); }, 700);
    setTimeout(function(){ getCategoriesDropDown(); }, 700);

    $("#vendor_id").change(function() {
        vendor_id = $(this).val();
        getStores();
    });

    $("#store_id").change(function() {
        store_id = $(this).val();
        getBrands();
        getUserDropDown();
        getCategoriesDropDown();
    });

    $('.start_date').change(function(){
        if($('.start_date').val() != '' && $('.end_date').val() != ''){
             if($('.start_date').val() > $('.end_date').val() ){
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

    /*$( "#discount_for" ).change(function() {
        if($(this).val() == 'selected'){
            $('.selected_div').show();
        }else{
            $('.selected_div').hide();
        }
    });*/

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

function getUserDropDown()
{
    if(store_id != ''){ 

        $.ajax({
            type: "get",
            url: "{{ url('/get-store-customers') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                
                if(jQuery.isEmptyObject(response.store_subscription)) {

                    var userDDLabl = 'Select 0 Coupon (Free)';
                    $('#userDDLabl').html('0 Coupon<span class="text-danger">*</span>');

                    $('#users').multiselect('destroy');
                    $('#users').empty();
                    $('#users').multiselect({
                        nonSelectedText: userDDLabl,
                        buttonWidth: '100%',
                        maxHeight: 500
                    });

                }else{

                    if(response.store_subscription.membership.code == "sprout") {
                        var selection_limit = 20;
                        var userDDLabl = 'Select 20 Coupon ('+response.store_subscription.membership.name+')';
                        $('#userDDLabl').html('20 Coupons<span class="text-danger">*</span>');
                    }else if(response.store_subscription.membership.code == "blossom") {
                        var selection_limit = 30;
                        var userDDLabl = 'Select 30 Coupon ('+response.store_subscription.membership.name+')';
                        $('#userDDLabl').html('30 Coupons<span class="text-danger">*</span>');
                    }else if(response.store_subscription.membership.code == "one_time_setup_fee") {
                        var selection_limit = 30;
                        var userDDLabl = 'Select 30 Coupon ('+response.store_subscription.membership.name+')';
                        $('#userDDLabl').html('30 Coupons<span class="text-danger">*</span>');
                    }

                    $('#users').multiselect('destroy');

                    $('#users').empty();
                    $.each(response.users, function(i, val) {
                        $("#users").append('<option value="'+val.id+'">' +val.first_name + ' ' + val.last_name + '</option>');
                    });
                    if(user_ids != null && user_ids != ''){
                        $.each(user_ids, function(index, value){
                            if($("#users option[value='"+value+"']").length > 0){
                                $("#users option[value='" + value + "']").prop("selected", true);
                            }
                        });
                    }

                    $('#users').multiselect({
                        nonSelectedText: userDDLabl,
                        buttonWidth: '100%',
                        maxHeight: 500,
                        onChange: function(option, checked) {
                            // Get selected options.
                            var selectedOptions = $('#users option:selected');
             
                            if (selectedOptions.length >= selection_limit) {
                                // Disable all other checkboxes.
                                var nonSelectedOptions = $('#users option').filter(function() {
                                    return !$(this).is(':selected');
                                });
             
                                nonSelectedOptions.each(function() {
                                    var input = $('input[value="' + $(this).val() + '"]');
                                    input.prop('disabled', true);
                                    input.parent('.multiselect-option').addClass('disabled');
                                });
                            }
                            else {
                                // Enable all checkboxes.
                                $('#users option').each(function() {
                                    var input = $('input[value="' + $(this).val() + '"]');
                                    input.prop('disabled', false);
                                    input.parent('.multiselect-option').addClass('disabled');
                                });
                            }
                        }
                    });
                }
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