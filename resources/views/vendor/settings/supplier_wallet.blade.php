@extends('vendor.layout.main')
@section('content')

{{-- add funds start --}}

<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_add">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                    <h4 class="i_funds_heading border-bottom mb-3 pb-4 p-2">Add Funds</h4>
                    <div class="i_balance_div justify-content-between">
                        <h4 class="i_funds_heading mb-3 p-2">Your Balance: </h4>
                        <h4 class="i_funds_heading mb-3 p-2">${{$supplier->wallet_amount}} </h4>
                    </div>
                    {{-- <h5 class="i_text_color">Choose an Amount:</h5>
                    <div class="i_price_div justify-content-around">
                        <div onclick={priceCheck()} class="p-1 rounded price_option1 col-1 text-center checked_price">$100</div>
                        <div onclick={priceCheck()} class="p-1 rounded price_option2 col-1 text-center">$300</div>
                        <div onclick={priceCheck()} class="p-1 rounded price_option3 col-1 text-center">$500</div>
                        <div onclick={priceCheck()} class="p-1 rounded price_option4 col-1 text-center">$1000</div>
                        <div onclick={priceCheck()} class="p-1 rounded price_option5 col-1 text-center"> $ _ _ _ </div>
                    </div> --}}
                    <h5 class="i_text_color my-3">Card Details:</h5>
                    <div>
                        <form role="form"
                                action="{{ route('add-to-vendor-wallet') }}"
                                method="post"
                                class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{$stripe_key}}"
                                id="payment-form">
                                @csrf
                                {{-- <input autocomplete='off' class='form-control' size='20' name="amount" type='hidden' id="amount_input" placeholder='Enter Amount' value="24"> --}}

                            <div class="col-lg-12 mb-3">
                                <label>Name on Card<span class="text-danger">*</span></label>
                                <input class='form-control' size='4' type='text' placeholder='Enter Name on Card'>
                            </div>
                            <div class="col-lg-12 mb-3" style="border: none">
                                <label>Card Number<span class="text-danger">*</span>
                                    <p class="text-secondary subText">Enter the 16 digit number on the card</p>
                                </label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='number' placeholder='Enter Card Number'>
                            </div>
                            <div class="row mb-3">
                                <label class="col-lg-6 col-sm-12">
                                    CVC
                                    <p class="text-secondary subText">Enter 3 or 4 digit number on card</p>
                                </label>
                                <div class="col-lg-6 col-sm-12 mb-md-0 mb-2 mt-3">
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' maxlength="4" size='4'type='number'>
                                </div>
                                <label class="col-lg-6 col-sm-12 m-auto">Expiration Date<span class="text-danger">*</span>
                                    <p class="text-secondary subText">Enter the expiration date on the card</p>
                                </label>
                                <div class="col-lg-6 col-sm-12 mt-3 d-flex">
                                    <input class='form-control card-expiry-month me-5' placeholder='MM' pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" type='number'>
                                    <input class='form-control card-expiry-year' placeholder='YYYY'  pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" type='number'>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-4">Amount (USD)<span class="text-danger">*</span></label>
                                <div class="col-lg-8 mb-5" style="border: none">
                                    <input autocomplete='off' class='form-control' size='20' name="amount" type='number' id="amount_input" placeholder='Enter Amount'>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 i_buttons">
                                    <button class="btn custom_button w-100" type="submit">Submit</button>
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



    <script type="text/javascript">
        var price_option1 = document.querySelector('.price_option1').classList
        var price_option2 = document.querySelector('.price_option2').classList
        var price_option3 = document.querySelector('.price_option3').classList
        var price_option4 = document.querySelector('.price_option4').classList
        var price_option5 = document.querySelector('.price_option5').classList
        var amount_input = document.querySelector('#amount_input')
        function priceCheck() {
            price_option1.remove('checked_price')
            price_option2.remove('checked_price')
            price_option3.remove('checked_price')
            price_option4.remove('checked_price')
            price_option5.remove('checked_price')
            event.target.classList.add('checked_price')
            addAmount()
        }
        function addAmount() {
            if(price_option1.contains("checked_price")){
                amount_input.value = 100
                amount_input.disabled = true
            }
            else if(price_option2.contains("checked_price")){
                amount_input.value = 300
                amount_input.disabled = true
            }
            else if(price_option3.contains("checked_price")){
                amount_input.value = 500
                amount_input.disabled = true
            }
            else if(price_option4.contains("checked_price")){
                amount_input.value = 1000
                amount_input.disabled = true
            }
            else if(price_option5.contains("checked_price")){
                amount_input.value =
                amount_input.disabled = false
            }
        }
    </script>

{{-- add funds end --}}


@endsection
