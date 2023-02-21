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
 <!--shopping cart area start -->
<!-- <div class="shopping_cart_area mt-70">
    <div class="container">
        <form action="#">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                        <thead>
                            <tr>
                                <th class="product_remove">Delete</th>
                                <th class="product_thumb">Image</th>
                                <th class="product_name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product_quantity">Quantity</th>
                                <th class="product_total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @if(session('cart'))
                            @foreach(session('cart') as $sku => $details)
                            @php $total += $details['retail_price'] * $details['quantity'] @endphp
                            <tr data-id="{{ $sku }}">
                               <td class="product_remove"><a role="button" class="remove-from-cart"><i class="fa fa-trash-o"></i></a></td>
                                <td class="product_thumb"><a href="#"><img src="{{ $details['original_image_url'] }}" alt=""></a></td>
                                <td class="product_name"><a href="#">{{ Str::limit($details['title'], 30) }}</a></td>
                                <td class="product-price">${{number_format((float)$details['retail_price'], 2, '.', '')}}</td>
                                <td class="product_quantity"><label>Quantity</label> <input min="1" max="100" class="quantity update-cart" value="{{$details['quantity']}}" type="number"></td>
                                <td class="product_total">${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</td>


                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                        </div>
                        <div class="checkout_btn">
                            <a style="background: red" href="{{ route('remove-everything') }}">Remove Everything</a>
                        </div>
                    </div>
                 </div>
             </div>
             coupon code area start
            coupon code area end
        </form>
    </div>
</div> -->
 <!--shopping cart area end -->

<!-- new shopping cart -->

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
            <!-- <div class='text-success font-weight-bold'>Arriving today by 10 PM</div>
            <div>Shipped</div> -->
            <div class='w-100 justify-content-between order_tab d-flex mt-4'>

                <div class='width-20'>
                    <a role="button" class="remove-from-cart"><i class="fa fa-trash-o"></i></a>
                    <img src="{{ $details['original_image_url'] }}" class='table_product_image ml-4' alt="">
                </div>
                <div class='px-2 width-20 image_title'>
                    <span>{{ Str::limit($details['title'], 30) }}</span>
                    <br>
                    <button class='border buy_again'>Buy it again</button>
                </div>
                <div class='width-20'>
                    <span><label>Quantity</label> <input min="1" max="100" class="quantity update-cart" value="{{$details['quantity']}}" type="number"></span>
                </div>
                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</span>
                </div>
                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'], 2, '.', '')}}</span>
                </div>
            </div>
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
            <div class='main_parent_div border col-lg-6 col-sm-12 m-auto px-0'>
                <h3 class='sections_coupons_header like_products_heading p-2' >Products You may like</h3>
                <div class='p-3 d-flex products_inner'>
                <div class='more_products ml-2 py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
                <div class='more_products py-2 px-4'>
                    <img src="{{ $details['original_image_url'] }}" class='more_products_img'  alt="">
                    <div class='products_title'>
                        <h5>Wireless Headphones with HD Sound</h5>
                    </div>
                </div>
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
                sku: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
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
                    sku: ele.parents("tr").attr("data-id")
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
