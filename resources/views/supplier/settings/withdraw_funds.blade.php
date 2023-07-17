@extends('supplier.layout.main')
@section('content')

{{-- withdraw funds start --}}

<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_withdraw">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                    <h4 class="i_funds_heading border-bottom mb-3 pb-4 p-2">Withdraw Funds</h4>
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
                    <div class="i_balance_div justify-content-between">
                        <h4 class="i_funds_heading mb-3 p-2">Your Balance: </h4>
                        <h4 class="i_funds_heading mb-3 p-2">${{$supplier->wallet_amount}} </h4>
                    </div>
                    <h5 class="i_text_color my-3">Bank Details:</h5>
                    <div>
                        <form action="{{ route('withdraw-to-bank') }}" method="post">
                            @csrf
                            <div class="col-lg-12 mb-3">
                                <label>Bank Name<span class="text-danger">*</span></label>
                                <input class='form-control' type='text' placeholder='Enter Account Title'>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label>Bank Account Name<span class="text-danger">*</span></label>
                                <input class='form-control' type='text' placeholder='Enter Account Title'>
                            </div>
                            <div class="col-lg-12 mb-3" style="border: none">
                                <label>Bank Routing Number<span class="text-danger">*</span>
                                </label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='number' placeholder='Enter Account Number'>
                            </div>
                            <div class="col-lg-12 mb-3" style="border: none">
                                <label>Account Number<span class="text-danger">*</span>
                                </label>
                                <input autocomplete='off' name="account_no" class='form-control card-number' size='20' type='number' placeholder='Enter Account Number'>
                            </div>
                            <div class="row">
                                <label class="col-4">Amount (USD)<span class="text-danger">*</span></label>
                                <div class="col-lg-8 mb-5" style="border: none">
                                    <input autocomplete='off' class='form-control' size='20' name="amount" type='number' id="amount_input" placeholder='Enter Amount'>
                                </div>
                            </div>
                            <div>
                                <h5 class="i_text_color mb-4 text-center">Are you sure you want to withdraw your funds?</h5>
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


{{-- withdraw funds end --}}


@endsection
