@extends('front_end.layout')
@section('content')

<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Cart</h3>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
@if(session('success'))
<div class="container alert alert-success text-center">
  {{ session('success') }}
</div>
@endif


<div class='row w-100 justify-content-between ml-0 p-5'>
    <div class="col-12 order_main px-0 border">
        <div class='d-flex justify-content-between p-3 border orders_header'>
            <div class='orders_header1 d-flex justify-content-between w-100'>
                <div class='width-20'>
                    Product
                </div>
                <div class='width-20'>
                    Product Name
                </div>
                <div class='width-20'>
                    Quantity
                </div>
                <div class='width-20'>
                   Price
                </div>
                <div  class='width-20'>
                   Total Price
                </div>
            </div>
        </div>
        <div class="orders_body p-3">
            @php $total = 0 @endphp
            @if(session('cart'))
            @foreach(session('cart') as $sku => $details)
            @php $total += $details['retail_price'] * $details['quantity'] @endphp

            <div data-id="{{ $sku }}" class='w-100 justify-content-between order_tab d-flex mt-4 sku-class'>

                <div class='width-20'>
                    <a role="button" class="remove-from-cart"><i class="fa fa-trash-o"></i></a>
                    <img src="{{ $details['original_image_url'] }}" class='table_product_image ml-4' alt="">
                </div>
                <div class='px-2 width-20 image_title'>
                    <span>{{ Str::limit($details['title'], 30) }}</span>
                    <br>
                    {{-- <button class='border buy_again'>Buy it again</button> --}}
                </div>
                <div class='width-20'>
                    <span><label>Quantity</label> <input min="1" max="100" class="quantity update-cart" value="{{$details['quantity']}}" type="number"></span>
                </div>
                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'], 2, '.', '')}}</span>
                </div>
                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</span>
                </div>

            </div>
            @endforeach
            @endif
        </div>
        <div class="orders_footer border-top text-right">
        <a class='text-danger pr-3' href="{{ route('remove-everything') }}">Remove Everything</a>
        </div>
    </div>
    <div class="coupon_area mt-5 col-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                               <div class="cart_subtotal">
                                   <p>Subtotal</p>
                                   <p class="cart_amount">${{number_format((float)$total, 2, '.', '')}}</p>
                               </div>
                               <hr>
                               {{-- <div class="cart_subtotal ">
                                   <p>Shipping</p>
                                   <p class="cart_amount"><span>Flat Rate:</span> £255.00</p>
                               </div>
                               <a href="#">Calculate shipping</a> --}}

                               <div class="cart_subtotal">
                                   <p>Total</p>
                                   <p class="cart_amount">${{number_format((float)$total, 2, '.', '')}}</p>
                               </div>
                               <div class="checkout_btn">
                                    <a href="{{ route('product-shop') }}">Back to Shopping</a>
                                   <a href="{{ route('product-checkout') }}">Proceed to Checkout</a>
                               </div>
                               {{-- <div class="checkout_btn">
                                <a href="{{ route('product-shop') }}">Back to Shopping</a>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='main_parent_div border col-lg-8 col-sm-12 m-auto px-0'>
                <h3 class='sections_coupons_header like_products_heading p-2' >Products You may like</h3>
                <div class='p-3 d-flex products_inner'>
                    @foreach ($suggested_products as $p)
                    <div class='more_products ml-2 py-2 px-4'>
                        <a href="{{ route('product-detail',$p->sku) }}">
                        <img src="{{$p->original_image_url}}" class='more_products_img'  alt="">
                        </a>
                        <div class='products_title'>
                            <h5><a href="{{ route('product-detail',$p->sku) }}">{{ Str::limit($p->title, 20) }}</a></h5>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
    </div>

@endsection

@section('scriptss')

<script type="text/javascript">

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                sku: ele.parents(".sku-class").attr("data-id"),
                quantity: ele.parents(".sku-class").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    sku: ele.parents(".sku-class").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

    $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 3000);

    });

</script>

@endsection
