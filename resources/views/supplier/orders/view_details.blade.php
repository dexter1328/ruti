@extends('supplier.layout.main')

@section('content')


{{-- Order details start --}}

<div class="i_body_details pb-5">
    <div class="pt-4 mx-0 mx-lg-5">
        <h4 class="i_details_heading text-dark mx-5">Order No: <span>#245678</span></h4>
        <div class="i_first_section">
            <div class="i_my_container mx-5 p-3">
                <table class="w-100">
                    <tr class="border-bottom">
                        <th class="py-2">Items Summary</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">QTY</th>
                        <th class="py-2">Total Price</th>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2"><img src="https://cdn.dxomark.com/wp-content/uploads/medias/post-61584/iphone-12-pro-max-graphite-hero.jpg" width="60px" height="50px" alt=""> Iphone 12 Pro Max</td>
                        <td class="py-2">$999</td>
                        <td class="py-2">x2</td>
                        <td class="py-2">$1998</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2"><img src="https://cdn.dxomark.com/wp-content/uploads/medias/post-61584/iphone-12-pro-max-graphite-hero.jpg" width="60px" height="50px" alt="">Iphone 12 Pro Max</td>
                        <td class="py-2">$999</td>
                        <td class="py-2">x2</td>
                        <td class="py-2">$1998</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2"><img src="https://cdn.dxomark.com/wp-content/uploads/medias/post-61584/iphone-12-pro-max-graphite-hero.jpg" width="60px" height="50px" alt="">Iphone 12 Pro Max</td>
                        <td class="py-2">$999</td>
                        <td class="py-2">x2</td>
                        <td class="py-2">$1998</td>
                    </tr>
                </table>
            </div>
            <div class="i_my_container2 mx-5 mx-lg-0 p-3">
                <table class="w-100">
                    <tr class="border-bottom">
                        <th class="py-2">Shipping Details</th>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Shipping Address</td>
                        <td class="py-2 text-end">New Street No 1, Central Area, Germany</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Shipping Status</td>
                        <td class="py-2 text-end">Delivered</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Status of Process</td>
                        <td class="py-2 text-end">Received</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Payment</td>
                        <td class="py-2 text-end">$999</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Payment Process</td>
                        <td class="py-2 text-end">Cash on Delivery</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="i_my_container mx-5 mt-5 p-3">
            <table class="w-100">
                <tr class="border-bottom" class="border-bottom">
                    <th class="py-2">Customer And Order Details</th>
                </tr>
                <tr class="border-bottom">
                    <td class="py-2">Supplier Name</td>
                    <td class="py-2 text-end">John Smith</td>
                </tr>
                <tr class="border-bottom">
                    <td class="py-2">Customer Name</td>
                    <td class="py-2 text-end">John Smith</td>
                </tr>
                <tr class="border-bottom">
                    <td class="py-2">Phone Number</td>
                    <td class="py-2 text-end">1234567890</td>
                </tr>
                <tr class="border-bottom">
                    <td class="py-2">Fulfillment Type</td>
                    <td class="py-2 text-end">Seller Fulfill</td>
                </tr>
                <tr class="border-bottom">
                    <td class="py-2">Note</td>
                    <td class="py-2 text-end">N/A</td>
                </tr>
            </table>
        </div>
    </div>
    </div>

{{--  Order details end --}}


@endsection
