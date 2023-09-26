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
                            <h3>Order Invoice</h3>
                            <h5><a href="{{route('user-account-page')}}" style="color:#E96725">Back To Orders</a></h5>
                            <div class="main_page_body_ri w-100 p-2 justify-content-center">
                                <div class="product_detail_ri col-lg-12 col-xs-12 pl-0 d-flex align-items-center mx-auto">
                                    <img src="{{$product->original_image_url}}" width="100px" height="100px" alt="{{ Str::limit($product->title, 35) }}">
                                    <div class="ml-4"> {{$product->title}}</div>
                                </div>
                                <form method="post" action="{{ route('return-item-submit') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_sku" value="{{$sku}}">
                                    <input type="hidden" name="order_id" value="{{$orderId}}">
                                    <input type="hidden" name="user_id" value="{{$userId}}">
                                    <input type="hidden" name="vendor_id" value="{{$vendorId}}">

                                <div class="mt-4 p-3 product_detail_ri col-lg-12 col-xs-12 mx-auto">
                                    <h5 class="text-center">Why are you returning this?</h5>
                                    <table border="1" class="reason_table_ri mx-auto">
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Received an extra item, I didn't buy (no refund needed)">
                                                Received an extra item, I didn't buy (no refund needed)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Item arrived too late">
                                                Item arrived too late
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Didn't approve purchase">
                                                Didn't approve purchase
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Bought by mistake">
                                                Bought by mistake
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="No longer needed">
                                                No longer needed
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Better price available">
                                                Better price available
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Product damaged, but shipping box OK">
                                                Product damaged, but shipping box OK
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Wrong item was sent">
                                                Wrong item was sent
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Item defective or doesn't work">
                                                Item defective or doesn't work
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Product and shipping box both damaged">
                                                Product and shipping box both damaged
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Inaccurate website Description">
                                                Inaccurate website Description
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">
                                                <input type="radio" name="reason" id="" value="Missing or broken parts">
                                                Missing or broken parts
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="py-3">
                                        <h4 class="text-center">Steps That We Can Take?</h4>
                                        <div class="colored-box-ri rounded p-3 mx-auto mb-4">
                                            <div>Return Only</div>
                                            <div>Thank You for taking the time for returning extra items.</div>
                                            <div>No refund will be issued for this item because you weren't </div>
                                        </div>
                                    </div>
                                    <div class="px-4">
                                        <label>Comments:</label>
                                        <br>
                                        <textarea required class="comments_text_ri p-2" placeholder="Provide more details" name="comment"></textarea>
                                    </div>
                                    {{-- <div class="px-4 py-3">
                                        <a href="">Add more items to be return</a>
                                    </div> --}}
                                    <div class="text-center mb-3">
                                        <button class="btn btn-warning continue_btn_ri mx-auto" type="submit">Continue</button>
                                        {{-- <div>Return by Apr 11, 2023</div> --}}
                                    </div>

                                    <div>
                                        <p><b>Note:</b> We aren't able to offer policy exeptions in response to comments,  Do not include personal information as these comments
                                        may be shared with external service providers to identify product defects.</p>
                                    </div>
                                </div>
                            </form>

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


@section('scriptss')


@endsection
