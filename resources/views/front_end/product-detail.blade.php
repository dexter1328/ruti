@extends('front_end.layout')
@section('content')
@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif



<!--product details start-->
<div class="product_details mt-70 mb-70">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="product-details-tab" style="max-width: 450px; width: 100%;">
                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            <img id="zoom1" src="{{$product->original_image_url}}" data-zoom-image="{{$product->original_image_url}}" alt="big-1">
                        </a>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->original_image_url}}" data-zoom-image="{{$product->original_image_url}}">
                                    <img src="{{$product->original_image_url}}" alt="zo-th-1"/>
                                </a>

                            </li>
                            @if ($product->extra_img_1)
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_1}}" data-zoom-image="{{$product->extra_img_1}}">
                                    <img src="{{$product->extra_img_1}}" alt="zo-th-1"/>
                                </a>

                            </li>
                            @endif
                            @if ($product->extra_img_2)
                            <li >
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_2}}" data-zoom-image="{{$product->extra_img_2}}">
                                    <img src="{{$product->extra_img_2}}" alt="zo-th-1"/>
                                </a>

                            </li>
                            @endif
                            @if ($product->extra_img_3)
                            <li >
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_3}}" data-zoom-image="{{$product->extra_img_3}}">
                                    <img src="{{$product->extra_img_3}}" alt="zo-th-1"/>
                                </a>

                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 mt-4 mt-lg-0">
                <div class="product_d_right">
                   <form action="#">
                        <span class="shop-details-content"><i class="lnr lnr-checkmark-circle"></i>In Stock</span>
                        <h1><a href="#">{{$product->title}}</a></h1>
                        <div class=" product_ratting">
                            {{-- <ul>
                                <li><a href="#"><i class="icon-star"></i></a></li>
                               <li><a href="#"><i class="icon-star"></i></a></li>
                               <li><a href="#"><i class="icon-star"></i></a></li>
                               <li><a href="#"><i class="icon-star"></i></a></li>
                               <li><a href="#"><i class="icon-star"></i></a></li>
                                <li class="review"><a href="#"> (customer review ) </a></li>
                            </ul> --}}

                        </div>
                        <div class="price_box">
                            <span class="current_price">${{number_format((float)$product->retail_price, 2, '.', '')}}</span>
                            {{-- <span class="old_price">$80.00</span> --}}
                        </div>
                       <div class="category-type">
                            <ul>
                                <li>
                                    Category:
                                </li>
                                <li>
                                    {{$product->w2b_category_1}}
                                </li>
                            </ul>
                       </div>
                       <div class="category-type">
                            <ul>
                                <li>
                                    Brand:
                                </li>
                                <li>
                                    {{$product->brand ? $product->brand : 'Not Specified'}}
                                </li>
                            </ul>
                        </div>
                        {{-- <div class="product_desc">
                            <span>Usage :</span>
                            <p>Fusce ultricies massa massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero hendrerit est, sed commodo augue nisi non neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in </p>
                        </div>
                        <div class="product_variant color">
                            <h3>Available Options</h3>
                            <label>color</label>
                            <ul>
                                <li class="color1"><a href="#"></a></li>
                                <li class="color2"><a href="#"></a></li>
                                <li class="color3"><a href="#"></a></li>
                                <li class="color4"><a href="#"></a></li>
                            </ul>
                        </div>
                       <div class="shop-details-quantity-default">
                           <span>Amount</span>
                            <ul class="d-flex align-items-center">
                                <li><p>2 Pcs</p></li>
                                <li><p>3 Pcs</p></li>
                            </ul>
                        </div> --}}
                        <div class="quantity-option">
                            {{-- <div class="">
                                <span>Quantity</span>
                                <div class="cart-plus-minus">
                                    <input type="text" value="1">
                                    <div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>
                                </div>
                            </div> --}}
                            <div class="">
                                <a class="btn btn-secondary-orange" href="{{ route('add.to.cart', $product->sku) }}"  >add to cart</a>
                                <a class="btn btn-primary-blue" href="{{ route('product-shop') }}" >Back To Shopping</a>
                            </div>
                        </div>
                        @if (Auth::guard('w2bcustomer')->user())
                       <div class="shop-details-Wishlist">
                            <ul>
                                <li><a href="{{route('wb-wishlist', $product->sku)}}"><i class="lnr lnr-heart"></i><p>Add to Wishlist</p></a></li>
                                {{-- <li><a href="#"><i class="lnr lnr-chart-bars"></i><p>Compare</p></a></li> --}}
                            </ul>
                        </div>
                        @else
                        <div class="shop-details-Wishlist">
                            <ul>
                                <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal29"><i class="lnr lnr-heart"></i><p>Add to Wishlist</p></a></li>
                                {{-- <li><a href="#"><i class="lnr lnr-chart-bars"></i><p>Compare</p></a></li> --}}
                            </ul>
                        </div>
                        @endif
                        <div class=" product_d_action mt-4">
                            <h4>Share This Product</h4>
                         </div>
                        <div class="container mt-4 ">
                            {!! $shareComponent !!}
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product details end-->
<!--product info start-->
<section id="reviewspage">
<div class="product_d_info mb-65">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist" id="tabb2">
                            <li >
                                <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                            </li>
                            <li>
                                 {{-- <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a> --}}
                            </li>
                            <li>
                               <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{$ratings->count()}})</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" >
                            <div class="product_info_content">
                                <div class="container">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="sheet" role="tabpanel" >
                           <div class="container">
                                <div class="product_d_table">
                                    <form action="#">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="first_child">Compositions</td>
                                        <td>Polyester</td>
                                    </tr>
                                    <tr>
                                        <td class="first_child">Styles</td>
                                        <td>Girly</td>
                                    </tr>
                                    <tr>
                                        <td class="first_child">Properties</td>
                                        <td>Short Dress</td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                                </div>
                            </div>
                            <div class="product_info_content">
                                <div class="container">
                                    <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
                                </div>
                            </div>
                        </div> --}}

                        <div class="tab-pane fade" id="reviews" role="tabpanel" >
                            <div class="reviews_wrapper">
                                <div class="container">
                                        <h2>{{$ratings->count()}} review for this product</h2>
                                        @foreach ($ratings as $rating)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb">
                                                <img src="{{asset('public/wb/img/blog/comment2.jpg')}}" alt="">
                                            </div>
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    @if ($rating->star == 1)
                                            <div class="star_rating">
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            @elseif($rating->star == 2)
                                            <div class="star_rating">
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            @elseif($rating->star == 3)
                                            <div class="star_rating">
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            @elseif($rating->star == 4)
                                            <div class="star_rating">
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            @elseif($rating->star == 5)
                                            <div class="star_rating">
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                                <span class="fa fa-star checked-star"></span>
                                            </div>
                                            @else
                                            <div class="star_rating">
                                                <strong>Not Rated</strong>
                                            </div>
                                            @endif

                                                    <p><strong>{{$rating->user_name}} </strong>- {{ $rating->created_at->format('F d, Y') }}</p>
                                                    <span>{{$rating->comment}}</span>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                        <div class="comment_title">
                                            <h2>Add a review </h2>
                                            <p>Your email address will not be published.  Required fields are marked </p>
                                        </div>
                                        <form class="form-horizontal poststars" action="{{route('user-rating')}}" id="addStar" method="POST">

                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->sku}}">
                                        <div class="product_ratting mb-10 text-left">
                                            <h3>Your rating</h3>
                                                <div style="position: absolute">
                                                    <input class="star star-5" value="5" id="star-5" type="radio" required name="star"/>
                                                    <label class="star star-5" for="star-5"></label>
                                                    <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                                    <label class="star star-4" for="star-4"></label>
                                                    <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                                    <label class="star star-3" for="star-3"></label>
                                                    <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                                    <label class="star star-2" for="star-2"></label>
                                                    <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                                    <label class="star star-1" for="star-1"></label>

                                                </div>
                                            </div><br>
                                        <div class="product_review_form">
                                                <br>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="review_comment">Your review </label>
                                                        <textarea name="comment" required id="review_comment" ></textarea>
                                                    </div>
                                                    @if (Auth::guard('w2bcustomer')->user())

                                                        <input id="author"  type="hidden" name="user_name" value="{{Auth::guard('w2bcustomer')->user()->first_name}}">
                                                        <input id="email"  type="hidden" name="user_email" value="{{Auth::guard('w2bcustomer')->user()->email}}">

                                                    @else
                                                    <div class="col-lg-6 col-md-6">
                                                        <label for="author">Name</label>
                                                        <input id="author"  type="text" name="user_name">

                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label for="email">Email </label>
                                                        <input id="email"  type="text" name="user_email">
                                                    </div>
                                                    @endif



                                                </div>
                                                <button type="submit">Submit</button>
                                        </div>
                                    </form>
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

