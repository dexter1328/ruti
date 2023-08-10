@extends('front_end.layout')
@section('content')


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Payment</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>Payment Page</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
{{-- xyz --}}
{{-- xyz2 --}}
{{-- xyz3 --}}
<!--Checkout page section-->
<div class="Checkout_section mt-70">
   <div class="container">
    @if (Session::has('success'))
    <div class="alert alert-success text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p>{{ Session::get('error') }}</p>
    </div>
    @endif
        <div class="checkout_form">

            <div class="row justify-content-between">


                <div class="col-lg-6 col-md-6 border main_parent_div p-0 mt-2">
                    <div class='form-row row '>
                        <div class='col-md-12 error form-group d-none'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.</div>
                        </div>
                    </div>

                        <h3 class='sections_coupons_header'>Payment Details</h3>
                        <div class="row m-auto w-100" >

                        <div class="row m-auto w-100" >
                            <div id="accordion" class='payment_accordion mb-2 mx-auto'>
                                <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed w-100" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <span class='text-dark d-flex justify-content-between payspan'>Pay with Card <span><i class='fa fa-chevron-down'></i></span></span>
                                                    </button>
                                                </h5>
                                            </div>


                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                <form
                                                    role="form"
                                                    action="{{ route('order-payment') }}"
                                                    method="post"
                                                    class="require-validation"
                                                    data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{$stripe_key}}"
                                                    id="payment-form">
                                                    @csrf
                                                <div class="card-body">
                                                    <div class="col-lg-12 mb-20  required">
                                                    <label>Name on Card <span>*</span></label>
                                                    <input class='form-control' size='4' type='text' placeholder='Enter Name on Card'>
                                                    </div>
                                                    <div class="col-lg-12 mb-20 card required" style="border: none">
                                                        <label>Card Number  <span>*</span></label>
                                                        <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='Enter Card Number'>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 mb-20 cvc required">
                                                            <label>CVC</label>
                                                            <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'type='text'>
                                                        </div>
                                                        <div class="col-4 mb-20 expiration required">
                                                            <label>Expiration Month  <span>*</span></label>
                                                            <input class='form-control card-expiry-month' placeholder='MM' size='2'type='text'>
                                                        </div>
                                                        <div class="col-4 mb-20 expiration required">
                                                            <label>Expiration Year <span>*</span></label>
                                                            <input class='form-control card-expiry-year' placeholder='YYYY' size='4'type='text'>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 order_button">
                                                        <button  type="submit">Pay Now</button>
                                                    </div>
                                                </div>
                                            </form>

                                            </div>
                                        </div>
                                        <div class="card">
                                        <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed w-100" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <span class='text-dark d-flex justify-content-between payspan'>Pay with PayPal <span><i class='fa fa-chevron-down'></i></span></span>
                                            </button>
                                        </h5>

                                        </div>

                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('paypal-payment')}}" >
                                            {{ csrf_field() }}
                                        <div class="card-body">
                                            @php
                                                $op = session('w2border')
                                            @endphp
                                            @php
                                                $tp = $op->total_price

                                            @endphp
                                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                {{-- <label for="amount" class="col-md-4 control-label">Pay ${{$tp}}</label> --}}
                                                <div class="col-md-6">
                                                    <span class="input-group-text usd-ico" style="width: 35px; position: absolute; top: 0px; left: -4px; height: 40px;"><i class="fa fa-usd"></i></span>
                                                    <input  type="hidden" class="form-control" name="amount" value="{{$tp}}"  />
                                                    <input disabled="disabled"  type="number" class="form-control"  value="{{$tp}}"  />
                                                    {{-- <i class="fa fa-usd form-control-feedback"></i> --}}
                                                        @if ($errors->has('amount'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('amount') }}</strong>
                                                        </span>
                                                        @endif
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-6 offset-2">
                                                    <button type="submit" class="btn btn-primary">
                                                      Click to Pay with Paypal
                                                    </button>
                                                </div>
                                            </div>
                                      </div>
                                    </form>

                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed w-100" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <span class='text-dark d-flex justify-content-between payspan'>Pay with Digital Wallet <span><i class='fa fa-chevron-down'></i></span></span>
                                            </button>
                                        </h5>

                                        </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                        @if (Auth::guard('w2bcustomer')->user())
                                        @php
                                                $op = session('w2border')
                                            @endphp
                                            @php
                                                $tp = $op->total_price

                                            @endphp
                                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('user-wallet-payment', $tp)}}" >
                                            {{ csrf_field() }}
                                        <div class="card-body">


                                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                {{-- <label for="amount" class="col-md-4 control-label">Pay ${{$tp}}</label> --}}
                                                <h3>Your Balance : ${{Auth::guard('w2bcustomer')->user()->wallet_amount}}</h3>
                                                <h3>Order Total : {{$tp}}</h3>
                                                <input  type="hidden" class="form-control" name="amount" value="{{$tp}}"  />
                                                @if ($errors->has('amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                                @endif


                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-6 offset-2">
                                                    <button type="submit" class="btn btn-primary">
                                                      Click to Pay
                                                    </button>
                                                </div>
                                            </div>
                                      </div>
                                    </form>
                                    @else
                                    <div class="form-group">
                                        <div class="col-lg-6 offset-2">
                                            <button type="" onclick="window.location='{{ url("w2bcustomer/login") }}'" class="btn btn-primary">
                                              Login First to pay with Digital wallet
                                            </button>
                                        </div>
                                    </div>
                                    @endif

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </form>
                    <!-- {{-- <form class="w3-container w3-display-middle w3-card-4 "
                     method="POST"   action="{{route('paypal-payment')}}">
                        {{ csrf_field() }}
                        <h2 class="w3-text-blue">Payment Form</h2>
                        <input type="text" name="amount">

                        <input type="submit" name="submit" value="Pay Now" />
                        {{-- <a href="{{ route('paypal-payment') }}" class="btn btn-success">Pay $100 from Paypal</a> --}}
                        {{-- <button type="submit">Pay with PayPal</button>
                      </form> --}}
                      <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('paypal-payment')}}" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Enter Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Paywith Paypal
                                </button>
                            </div>
                        </div>
                    </form> -->


                </div>
                <div class="col-lg-5 col-md-5 border main_parent_div p-0 mt-2">
                    {{-- <form action="#"> --}}

                        <h3 class='sections_coupons_header'>Your order</h3>
                        <div class="order_table table-responsive mb-0">
                            <table>
                                <thead class='no_bg'>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp

                                    @if(session('cart'))
                                    @foreach(session('cart') as $sku => $details)
                                    @php $total += $details['retail_price'] * $details['quantity'] @endphp
                                    @php $tax = ($details['sales_tax_pct'] / 100) * $total @endphp
                                    @php $total_price = $total + $details['shipping_price'] + $tax @endphp
                                    <tr>
                                        <td><a> {{ Str::limit($details['title'], 30) }} </a><strong> × {{$details['quantity']}}</strong></td>
                                        <td> ${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</td>
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
                                        <td><strong>${{number_format((float)$details['shipping_price'], 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Sales Tax</th>
                                        <td><strong>${{number_format((float)$tax, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>${{number_format((float)$total_price, 2, '.', '')}}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method d-flex justify-content-end p-3 w-100">

                            {{-- <div class="order_button">
                                <button  type="submit">Pay Now ${{number_format((float)$total_price, 2, '.', '')}}</button>
                            </div> --}}
                        </div>

                </div>


            </div>

    </div>
    {{-- <div class='main_parent_div border col-lg-8 col-sm-12 m-auto px-0'>
        <h3 class='sections_coupons_header like_products_heading p-2' >Products You may like</h3>
        <div class='p-3 d-flex products_inner'>
            @foreach ($suggested_products as $p)
            <div class='more_products ml-2 py-2 px-4'>
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                <img src="{{$p->original_image_url}}" class='more_products_img'  alt="">
                </a>
                <div class='products_title'>
                    <h5><a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">{{ Str::limit($p->title, 20) }}</a></h5>
                </div>
            </div>
            @endforeach


        </div>
    </div> --}}
</div>
<!--Checkout page section end-->
@endsection

@section('scriptss')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

$(function() {

    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('d-none');
            e.preventDefault();
          }
        });

        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }

    });

    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});
</script>
@endsection
