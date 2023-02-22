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

<!--Checkout page section-->
<div class="Checkout_section mt-70">
   <div class="container">
    @if (Session::has('success'))
    <div class="alert alert-success text-center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p>{{ Session::get('success') }}</p>
    </div>
    @endif
        <div class="checkout_form">
            <form
                            role="form"
                            action="{{ route('order-payment') }}"
                            method="post"
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="pk_test_51IarbDGIhb5eK2lSKrWKttm9gweug3yv8EqP2PoVRAhD6HWsuviQWzKOszgIf7imZZ5sjUXHdQhF759Khm3J3nYF00Ved0Wutj"
                            id="payment-form">
                        @csrf
            <div class="row justify-content-between">


                <div class="col-lg-6 col-md-6 border main_parent_div p-0 mt-2">
                    <div class='form-row row '>
                        <div class='col-md-12 error form-group d-none'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.</div>
                        </div>
                    </div>
                        {{-- <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>


 --}}



                        <h3 class='sections_coupons_header'>Payment Details</h3>
                        <div class="row m-auto w-100" >

                            <div class="col-lg-12 mb-20  required">
                                <label>Name on Card <span>*</span></label>
                                <input
                                    class='form-control' size='4' type='text' placeholder='Enter Name on Card'>
                            </div>
                            <div class="col-lg-12 mb-20 card required" style="border: none">
                                <label>Card Number  <span>*</span></label>
                                <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text' placeholder='Enter Card Number'>
                            </div>
                            <div class="col-4 mb-20 cvc required">
                                <label>CVC</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'
                                type='text'>
                            </div>


                            <div class="col-4 mb-20 expiration required">
                                <label>Expiration Month  <span>*</span></label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>

                            <div class="col-4 mb-20 expiration required">
                                <label>Expiration Year <span>*</span></label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                            {{-- <div class="col-4 mb-20">
                                <button class="btn btn-danger btn-lg btn-block" type="submit"></button>
                            </div> --}}

                        </div>

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
                           {{-- <div class="panel-default">
                                <input id="payment" name="check_method" type="radio" data-target="createp_account" />
                                <label for="payment" data-toggle="collapse" data-target="#method" aria-controls="method">Create an account?</label>

                                <div id="method" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                       <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                    </div>
                                </div>
                            </div>  --}}
                           {{-- <div class="panel-default">
                                <input id="payment_defult" name="check_method" type="radio" data-target="createp_account" />
                                <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">PayPal <img src="assets/img/icon/papyel.png" alt=""></label>

                                <div id="collapsedefult" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                       <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="order_button">
                                <button  type="submit">Pay Now ${{number_format((float)$total_price, 2, '.', '')}}</button>
                            </div>
                        </div>
                    {{-- </form>          --}}
                </div>


            </div>
        </form>

    </div><br><br>
    <div class='main_parent_div border col-lg-8 col-sm-12 m-auto px-0'>
        <h3 class='sections_coupons_header like_products_heading p-2' >Products You may like</h3>
        <div class='p-3 d-flex products_inner'>
            @foreach ($suggested_products as $p)
            <div class='more_products ml-2 py-2 px-4'>
                <a href="{{ route('product-detail',$p->sku) }}">
                <img src="{{$p->original_image_url}}" class='more_products_img'  alt="">
                </a>
                <div class='products_title'>
                    <h5><a href="{{ route('product-detail',$p->sku) }}">{{ Str::limit($p->title, 20) }}</a></h5>
                </div>
            </div>
            @endforeach


        </div>
    </div>
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