{{-- <section class='w-100 d-flex mb-3 justify-content-center'>
<div class='m-0 border product_sets mt-2 px-0'>
                        <h3 class='like_products_heading text-center p-2' >Most Popular Sets</h3>
                        <hr>
                        <div class='p-3 d-flex sets_div justify-content-center main_parent_div'>
                        <div class='more_products sets ml-2 py-2 px-4'>
                            <img src="{{$product->original_image_url}}" class='more_products_img'  alt="">
                            <div class='products_title'>
                                <h5>The Clean Routine Set</h5>
                                <h5>$ 165</h5>
                                <div><button class='set-search'><i class="fa fa-search"></i></button> <button class='set-select sold' >Sold Out</button></div>
                            </div>
                        </div>
                        <div class='more_products sets py-2 px-4'>
                            <img src="{{$product->original_image_url}}" class='more_products_img'  alt="">
                            <div class='products_title'>
                                <h5>The Clear Sound Set</h5>
                                <h5>$ 68</h5>
                                <div><button class='set-search'><i class="fa fa-search"></i></button> <button class='set-select' >Select</button></div>
                            </div>
                        </div>
                        <div class='more_products sets py-2 px-4'>
                            <img src="{{$product->original_image_url}}" class='more_products_img'  alt="">
                            <div class='products_title'>
                                <h5>The Car Washing Set</h5>
                                <h5>$ 83</h5>
                                <div><button class='set-search'><i class="fa fa-search"></i></button> <button class='set-select' >Select</button></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
</section> --}}
<!--product info end-->
<!--product area start-->
<section class="product_area related_products">
    <div class='main_parent_div border col-lg-8 col-sm-12 m-auto px-0'>
        <h3 class='sections_coupons_header like_products_heading p-2' >Products You may also like</h3>
        <div class='p-3 d-flex products_inner'>
            @foreach ($related_productss as $p)
            <div class='more_products ml-2 py-2 px-4'>
                <a href="{{ route('product-detail',$p->sku) }}">
                <img src="{{$p->original_image_url}}" class='more_products_img'  alt="">
                </a>

                <div class='products_title'>
                    <h5><a href="{{ route('product-detail',$p->sku) }}">{{ Str::limit($p->title, 17) }}</a></h5>
                </div>
                <div class='products_title'>
                    <h5 class="text-center"><a href="{{ route('product-detail',$p->sku) }}" class="btn btn-danger btn-sm" style="border-radius:5px; font-size:12px; padding:10px 20px;">Select</a></h5>
                </div>
            </div>
            @endforeach


        </div>
    </div><br><br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-12">
                <div class="section_title mb-60">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($related_products as $p)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <article class="single_product">
                <figure>
                    <div class="product_thumb">
                        <a class="primary_img" href="{{ route('product-detail',$p->sku) }}"><img src="{{$p->large_image_url_250x250}}" alt=""></a>
                        <a class="secondary_img" href="{{ route('product-detail',$p->sku) }}"><img src="{{$p->large_image_url_250x250}}" alt=""></a>
                        <div class="label_product">
                            <span class="label_sale">Sale</span>

                        </div>
                        <div class="action_links">
                            <ul>
                                <li class="add_to_cart"><a href="{{ route('add.to.cart1', $p->sku) }}" title="Add to cart"><span class="lnr lnr-cart"></span></a></li>
                                {{-- <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box"  title="quick view"> <span class="lnr lnr-magnifier"></span></a></li> --}}
                                @if(Auth::guard('w2bcustomer')->user())
                                <li class="wishlist"><a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist"><span class="fa fa-heart"></span></a></li>
                                @endif
                             {{-- <li class="compare"><a href="#" title="Add to Compare"><span class="lnr lnr-sync"></span></a></li> --}}
                            </ul>
                        </div>
                    </div>
                    <figcaption class="product_content">
                        <h4 class="product_name double-lines-ellipsis"><a href="{{ route('product-detail',$p->sku) }}">{{ Str::limit($p->title, 30) }}</a></h4>
                        <h5 class='text-left'><i class='fa fa-check'></i> In Stock</h5>
                        <div class="price_box">
                            <span class="current_price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                        </div>
                        <button class='btn btn-primary rounded p-2 my-2 w-100'>Add to Cart</button>
                    </figcaption>
                </figure>
            </article>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!--product area end-->



@endsection


@section('scriptss')

<script type="text/javascript">

    $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 3000);

    });

</script>

<script>
    $(".cartbtn").click(function (e) {
    var sku = $("#sku1").val();
    $.ajax({
        type: "GET",
        url: "{{url('add-to-cart')}}/"+sku,

        success: function(response) {
            if (response) {
                $('#cart20').load(document.URL +  ' #cart20');
            }
        }
    });
});
</script>
<script>
    //redirect to specific tab
    $(document).ready(function () {
    $('#tabb2 a[href="#reviews"]').tab('show')
    });
    </script>
@endsection
