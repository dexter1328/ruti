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
                <div class="col-lg-6 col-md-6">

                        <h3>Billing and Shipping Details</h3>
                        <div class="row">
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
                                 <label> Email Address <span>*</span></label>
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
                                <select name="city" id="city_id2"   class="select2 city-class d-none"></select>
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
                <div class="col-lg-6 col-md-6">
                    {{-- <form action="#"> --}}

                        <h3>Your order</h3>
                        <div class="order_table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp

                                    @if(session('cart'))
                                    @foreach(session('cart', []) as $sku => $details)
                                        @php
                                             $total += $details['retail_price'] * $details['quantity'];
                                             $tax = ($details['sales_tax_pct'] / 100) * $total;
                                             $total_price = $total + $details['shipping_price'] + $tax;
                                        @endphp
                                        <input type="hidden" value="{{$total_price}}" name="total_price">
                                        <tr>
                                            <td> {{ Str::limit($details['title'], 30) }} <strong> × {{$details['quantity']}}</strong></td>
                                            <td> ${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td>${{number_format((float)$total ?? 0, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td><strong>${{number_format((float)!empty($details['shipping_price']) ? $details['shipping_price'] : 0, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Sales Tax</th>
                                        <td><strong>${{number_format((float)isset($tax) ? $tax : 0, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>${{number_format((float)isset($total_price) ? $total_price : 0, 2, '.', '')}}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            @if(count(session('cart', [])) > 0)
                                <div class="order_button">
                                    <button  type="submit">Proceed to Payment</button>
                                </div>
                            @endif
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

<script>
    $(document).ready(function() {
        $(".select2").select2({
        placeholder: "-- Select City --"
        });
    });
</script>

@endsection
