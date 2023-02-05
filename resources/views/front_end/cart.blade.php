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
<div class="shopping_cart_area mt-70">
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
             <!--coupon code area start-->
            <div class="coupon_area">
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
            <!--coupon code area end-->
        </form>
    </div>
</div>
 <!--shopping cart area end -->




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
