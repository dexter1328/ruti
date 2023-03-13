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
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                            {{-- <li><a href="#downloads" data-toggle="tab" class="nav-link">Downloads</a></li>
                            <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>
                            <li><a href="#account-details" data-toggle="tab" class="nav-link">Account details</a></li>
                            <li><a href="login.html" class="nav-link">logout</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div class="tab-pane fade" id="dashboard">
                            <h3>Hello {{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}} </h3>
                            <p>Click On Orders to check your orders</p>
                        </div>
                        <div class="tab-pane fade show active" id="orders">
                            <h3>Orders</h3>
                            <div class="table-responsive">
                                <!-- <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Order No</th>
                                            <th>Total</th>
                                            <th>Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
                                            <td><span class="success">{{$order->order_id}}</span></td>
                                            <td>{{$order->total_price}} </td>
                                            <td><a href="{{route('user-product-page',$order->order_id)}}" class="view">view</a></td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table> -->
        @foreach ($orders as $order)
        <div class="col-12 order_main px-0 border">
                    <div class='d-flex justify-content-between p-3 border orders_header'>
                        <div class='orders_header1 d-flex justify-content-between w-50'>
                            <div>
                                #{{$loop->iteration}}
                                {{-- <span class='d-block'>{{$loop->iteration}}</span> --}}
                            </div>
                            <div>
                                Order Placed
                                <span class='d-block'>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</span>
                            </div>
                            <div>
                                Total
                                <span class='d-block'>${{$order->total_price}}</span>
                            </div>
                            {{-- <div>
                                Ship To
                                <span class='d-block text-primary'>{{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}}</span>
                            </div> --}}
                            <div>
                                Status
                                <span class='d-block text-primary'>{{$order->status}}</span>
                            </div>
                        </div>
                        <div class="orders_header2">
                            <div>
                                Order# <span>{{$order->order_id}}</span>
                            </div>
                            <div>
                                <span><a href="{{route('user-product-page',$order->order_id)}}" class='text-primary'>View order details</a> | <a class='text-primary'>View Invoice</a></span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="orders_body p-3">
                        <div class='text-success font-weight-bold'>Arriving today by 10 PM</div>
                        <div>Shipped</div>
                        <div class='w-100 order_tab d-flex mt-4'>
                            <div class='w-50 d-flex main_order'>
                                <div class='d-flex'>
                                    <img src="" class='table_product_image ml-4' alt="">
                                </div>
                                <div class='px-2  image_title'>
                                    <span>This is the name of product </span>
                                    <br>
                                    <button class='border buy_again'>Buy it again</button>
                                </div>
                            </div>
                            <div class='main_button w-50'>
                                <button class='order_details_button border boder-rounded yellow_btn'>Track Package</button>
                                <button class='mt-1 order_details_button border boder-rounded'>Share gift receipt</button>
                                <button class='mt-1 order_details_button border boder-rounded'>Return or Replace Items</button>
                                <button class='mt-1 order_details_button border boder-rounded'>Write a product review</button>
                            </div>
                        </div> --}}

        </div>

    </div>
    @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->


@endsection
