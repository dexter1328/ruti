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
                        <ul role="tablist" class="nav flex-column dashboard-list" id="nav-tab2">
                            <li><a href="#dashboard" data-toggle="tab" class="nav-link ">Dashboard</a></li>
                            <li> <a href="#profile" data-toggle="tab" class="nav-link">Profile</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link active">Orders</a></li>

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
                        @include('front_end.user-profile')
                        <div class="tab-pane fade show active" id="orders">
                            <h3>Orders</h3>
                            <div class="table-responsive">

                                @foreach ($orders as $order)
                                <div class="col-12 order_main px-0 border">
                                    <div class='d-flex justify-content-between p-3 border orders_header'>
                                        <div class='orders_header1 d-flex justify-content-between w-50'>
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
                                        </div>
                                        <div class="orders_header2">
                                            <div>
                                                Order# <span>{{$order->order_id}}</span>
                                            </div>
                                            <div>
                                                <span><a href="{{route('user-product-page',$order->order_id)}}" class='text-primary'>View order details</a> | <a href="{{route('order-invoice',$order->order_id)}}" class='text-primary'>View Invoice</a></span>
                                            </div>
                                        </div>
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

@section('scriptss')
    <script>
        $(function() {
        $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
    input.attr("type", "text");
} else {
    input.attr("type", "password");
}
});

$('#password, #password_confirmation').on('keyup', function () {
if ($('#password').val() == $('#password_confirmation').val()) {
    $('.confirm-check').removeClass('fa-close');
    $('.confirm-check').addClass('fa-check').css('color', 'green');
} else {
    $('.confirm-check').removeClass('fa-check');
    $('.confirm-check').addClass('fa-close').css('color', 'red');
}
});
});
    </script>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>
    <script>
        $(document).ready(function () {
            $('#nav-tab2 a[href="#{{ old('tab') }}"]').tab('show')
        });
    </script>
@endsection
