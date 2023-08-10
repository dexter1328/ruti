@extends('front_end.layout')
@section('content')

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Wishlist</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs area end-->


<!--wishlist area start -->
<div class="wishlist_area mt-70">
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc wishlist">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Stock Status</th>
                                        <th class="product_total">Add To Cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wish_products as $wp)
                                    <tr>
                                        <td class="product_remove">
                                            <form action="{{ route('remove-from-wishlist',$wp->sku) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <button class="" type="submit">X</button></td>
                                            </form>
                                         <td class="product_thumb"><a href="#"><img src="{{$wp->original_image_url}}" alt="{{ Str::limit($wp->title, 35) }}"></a></td>
                                         <td class="product_name"><a href="#">{{$wp->title}}</a></td>
                                         <td class="product-price">{{$wp->retail_price}}</td>
                                         <td class="product_quantity">In Stock</td>
                                         <td class="product_total"><a href="{{ route('add.to.cart', $wp->sku) }}">Add To Cart</a></td>


                                     </tr>

                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                    </div>
                 </div>
             </div>
        {{-- <div class="row">
            <div class="col-12">
                 <div class="wishlist_share">
                    <h4>Share on:</h4>
                    <ul>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                        <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div> --}}

    </div>
</div>
<!--wishlist area end -->



@endsection


@section('scriptss')

<script>
     $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 3000);

    });
</script>
@endsection
