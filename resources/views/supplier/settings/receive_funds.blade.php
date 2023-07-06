@extends('supplier.layout.main')
@section('content')

{{-- receive funds start --}}

<div class="i_funds_body py-5 d-flex justify-content-center">
    <div class="container_receive">
        <div class="inner-container">
            <div class="mx-auto">
                <div class="main_section p-4 mb-4">
                    <h4 class="i_funds_heading border-bottom mb-3 pb-4 p-2">Receive Funds</h4>
                    <div class="i_balance_div justify-content-between">
                        <h4 class="i_funds_heading mb-3 p-2">Your Balance: </h4>
                        <h4 class="i_funds_heading mb-3 p-2">${{$supplier->wallet_amount}} </h4>
                    </div>
                    <div>
                        <table class="w-100">
                            <tr class="border-bottom" class="border-bottom">
                                <th class="py-2">Received Funds</th>
                                <th class="py-2 text-center">Date</th>
                                <th class="py-2 text-center">Amount</th>
                            </tr>
                            <tr class="border-bottom">
                                <td class="py-2">John Smith</td>
                                <td class="py-2 text-center">23/6/23</td>
                                <td class="py=2 text-center">$500</td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="py-2">John Smith</td>
                                <td class="py-2 text-center">11/4/22</td>
                                <td class="py=2 text-center">$7700</td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="py-2">John Smith</td>
                                <td class="py-2 text-center">15/2/23</td>
                                <td class="py=2 text-center">$4700</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

{{-- receive funds end --}}


@endsection
