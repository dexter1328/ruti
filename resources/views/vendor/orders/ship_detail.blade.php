@extends('supplier.layout.main')
@section('content')

<div class="i_body_details pb-5">
    <div class="pt-4 mx-0 mx-lg-5">
        <h4 class="i_details_heading text-dark mb-3 text-center">Shipping Details</h4>
        <div class="i_my_container2 detail_ship mx-auto p-4">
            <form class="ship_details_form text-center" method="post" action="{{route('vendor.orders.post_shipping_details',['orderId' => $orderId, 'productSku' => $productSku])}}">
                @csrf
                <h4 class="i_details_heading h4 text-dark mb-3 text-center">Order No: <span>#{{ $orderId }}</span></h4>
                <h4 class="i_details_heading h4 text-dark mb-4 text-center">Product SKU: <span>{{ $productSku }}</span></h4>
                <div class="mb-3 text-left">
                    <label for="">Tracking Number:</label>
                    <input type="text" name="tracking_no">
                    @if ($errors->has('tracking_no'))
                        <label class="error">{{ $errors->first('tracking_no') }}</label>
                    @endif
                </div>
                <div class="mb-3 text-left">
                    <label for="">Tracking Link(URL):</label>
                    <input type="text" name="tracking_link">
                    @if ($errors->has('tracking_link'))
                        <label class="error">{{ $errors->first('tracking_link') }}</label>
                    @endif
                </div>
                <button class="btn button_color mx-auto" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
