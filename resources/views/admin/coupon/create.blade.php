@extends('admin.layout.main')
@section('content')

{{-- code here --}}
<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_withdraw">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                    <h5 class="i_text_color my-3">Add New Blog:</h5>
                    <div class="col-12">
                        <form action="{{route('admin_coupon.store')}}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">coupon type</label>
                                                <select name="coupon_type" class="custom-select" onchange="coupon_type_change(this.value)">
                                                    <option value="default">default</option>
                                                    <option value="first_order">first order</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">Coupon_Title</label>
                                                <input type="text" name="title" class="form-control" placeholder="New coupon" required maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label class="input-label">Coupon_Code</label>
                                                    {{-- <a href="javascript:void(0)" class="float-right c1 fz-12" onclick="generateCode()">generate_code</a> --}}
                                                </div>
                                                <input type="text" name="code" id="coupon-code" class="form-control" maxlength="15"
                                                    placeholder="{{\Illuminate\Support\Str::random(8)}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6" id="limit-for-user">
                                            <div class="form-group">
                                                <label class="input-label">limit for same user</label>
                                                <input type="number" name="limit" id="user-limit" class="form-control" placeholder="EX: 10" required min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">discount_Type</label>
                                                <select name="discount_type" id="discount_type" class="form-control">
                                                    <option value="percent">percent</option>
                                                    <option value="amount">amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label text-capitalize" id="discount_label">discount_percent</label>
                                                <input type="number" step="any" min="1" max="10000" placeholder="Ex: 50%" id="discount_input" name="discount" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">minimum purchase</label>
                                                <input type="number" step="any" name="min_purchase" value="0" min="0" max="100000" class="form-control"
                                                    placeholder="100">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6" id="max_discount_div">
                                            <div class="form-group">
                                                <label class="input-label">maximum discount</label>
                                                <input type="number" step="any" min="0" value="0" max="1000000" name="max_discount" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">start date</label>
                                                <input type="date" name="start_date" class="js-flatpickr form-control flatpickr-custom" placeholder="yyyy-mm-dd" data-hs-flatpickr-options='{ "dateFormat": "Y/m/d", "minDate": "today" }'>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="input-label">expire date</label>
                                                <input type="date" name="expire_date" class="js-flatpickr form-control flatpickr-custom" placeholder="yyyy-mm-dd" data-hs-flatpickr-options='{ "dateFormat": "Y/m/d", "minDate": "today" }'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-3">
                                        <button type="reset" class="btn btn-secondary">reset</button>
                                        <button type="submit" class="btn btn-primary">submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    {{-- <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote7').summernote({
          height: 200, // set editor height
          minHeight: null, // set minimum height of editor
          maxHeight: null, // set maximum height of editor
          focus: true // set focus to editable area after initializing summernote
       });
        });
    </script> --}}

    <script>
        $("#discount_type").change(function(){
            if(this.value === 'amount') {
                $("#max_discount_div").hide();
                $("#discount_label").text("discount_amount')}}");
                $("#discount_input").attr("placeholder", "Ex: 500')}}")
            }
            else if(this.value === 'percent') {
                $("#max_discount_div").show();
                $("#discount_label").text("discount_percent')}}")
                $("#discount_input").attr("placeholder", "Ex: 50%')}}")
            }
        });
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF FLATPICKR
            // =======================================================
            $('.js-flatpickr').each(function () {
                $.HSCore.components.HSFlatpickr.init($(this));
            });
        });

        function coupon_type_change(order_type) {
            if(order_type=='first_order'){
                $('#user-limit').removeAttr('required');
                $('#limit-for-user').hide();
            }else{
                $('#user-limit').prop('required',true);
                $('#limit-for-user').show();
            }
        }
    </script>

    <script>
        function generateCode() {
            $.get('{{route('generate-coupon-code')}}', function (data) {
                $('#coupon-code').val(data)
            });
        }

    </script>
@endsection
