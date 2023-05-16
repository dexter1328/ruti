@extends('supplier.layout.main')
@section('content')

<h2>Nature checkout Fulfill Plan</h2>
<br>
@if ($supplier->fulfill_type == 'nature')
<h2>
    Your fulfillments are already done by nature checkout
    </h2>
    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('supplier_fulfill')}}" >
        {{ csrf_field() }}
    <div class="card-body">


        <input type="hidden" name="fulfill_type" value="self">
        <div class="form-group">
            <div class="col-lg-6 offset-2">
                <button type="submit" class="btn btn-primary">
                  change to Self Fulfill
                </button>
            </div>
        </div>
  </div>
</form>
@else
<h2>
subscribe for only $25
</h2>

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
<div class="row justify-content-between">


    <div class="col-lg-12 col-md-12 border main_parent_div p-0 mt-2">
        <div class='form-row row '>
            <div class='col-md-12 error form-group d-none'>
                <div class='alert-danger alert'>Please correct the errors and try
                    again.</div>
            </div>
        </div>


            <h3 class='sections_coupons_header'>Payment Details</h3>
            <div class="row m-auto w-100" >

            <div class="row m-auto w-100" style="display:contents">
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
                                        action="{{ route('ruti-fullfill-submit') }}"
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
                            {{-- <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed w-100" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class='text-dark d-flex justify-content-between payspan'>Pay with PayPal <span><i class='fa fa-chevron-down'></i></span></span>
                                </button>
                            </h5>

                            </div> --}}

                        {{-- <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('paypal-payment')}}" >
                                {{ csrf_field() }}
                            <div class="card-body">
                                @php
                                    $op = session('w2border')
                                @endphp
                                @php
                                    $tp = 25

                                @endphp
                                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <div class="col-md-6">
                                        <span class="input-group-text usd-ico" style="width: 35px; position: absolute; top: 0px; left: -4px; height: 40px;"><i class="fa fa-usd"></i></span>
                                        <input  type="hidden" class="form-control" name="amount" value="{{$tp}}"  />
                                        <input disabled="disabled"  type="number" class="form-control"  value="{{$tp}}"  />
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

                        </div> --}}
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed w-100" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class='text-dark d-flex justify-content-between payspan'>Pay with Digital Wallet <span><i class='fa fa-chevron-down'></i></span></span>
                                </button>
                            </h5>

                            </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">

                            @php
                                    $op = session('w2border')
                                @endphp
                                @php
                                    $tp = 25

                                @endphp
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('supplier-wallet-payment', $tp)}}" >
                                {{ csrf_field() }}
                            <div class="card-body">


                                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                    {{-- <label for="amount" class="col-md-4 control-label">Pay ${{$tp}}</label> --}}
                                    <h3>Your Balance : ${{Auth::user()->wallet_amount}}</h3>
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


                        </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </form>



    </div>
</div>
@endif

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
