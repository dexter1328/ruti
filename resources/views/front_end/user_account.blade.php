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
                                <div class="col-12 order_main px-0 border">
        <div class='d-flex justify-content-between p-3 border orders_header'>
            <div class='orders_header1 d-flex justify-content-between w-50'>
                <div>
                    Order Placed
                    <span class='d-block'>January 30, 2023</span>
                </div>
                <div>
                    Total
                    <span class='d-block'>$10.83</span>
                </div>
                <div>
                    Ship To
                    <span class='d-block text-primary'>Joseph Larnyoh</span>
                </div>
            </div>
            <div class="orders_header2">
                <div>
                    Order# <span>134-1519088326428736</span>
                </div>
                <div>
                    <span><a class='text-primary'>View order details</a> | <a class='text-primary'>View Invoice</a></span>
                </div>
            </div>
        </div>
        <div class="orders_body p-3">
            <div class='text-success font-weight-bold'>Arriving today by 10 PM</div>
            <div>Shipped</div>
            <div class='w-100 order_tab d-flex mt-4'>
                <div class='w-50 d-flex main_order'>
                    <div class='d-flex'>
                        <a role="button" class="remove-from-cart align-self-center"><i class="fa fa-trash-o"></i></a>
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
            </div>
            <div class='w-100 order_tab d-flex mt-4'>
                <div class='w-50 d-flex main_order'>
                    <div class='d-flex'>
                        <a role="button" class="remove-from-cart align-self-center"><i class="fa fa-trash-o"></i></a>
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
            </div>
            <div class='w-100 order_tab d-flex mt-4'>
                <div class='w-50 d-flex main_order'>
                    <div class='d-flex'>
                        <a role="button" class="remove-from-cart align-self-center"><i class="fa fa-trash-o"></i></a>
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
            </div>
        </div>
        <div class="orders_footer border-top text-right">
        <a class='text-danger pr-3' href="">Remove Everything</a>
        </div>
    </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="downloads">
                            <h3>Downloads</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Downloads</th>
                                            <th>Expires</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Shopnovilla - Free Real Estate PSD Template</td>
                                            <td>May 10, 2018</td>
                                            <td><span class="danger">Expired</span></td>
                                            <td><a href="#" class="view">Click Here To Download Your File</a></td>
                                        </tr>
                                        <tr>
                                            <td>Organic - ecommerce html template</td>
                                            <td>Sep 11, 2018</td>
                                            <td>Never</td>
                                            <td><a href="#" class="view">Click Here To Download Your File</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                           <p>The following addresses will be used on the checkout page by default.</p>
                            <h4 class="billing-address">Billing address</h4>
                            <a href="#" class="view">Edit</a>
                            <p><strong>Bobby Jackson</strong></p>
                            <address>
                                House #15<br>
                                Road #1<br>
                                Block #C <br>
                                Banasree <br>
                                Dhaka <br>
                                1212
                            </address>
                            <p>Bangladesh</p>
                        </div>
                        <div class="tab-pane fade" id="account-details">
                            <h3>Account details </h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="#">
                                            <p>Already have an account? <a href="#">Log in instead!</a></p>
                                            <div class="input-radio">
                                                <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mr.</span>
                                                <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mrs.</span>
                                            </div> <br>
                                            <label>First Name</label>
                                            <input type="text" name="first-name">
                                            <label>Last Name</label>
                                            <input type="text" name="last-name">
                                            <label>Email</label>
                                            <input type="text" name="email-name">
                                            <label>Password</label>
                                            <input type="password" name="user-password">
                                            <label>Birthdate</label>
                                            <input type="text" placeholder="MM/DD/YYYY" value="" name="birthday">
                                            <span class="example">
                                              (E.g.: 05/31/1970)
                                            </span>
                                            <br>
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="1" name="optin">
                                                <label>Receive offers from our partners</label>
                                            </span>
                                            <br>
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="1" name="newsletter">
                                                <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>
                                            </span>
                                            <div class="save_button primary_btn default_button">
                                               <button type="submit">Save</button>
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
