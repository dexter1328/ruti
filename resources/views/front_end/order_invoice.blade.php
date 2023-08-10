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
                        @include('front_end.user_dashboard')
                        <div class="tab-pane fade show active" id="orders">
                            <h3>Order Invoice</h3>
                            <h5><a href="{{route('user-account-page')}}" style="color:#E96725">Back To Orders</a></h5>
                            <h5 class="text-center" ><a class="btn btn-secondary-orange btn-sm" id="pprint1" style="color:white; font-size: 11px; padding: 10px 15px;">Print Invoice</a></h5>
                            <div class="container nature-body" id="pprintarea">
                                <div class="row">

                                                    <div class="col-xs-12">
                                                        <div class="nature-grid nature-invoice">
                                                            <div class="nature-grid-body">
                                                                <div class="nature-invoice-title">

                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <h2><img src="{{asset('public/wb/img/logo/logo3.png')}}" alt="Nature Checkout" width="8%"> Nature Checkout Invoice<br>
                                                                            <span class="small">order #{{$order->order_id}}</span></h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                        <address>
                                                                            <strong>Billed To:</strong><br>
                                                                            {{$order->fname}} {{$order->lname}}.<br>
                                                                            {{$order->address}}<br>
                                                                            {{$order->city_name}}, {{$order->state_name}} {{$order->zip_code}}<br>
                                                                            <abbr title="Phone">P:</abbr> {{$order->mobile}}
                                                                        </address>
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 float-right">
                                                                        <address>
                                                                            <strong>Billed To:</strong><br>
                                                                            {{$order->fname}} {{$order->lname}}.<br>
                                                                            {{$order->address}}<br>
                                                                            {{$order->city_name}}, {{$order->state_name}} {{$order->zip_code}}<br>
                                                                            <abbr title="Phone">P:</abbr> {{$order->mobile}}
                                                                        </address>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                                                                        <address>
                                                                            <strong>Order Date:</strong><br>
                                                                            {{date('M d, Y', strtotime($order->created_at))}}
                                                                        </address>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h3>ORDER SUMMARY</h3>
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr class="line">
                                                                                    <td><strong>#</strong></td>
                                                                                    <td class="text-center"><strong>PRODUCTS</strong></td>
                                                                                    <td class="text-center"><strong>QUANTITY</strong></td>
                                                                                    <td class="text-right"><strong>PRICE</strong></td>
                                                                                    <td class="text-right"><strong>SUBTOTAL</strong></td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $sum_tot_Price = 0 ?>
                                                                                @foreach ($ordered_products as $order)
                                                                                <tr>
                                                                                    <?php $tt = $order->price * $order->quantity ?>
                                                                                    <td>1</td>
                                                                                    <td><strong>{{ $order->title }}</strong></td>
                                                                                    <td class="text-center">{{$order->quantity}}</td>
                                                                                    <td class="text-right">${{number_format((float)$order->price, 2, '.', '')}}</td>
                                                                                    <td class="text-right">${{number_format((float)$tt, 2, '.', '')}}</td>

                                                                                    {{-- <td class="text-right">${{$tt1}}</td> --}}


                                                                                </tr>
                                                                                <?php $sum_tot_Price += $tt ?>
                                                                                @endforeach

                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td colspan="3" class="text-left"><strong>Sub Total</strong></td>
                                                                                    <td class="text-right"><strong>${{number_format((float)$sum_tot_Price, 2, '.', '')}}</strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td colspan="3" class="text-left"><strong>Shipping and Taxes</strong></td>
                                                                                    <?php $taxes_shipping = $ordered_products[0]->p_total_price - $sum_tot_Price ?>
                                                                                    <td class="text-right"><strong>${{number_format((float)$taxes_shipping, 2, '.', '')}}</strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3">
                                                                                    </td><td class="text-right"><strong>Total</strong></td>
                                                                                    <td class="text-right"><strong>${{$ordered_products[0]->p_total_price}}</strong></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div><br><br>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-10 offset-md-1 text-center mt-3">
                                                                   <strong>Thank you for choosing our store for your recent purchase. We hope that you will have a great shopping experience with us.</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
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

<script>
    $("#pprint1").click(function () {
        $('#pprintarea').printThis({
            importCSS: false,
            loadCSS: "{{asset('public/frontend/css/bootstrap.css')}}",
        });
});
</script>

@endsection
