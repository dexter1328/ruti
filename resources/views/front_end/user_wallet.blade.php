
<div class="tab-pane fade show active" id="wallet">
    @if(session('success'))
            <div class="container alert alert-success text-center" id="ordd">
            {{ session('success') }}
            </div>
            @endif
<div class="row justify-content-center">
    <div class="col-md-10">
      <span class="anchor" id="formPayment"></span>

      <!-- form card cc payment -->
      <div class="card card-outline-secondary">
        <div class="card-body">
            <h3 class="text-left">Your Balance <span><h3 class="text-right" style="margin-top: -30px;">${{$user->wallet_amount}}</h3></span></h3>
          <hr>
          <h3 class="text-center">Add more fund to wallet</h3>
          <hr>
          {{-- <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="#">×</a>CVC code is required.
          </div> --}}
          <form
                role="form"
                action="{{ route('add-to-wallet') }}"
                method="post"
                class="require-validation"
                data-cc-on-file="false"
                data-stripe-publishable-key="pk_test_51IarbDGIhb5eK2lSKrWKttm9gweug3yv8EqP2PoVRAhD6HWsuviQWzKOszgIf7imZZ5sjUXHdQhF759Khm3J3nYF00Ved0Wutj"
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
                <div class="col-lg-12 mb-20 card required" style="border: none">
                    <label>Amount (USD)  <span>*</span></label>
                    <input autocomplete='off' class='form-control' size='20' name="amount" type='number' placeholder='Enter Amount'>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <button class="btn btn-default btn-lg btn-block" type="reset">Cancel</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success btn-lg btn-block" type="submit">Submit</button>
                    </div>
                    </div>
            </div>
        </form>

        </div>
      </div><!-- /form card cc payment -->
    </div>
  </div>
</div>
