@extends('front_end.layout')
@section('content')



<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Checkout</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
@if ($errors->any())
    <div class="alert alert-danger container">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!--Checkout page section-->
<div class="Checkout_section mt-70">
   <div class="container">

        <div class="checkout_form">
            <form action="{{route('post-checkout')}}" method="POST">
                @csrf
            <div class="row">
                <div class="col-lg-6 main_parent_div mt-4 border col-md-6 p-0">

                        <h3 class='sections_coupons_header w-100'>Billing and Shipping Details</h3>
                        <div class="row p-3">

                            @if (!Auth::guard('w2bcustomer')->user())
                            <div class="col-lg-6 mb-20">
                                <label>First Name <span>*</span></label>
                                <input type="text" name="first_name" placeholder="Enter First Name">
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Last Name  <span>*</span></label>
                                <input type="text" name="last_name" placeholder="Enter Last Name">
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Phone<span>*</span></label>
                                <input type="number" name="mobile" placeholder="Enter Phone Number">

                            </div>
                             <div class="col-lg-6 mb-20">
                                <label> Email Address   <span>*</span></label>
                                  <input type="email" name="email" placeholder="Enter Email Address">

                            </div>
                            @endif

                            <div class="col-12 mb-20">
                                <label for="country">State <span>*</span></label>
                                <select class="select2" name="state" id="state_id2">
                                    <option value="0">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-20">
                                {{-- <label>Town / City <span>*</span></label> --}}
                                <select name="city" id="city_id2"   class="select2 city-class d-none">
                                </select>
                            </div><br>
                            <div class="col-12 mb-20">
                                <label>Zip Code  <span>*</span></label>
                                <input placeholder="Enter Zip Code" type="text" name="zip_code">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Street address  <span>*</span></label>
                                <input placeholder="House number and street name" type="text" name="address">
                            </div>
                            <div class="col-12 mb-20">
                                <input placeholder="Apartment, suite, unit etc. (optional)" type="text" name="address2">
                            </div>


                            @if (!Auth::guard('w2bcustomer')->user())

                            <div class="col-12 mb-20">
                                <input id="account" type="checkbox" data-target="createp_account" />
                                <label for="account" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">Create an account?</label>

                                <div id="collapseOne" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                       <label> Account password   <span>*</span></label>
                                        <input placeholder="password" type="password" name="password">
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-12">
                                <div class="order-notes">
                                     <label for="order_note">Order Notes</label>
                                    <textarea id="order_note" name="order_notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 mt-4">
                    <div class='mb-4 border main_parent_div'>
                        <h3 class='sections_coupons_header'>COUPON CODE</h3>
                        <div class='p-3'>
                            <div class='h6'>Only one code can be applied per order</div>
                            <div>
                                <input type="text" class='w-75' id="coupon_code_input" placeholder=''>
                                <button class='ml-0 apply_button' type="button" id="apply_coupon_btn">APPLY</button>
                            </div>
                            <div id="coupon_message"></div> <!-- Display coupon messages here -->
                        </div>
                    </div>

                        <div class="order_table table-responsive main_parent_div border">
                            <h3 class='sections_coupons_header'>Your order</h3>
                            <table>
                                <thead class='no_bg'>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    $totalShippingPrice = 0; // Initialize the total shipping price
                                    $totalTax = 0;
                                    @endphp

                                    @if(session('cart'))
                                    @foreach(session('cart') as $sku => $details)
                                    @php
                                    $subtotal = $details['retail_price'] * $details['quantity'];
                                    $total += $subtotal;
                                    $tax = ($details['sales_tax_pct'] / 100) * $subtotal;
                                    $totalTax += $tax; // Accumulate tax for each item
                                    $totalShippingPrice += $details['shipping_price']; // Accumulate shipping price
                                    $total_price = $subtotal + $details['shipping_price'] + $tax;
                                    @endphp
                                    <input type="hidden" value="{{$details['vendor_id']}}" name="vendor_id[]">
                                    <tr>
                                        <td> {{ Str::limit($details['title'], 35) }} <strong> × {{$details['quantity']}}</strong></td>
                                        <td> ${{number_format((float)$subtotal, 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td>${{number_format((float)$total, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>${{number_format((float)$totalShippingPrice, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Sales Tax</th>
                                        <td><strong>${{number_format((float)$totalTax, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td><strong id="discount_amount">$0.00</strong></td>
                                    </tr>
                                    <tr class="order_total" >
                                        <th>Order Total</th>
                                        <td><strong id="order_total">${{number_format((float)($total + $totalShippingPrice + $totalTax), 2, '.', '')}}</strong></td>
                                    </tr>
                                </tfoot>
                                <input type="hidden" value="{{$total + $totalShippingPrice + $totalTax}}" name="total_price" id="total_price_input">
                            </table>

                        </div>
                        <div class="payment_method">
                            <div class='order_button'>
                                <button class='mt-2 w-100' type="submit">Proceed to Payment</button>
                            </div>
                        </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<!--Checkout page section end-->


@endsection


@section('scriptss')
<script>
    $(document).ready(function() {
    $('#state_id2').on('change', function() {

       var state_id = $(this).val();
    //    var companyID = $("#company2_id").val();
    //    console.log(cityID);
       if(state_id) {
           $.ajax({
              //  url: '/state/'+stateID,
              url: "{{url('/state_cities')}}/"+state_id,
               type: "GET",
               data : {"_token":"{{ csrf_token() }}"},
               dataType: "json",
               success:function(data) {
                   console.log(data);
                 if(data){
                   $('.city-class').removeClass('d-none');
                   $('#city_id2').empty();
                   $('#city_id2').focus;
                   $('#city_id2').append('<option value="">-- Select City --</option>');
                   $.each(data, function(key, value){
                   $('select[name="city"]').append('<option value="'+ value.id +'">' + value.name+'</option>');
               });
             }else{
               $('#city_id2').empty();
             }
             }
           });
       }else{
         $('#city_id2').empty();
       }
    });
    });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2({
        placeholder: "-- Select City --"
        });
    });
</script>
<script>
    document.getElementById('apply_coupon_btn').addEventListener('click', function() {
        let couponCode = document.getElementById('coupon_code_input').value;
        let total_price = parseFloat($('input[name="total_price"]').val());

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: '{{ route("user-apply-coupon") }}',
            data: {
                coupon_code: couponCode,
                total_price: total_price,
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    // Update the coupon message div with the response
                    $('#coupon_message').html(response.message);

                    // Update the order total based on the discount
                    let discount = parseFloat(response.discount);
                    let newTotal = total_price - discount;

                    // Display the updated order total
                    $('#order_total').html('$' + newTotal.toFixed(2));
                    $('#discount_amount').html('$' + discount.toFixed(2));
                    $('#total_price_input').val(newTotal.toFixed(2));
                } else {
                    // Display the error message
                    $('#coupon_message').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
@endsection
