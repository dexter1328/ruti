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
                <div class="search-container">
                    <input type="text" class='search_bar' placeholder="Search...">
                    <div class="dropdown">
                        <button class="dropbtn">Filter</button>
                        <div class="dropdown-content-new">
                            <label class='border-top border-bottom'>Filter by Order Type</label>
                            <label><input type="radio" name="filter-option" value="option2">Orders</label>
                            <label><input type="radio" name="filter-option" value="option1">Not Yet Shipped</label>
                            <label><input type="radio" name="filter-option" value="option3">Digital Orders</label>
                            <label><input type="radio" name="filter-option" value="option4">Local Orders</label>
                            <label><input type="radio" name="filter-option" value="option4">Cancelled Orders</label>
                            <label class='border-top border-bottom'>Filter by Order Date</label>
                            <label><input type="radio" name="filter-option" value="option2">Last 30 days</label>
                            <label><input type="radio" name="filter-option" value="option1">Last 3 months</label>
                            <label><input type="radio" name="filter-option" value="option3">2023</label>
                            <label><input type="radio" name="filter-option" value="option4">2022</label>
                            <label><input type="radio" name="filter-option" value="option4">2019</label>
                        </div>
                    </div>
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
                                <table class="table">
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
                                            <td style="min-width:75px!important;">{{$loop->iteration}}</td>
                                            <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
                                            <td>
                                                <span class="success">{{$order->order_id}}</span>
                                                @if($order->status!=='processing')
                                                <span class="text-primary">{{ucfirst($order->status)}}</span>
                                                @else
                                                <span class="text-info">{{ucfirst($order->status)}}</span>
                                                <a href="{{route('user-cancel-w2b-order',$order->order_id)}}" onclick="return confirm('Are you sure to cancel the order?')">cancel</a>
                                                @endif
                                            </td>
                                            <td>{{$order->total_price}} </td>
                                            <td><a href="{{route('user-product-page',$order->order_id)}}" class="view">view</a></td>
                                        </tr>
                                        @endforeach
                                @foreach ($orders as $order)
                                <div class="col-12 order_main px-0 border">
                                    <div class='d-flex justify-content-between p-3 border orders_header'>
                                        <div class='orders_header1 d-flex justify-content-between w-75'>
                                            <div>
                                                #{{$loop->iteration}}
                                            </div>
                                            <div>
                                                Order Placed
                                                <span class='d-block'>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</span>
                                            </div>
                                            <div>
                                                Total
                                                <span class='d-block'>${{$order->total_price}}</span>
                                            </div>
                                            <div>
                                                Status
                                                <span class='d-block text-primary'>{{ucfirst(trans($order->status))}}</span>
                                            </div>
                                            <div>
                                                Order Duration:
                                                <span class='d-block'>4 days.</span>
                                            </div>
                                        </div>
                                        <div class="orders_header2 text-center">
                                            <div>
                                                Order# <span>{{$order->order_id}}</span>
                                            </div>
                                            <div>
                                                <span><a href="{{route('user-product-page',$order->order_id)}}" class='text-primary'>View order details</a> | <a href="{{route('order-invoice',$order->order_id)}}" class='text-primary'>View Invoice</a></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->


@endsection
