@extends('vendor.layout.main')
@section('content')

<!-- <div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_withdraw">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                <div class="d-flex justify-content-center w-100">
                  <img class='tick_pic' src="https://static.vecteezy.com/system/resources/previews/025/139/940/original/green-tick-icon-free-png.png" alt="image">
                </div>
                <h1 class="ty_heading text-center">Thank You!</h1>
                <div class="wrapper-2 text-center">
                    <p>Thanks for buying products.</p>
                    <p>you will receive email soon</p>
                    <button class="go-home">
                        <a href="#">
                        go back
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div> -->

    <div class="body_subscribtion d-flex justify-content-center">
    <div class="i_sub_container m-auto p-4">
        <h4>Order Details: </h4>
        <div class="inner-container w-100 justify-content-center d-flex my-4">
            <table class="w-100 ml-4">
                <tr>
                    <td class="ml-4">Quantity</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td class="ml-4">Products</td>
                    <td>Test</td>
                </tr>
                <tr>
                    <td class="ml-4">Price</td>
                    <td>$100</td>
                </tr>
                <tr>
                    <td class="ml-4">Total Price</td>
                    <td>$400</td>
                </tr>
            </table>
        </div>
        <h4>Payment Options: </h4>
        <div class="inner-container">
          <div class="row my-2 mx-0">
                <div class="accordion w-100" id="faq">
                    <div class="card w-75 mx-auto">
                        <div class="card-header" id="faqhead1">
                            <a href="#" class="btn btn-header-link text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq1"
                            aria-expanded="true" aria-controls="faq1">Pay with Card</a>
                        </div>

                        <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="card-body">
                                <div class="col-lg-12 mb-4  required">
                                    <form role="form"
                                    action=""
                                    method="post"
                                    class="require-validation"
                                    data-cc-on-file="false"
                                    id="payment-form">
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
                                      </div>
                                      <div class="mx-auto order_button i_buttons">
                                          <button class="btn custom-button w-100" type="submit">Pay Now</button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card w-75 mx-auto">
                        <div class="card-header" id="faqhead2">
                            <a href="#" class="btn btn-header-link collapsed text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq2"
                            aria-expanded="true" aria-controls="faq2">Pay with Digital Wallet</a>
                        </div>

                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="" >
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="my-4">
                                            <h4>Your Balance: <span></span></h4>
                                            <h4>Subscription fee: <span>$25</span></h4>
                                            <input type="hidden" name="amount" value="">
                                        </div>
                                        <div class="mx-auto i_buttons">
                                            <button class="btn custom-button w-100" type="submit">Click to Pay</button>
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
    </div>
@endsection
