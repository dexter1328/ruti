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
    <div class="mx-auto marketplace_payment">
        <div class="row w-100">
            <div class="p-3 mx-4 col-md-4 col-lg-4 col-sm-12">
                <h4 class="i_text_color">Order Details: </h4>
                <table class="w-100" border=1>
                <thead class='no_bg'>
                                    <tr>
                                        <th class="p-3">Product</th>
                                        <th class="p-3">Total</th>
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
                                        <td class="p-3"><a> {{ Str::limit($details['title'], 35) }} </a><strong> × {{$details['quantity']}}</strong></td>
                                        <td class="p-3"> ${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="p-3">Cart Subtotal</th>
                                        <td class="p-3">${{number_format((float)$total, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-3">Shipping</th>
                                        <td class="p-3"><strong>${{number_format((float)$details['shipping_price'], 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <th class="p-3">Sales Tax</th>
                                        <td class="p-3"><strong>${{number_format((float)$tax, 2, '.', '')}}</strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th class="p-3">Order Total</th>
                                        <td class="p-3"><strong>${{number_format((float)$total_price, 2, '.', '')}}</strong></td>
                                    </tr>
                                </tfoot>
                </table>
            </div>
            <div class="p-3 mx-4 col-md-6 col-lg-6 col-sm-12">
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
                    <div class="card mx-auto">
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
@endsection
