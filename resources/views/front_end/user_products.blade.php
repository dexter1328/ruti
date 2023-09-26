@extends('front_end.layout')
@section('content')


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>My Account</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- my account start  -->
<section class="main_content_area">
    <div class="container">
        <div class="account_dashboard">
            <div class="row">
                {{-- <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>

                        </ul>
                    </div>
                </div> --}}
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div class="tab-pane fade" id="dashboard">
                            <h3>Hello {{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}} </h3>
                            <p>Click On Orders to check your orders</p>
                        </div>
                        <div class="tab-pane fade show active" id="orders">
                            <h3>Products</h3>
                            <h5><a href="{{route('user-account-page')}}" style="color:#E96725">Back To Orders</a></h5>
                            <div class="table-responsive">

        @foreach ($ordered_products as $order)

        <div class="col-12 order_main px-0 border">

                    <div class="orders_body p-3">
                        {{-- <div class='text-success font-weight-bold'>Arriving Soon</div> --}}
                        <div>{{ ucfirst(trans($order->status)) }}</div>
                        <div class='w-100 order_tab d-flex mt-4'>
                            <div class='w-50 d-flex main_order'>
                                <div class='product_width d-flex'>
                                    <img src="{{$order->image}}" class='table_product_image ml-4' alt="{{ Str::limit($order->title, 35) }}">
                                </div>
                                <div class='px-2 product_title_width image_title'>
                                    <span>{{ Str::limit($order->title, 70) }} </span>
                                    <br>
                                    <button type="button" onclick="window.location='{{ route('product-detail',['slug' => $order->slug, 'sku' => $order->sku]) }}'" class='border buy_again'>Buy it again</button>
                                </div>
                            </div>
                            <div class='main_button w-50'>
                                {{-- <button class='order_details_button border boder-rounded yellow_btn'>Track Package</button> --}}
                                <button
                                    type="button"
                                    class="mt-1 order_details_button border boder-rounded tracking-info-button"
                                    data-toggle="modal"
                                    data-target="#exampleModalCenter"
                                    data-tracking-number="{{$order->tracking_no ? $order->tracking_no : 'Not assigned yet'}}"
                                    data-tracking-url="{{$order->tracking_link ? $order->tracking_link : 'Not assigned yet'}}"
                                >
                                    Tracking Information
                                </button>
                                <button type="button" onclick="window.location='{{ route('gift-receipt',$order->order_id) }}'" class='mt-1 order_details_button border boder-rounded'>Share gift receipt</button>
                                <button class='mt-1 order_details_button border boder-rounded' onclick="window.location='{{ route('return-item', ['sku' => $order->sku, 'order_id' => $order->order_id, 'user_id' => $order->p_user_id, 'vendor_id' => $order->vendor_id]) }}'">Return or Replace Items</button>
                                <button type="button" onclick="window.location='{{ route('product-detail',['slug' => $order->slug, 'sku' => $order->sku]) }}#reviews'" class='mt-1 order_details_button border boder-rounded'>Write a product review</button>
                                {{-- <button type="button" onclick="reviewFunction()" class='mt-1 order_details_button border boder-rounded'>Write a product review</button> --}}
                            </div>
                        </div>

        </div>

    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Tracking Information</h3>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <th class="p-2"><h4>Tracking Number: </h4></th>
                            <td class="p-2"><h4 id="tracking-number"></h4></td>
                        </tr>
                        <tr>
                            <th class="p-2"><h4>Tracking Url: </h4></th>
                            <td class="p-2"><h4 class="text-primary text-lowercase" id="tracking-url"></h4></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary cart_btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        <!-- my account end   -->


    @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->


@endsection


@section('scriptss')

<script>
    $(document).ready(function() {
        $('.tracking-info-button').click(function() {
            var trackingNumber = $(this).data('tracking-number');
            var trackingUrl = $(this).data('tracking-url');

            $('#tracking-number').text(trackingNumber);
            $('#tracking-url').html('<a href="' + trackingUrl + '">' + trackingUrl + '</a>');
        });
    });
</script>

@endsection
