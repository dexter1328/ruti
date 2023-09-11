@extends('supplier.layout.main')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
{{-- Order details start --}}

<div class="i_body_details pb-5">

    <div class="pt-4 mx-0 mx-lg-5">

        <h4 class="i_details_heading text-dark mb-3 text-center">Order No: <span>#{{$order1->order_id}}</span></h4>


        <div class="i_my_container p-3">
            <table class="w-100">
                    <tr class="border-bottom">
                        <th class="py-2">Image</th>
                        <th class="py-2">Sku</th>
                        <th class="py-2">Title</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">QTY</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Tracking No</th>
                    </tr>
                    <tr class="border-bottom">
                        @foreach ($od as $o)

                        <td class="py-2"><img src="{{$o->image}}" width="60px" height="50px" alt="{{ Str::limit($o->title, 35) }}"></td>
                        <td class="py-2">{{$o->sku}}</td>
                        <td class="py-2">{{$o->title}}</td>
                        <td class="py-2">${{$o->price}}</td>
                        <td class="py-2">x{{$o->quantity}}</td>
                        <td class="py-2">${{$o->total_price}}</td>
                        @if ($o->tracking_no)
                            <td class="py-2">{{$o->tracking_no}}</td>
                        @else
                        <td><a href="{{route('supplier.orders.shipping_details',['orderId' => $o->order_id, 'productSku' => $o->sku])}}" class="btn btn-info btn-sm">Add Tracking Detail</a></td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        <div class="i_first_section">
            <div class="i_my_container mr-3 mt-3 p-3">
                <table class="w-100">
                    <tr class="border-bottom">
                        <th class="py-2">Shipping Details</th>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Customer Name:</td>
                        <td class="py-2 text-end">{{$order1->user_fname}} {{$order1->user_lname}}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Shipping Address:</td>
                        <td class="py-2 text-end">{{$order1->user_address}}, {{$order1->city_name}}, {{$order1->state_name}}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Shipping Status:</td>
                        <td class="py-2 text-end">Processing</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Status of Process</td>
                        <td class="py-2 text-end">Processing</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Payment</td>
                        <td class="py-2 text-end">${{$grand_total}}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Payment Process</td>
                        <td class="py-2 text-end">Cash on Delivery</td>
                    </tr>
                </table>
            </div>
            <div class="i_my_container p-3 mt-3">
                <table class="w-100">
                    <tr class="border-bottom" class="border-bottom">
                        <th class="py-2">Customer And Order Details</th>
                    </tr>

                    <tr class="border-bottom">
                        <td class="py-2">Customer Name</td>
                        <td class="py-2 text-end">{{$order1->user_fname}} {{$order1->user_lname}}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="py-2">Phone Number</td>
                        <td class="py-2 text-end">{{$order1->user_phone}}</td>
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
</div>

{{--  Order details end --}}


@endsection
