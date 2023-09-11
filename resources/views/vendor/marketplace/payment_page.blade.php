@extends('vendor.layout.main')
@section('content')

    <div class="mx-auto marketplace_payment">
        <div class="row w-100">
            <div class="p-3 mx-4 col-md-4 col-lg-4 col-sm-12">
                <h4 class="i_text_color">Order Details: </h4>
                <table class="w-100" border=1>
                <thead class='no_bg'>
                                    <tr>
                                        <th class="p-3">Product</th>
                                        <th class="p-3">Price</th>
                                        <th class="p-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php $total = 0 @endphp

                                    @if(session('cart'))
                                    @foreach(session('cart') as $sku => $details)
                                    @php $total += $details['retail_price'] * $details['quantity'] @endphp
                                    @php $tax = ($details['sales_tax_pct'] / 100) * $total @endphp
                                    @php $total_price = $total + $details['shipping_price'] + $tax @endphp --}}
                                    @php
                                        $subtotal = 0; // Initialize the subtotal variable
                                    @endphp
                                    @foreach ($productDetails as $pd)
                                    <tr>
                                        <td class="p-3"><a> {{ $pd['title'] }} </a><strong> × {{ $pd['quantity'] }}</strong></td>
                                        <td class="p-3"> ${{ $pd['price'] }}</td>
                                        <td class="p-3"> ${{ $pd['total_price'] }}</td>
                                    </tr>
                                    @php
                                        $subtotal += $pd['total_price']; // Add the total price to the subtotal
                                    @endphp
                                    @endforeach

                                    {{-- @endforeach
                                    @endif --}}
                                </tbody>
                                <tfoot>

                                    <tr class="order_total">
                                        <th class="p-3">Order Total</th>
                                        <th class="p-3"></th>
                                        <td class="p-3"><strong>${{ $subtotal }}</strong></td>
                                    </tr>
                                </tfoot>
                </table>
            </div>
            <div class="p-3 mx-4 col-md-6 col-lg-6 col-sm-12">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <h4 class="i_text_color">Payment Options: </h4>
                <div class="accordion w-100" id="faq">
                    <div class="card mx-auto">
                        <div class="card-header" id="faqhead1">
                            <a href="#" class="btn btn-header-link text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq1"
                            aria-expanded="true" aria-controls="faq1">Pay with Card</a>
                        </div>

                        <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="card-body">
                                <div class="col-lg-12 mb-4  required">
                                    <form
                                        role="form"
                                        action="{{ route('marketplace-store-payment') }}"
                                        method="post"
                                        class="require-validation"
                                        data-cc-on-file="false"
                                        data-stripe-publishable-key="{{$stripe_key}}"
                                        id="payment-form">
                                        @csrf
                                      <label>Name on Card <span>*</span></label>
                                      <input class='form-control' size='4' type='text' placeholder='Enter Name on Card'>
                                      </div>
                                      <div class="col-lg-12 mb-4 required" style="border: none">
                                          <label>Card Number  <span>*</span></label>
                                          <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='Enter Card Number'>
                                      </div>
                                      <div class="row">
                                          <div class="col-4 mb-4 cvc required">
                                              <label>CVC</label>
                                              <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'type='text'>
                                          </div>
                                          <div class="col-4 mb-4 expiration required">
                                              <label>Expiration Month  <span>*</span></label>
                                              <input class='form-control card-expiry-month' placeholder='MM' size='2'type='text'>
                                          </div>
                                          <div class="col-4 mb-4 expiration required">
                                              <label>Expiration Year <span>*</span></label>
                                              <input class='form-control card-expiry-year' placeholder='YYYY' size='4'type='text'>
                                          </div>
                                          <input type="hidden" name="total_price" value="{{ $subtotal }}">
                                      </div>
                                      <div class="mx-auto order_button i_buttons">
                                          <button class="btn custom-button w-100" type="submit">Pay Now</button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mx-auto">
                        <div class="card-header" id="faqhead2">
                            <a href="#" class="btn btn-header-link collapsed text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq2"
                            aria-expanded="true" aria-controls="faq2">Pay with Digital Wallet</a>
                        </div>

                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('marketplace-store-wallet-payment')}}">
                                @csrf

                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="my-4">
                                            <h4>Your Balance: <span>${{ Auth::user()->wallet_amount }}</span></h4>
                                            <h4>Order Total: <span>${{ $subtotal }}</span></h4>
                                            <input type="hidden" type="number" name="amount" value="{{ $subtotal }}">
                                        </div>
                                        @if (Auth::user()->wallet_amount < $subtotal)
                                        <div class="mx-auto i_buttons">
                                            <button class="btn custom-button w-100" type="submit" disabled>Not Enough Balance</button>
                                        </div>
                                        @else
                                        <div class="mx-auto i_buttons">
                                            <button class="btn custom-button w-100" type="submit">Click to pay</button>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('customJS')
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
