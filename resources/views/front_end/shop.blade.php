@extends('front_end.layout')
@section('content')

{{-- @include('front_end.banner')
@include('front_end.features') --}}
<!-- banner-area -->
<section class="banner-area-two banner-bg">
    <div class="container-fluid px-xl-5 px-5">
        <div class="row justify-content-end">
            <div class="col-xl-5">
                <div class="cb-item-wrap">
                    <div class="category-banner-item-first left-full-banner mb-20 align-items-center justify-content-center banner_thumb">
                        <div class="content align-self-center">
                            <div class="banner-content">
                            <h2 class="title">{{ Str::limit($product1->title, 25) }}<br><span>{{$product1->w2b_category_1}}</span></h2>
                            <h5 class="color">Brand: <br><span>{{$product1->brand ? $product1->brand : 'Not Specified'}}</span></h5>
                            <h5 class="size">Condition: <br><span>New</span></h5>
                            <h5 class="price">Price: <span>${{number_format((float)$product1->retail_price, 2, '.', '')}}</span></h5>
                            <a href="{{ route('product-detail',$product1->sku) }}" class="btn btn-primary-blue" data-animation="fadeInUp" data-delay=".8s" tabindex="0" style="animation-delay: 0.8s;">Shop Now</a>
                            </div>
                            {{-- <a class="primary_img" href="{{ route('product-detail',$p->sku) }}"><img src="{{$p->large_image_url_250x250}}" alt=""></a> --}}

                        </div>
                        <div class="category-thumb">
                            <img style="width:  100%; height: 100%; object-fit: cover;" src="{{$product1->original_image_url}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-sm-12">
                <div class="cb-item-wrap">
                    <div class="category-banner-item right-top-banner mb-20 align-items-center banner_thumb">
                       <div class="content align-self-center">
                            <h5 class="banner-description"><a href="{{ route('product-detail',$product2->sku) }}">{{$product2->title}}</a></h5>
                            <span class="shop-now">${{number_format((float)$product2->retail_price, 2, '.', '')}}</span>
                        </div>
                        <div class="category-thumb">
                            <img src="{{$product2->original_image_url}}" alt="">
                        </div>
                    </div>
                    <div class="category-banner-item right-bottom-banner mb-20 align-items-center banner_thumb">
                        <div class="content align-self-center">
                            <h5 class="banner-description"><a href="{{ route('product-detail',$product3->sku) }}">{{$product3->title}}</a></h5>
                            <span class="shop-now">${{number_format((float)$product3->retail_price, 2, '.', '')}}</span>
                        </div>
                        <div class="category-thumb">
                            <img src="{{$product3->original_image_url}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner-area-end -->
<!--shipping area start-->
<section class="core-features-area py-3">
    <div class="container-fluid px-5">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6 my-3">
                <div class="core-features-item">
                    <div class="icon">
                        <div class="shipping_icone text-center">
                            <i class="fa fa-plane fa-2x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="shipping_content w-100">
                        <h3 class="title">Secure Shipping</h3>
                        <p>Secure shipping on all US <br>
                            order or order above $20</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 my-3">
                <div class="core-features-item">
                    <div class="icon">
                        <div class="shipping_icone text-center">
                            <i class="fa fa-life-ring fa-2x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="shipping_content w-100">
                         <h3 class="title">Support 24/7</h3>
                        <p>Contact us 24 hours a day,<br>
                           7 days a week</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 my-3">
                <div class="core-features-item">
                    <div class="icon">
                        <div class="shipping_icone text-center">
                            <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="shipping_content w-100">
                        <h3 class="title">30 Days Return</h3>
                        <p>Simply reture it within 30<br>
                        days for an exchange </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 my-3">
                <div class="core-features-item">
                    <div class="icon">
                        <div class="shipping_icone text-center">
                            <i class="fa fa-credit-card fa-2x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="shipping_content w-100">
                        <h3 class="title">100% Payment Secure</h3>
                        <p>We have ensured that your personal information is safeguarded</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--shipping area end-->
<!-- countdown-area -->
<section class="countdown-area">
    <div class="container-fluid px-5 mb-5">
        <div class="row">
            <div class="col-xl-8 counter-wrapper">
                <div class="product-counter-image float-start banner_thumb">
                    <a href="{{ route('product-detail',$product4->sku) }}"><img style="width:  100%; height: 100%; object-fit: cover;" src="{{$product4->original_image_url}}"></a>
                </div>
                <div class="countdown-wrap">
                    <span>DEAL OF THE DAY</span>
                    <h2 class="title"><a href="{{ route('product-detail',$product4->sku) }}">{{ Str::limit($product4->title, 50) }}</a></h2>
                    <p class="counter-price">${{number_format((float)$product4->retail_price, 2, '.', '')}}</p>
                    {{-- <p class="custom-breadcrumb"><span>Potato</span>/<span>Potato</span>/<span>Potato</span></p> --}}
                    <h5 class="counter-size">Package Size: <span>5.8 OZ(165 g)</span></h5>
                    <div class="flash-sale-item mb-20">
                        <div class="fs-content">
                            <div class="content-bottom">
                                <p>Sold 15</p>
                                <p>Available 85</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar w-50" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <h5 class="offer-ends">Offer ends in</h5>
                    <div id="clockdiv">
                        <div class="day-container">
                            <span class="days"></span>
                            <div class="smalltext">Days</div>
                        </div>
                        <div class="dots">:</div>
                        <div class="hours-container">
                            <span class="hours"></span>
                            <div class="smalltext">Hours</div>
                        </div>
                        <div class="dots">:</div>
                        <div class="minutes-container">
                            <span class="minutes"></span>
                            <div class="smalltext">Minutes</div>
                        </div>
                        <div class="dots">:</div>
                        <div class="seconds-container">
                            <span class="seconds"></span>
                            <div class="smalltext">Seconds</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-sm-12">
                <div class="cb-item-wrap counter-right-banner">
                    <div class="category-banner-item right-top-banner mb-xl-3 mb-lg-0 mb-md-0 mb-0 align-items-center banner_thumb">
                       <div class="content align-self-center">
                            <h2 class="counter-area-product-heading"><a href="{{ route('product-detail',$product5->sku) }}">{{$product5->title}}</a></h2>
                            {{-- <p class="counter-area-product-breadcrumb d-flex"><span>Potato</span>/ <span>Potato</span>/ <span>Potato</span></p> --}}
                            <span class="shop-now">${{number_format((float)$product5->retail_price, 2, '.', '')}}</span>
                        </div>
                        <div class="category-thumb">
                            <a href="{{ route('product-detail',$product5->sku) }}"><img src="{{$product5->original_image_url}}" alt=""></a>
                        </div>
                    </div>
                    <div class="category-banner-item right-bottom-banner align-items-center banner_thumb">
                        <div class="content align-self-center">
                            <h2 class="counter-area-product-heading"><a href="{{ route('product-detail',$product6->sku) }}">{{$product6->title}}</a></h2>
                            {{-- <p class="counter-area-product-breadcrumb d-flex"><span>Potato</span>/ <span>Potato</span>/ <span>Potato</span></p> --}}
                            <span class="shop-now">${{number_format((float)$product6->retail_price, 2, '.', '')}}</span>
                        </div>
                        <div class="category-thumb">
                            <a href="{{ route('product-detail',$product6->sku) }}"><img src="{{$product6->original_image_url}}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- countdown-area-end -->
<!--product showcase start-->
<section class="showcase-section">
    <div class="container-fluid px-5">
        <div class="row align-items-center py-4">
            <div class="col-md-7 col-lg-6 col-xl-5 offset-xl-1 text-center text-md-start mb-4 mb-md-0">
                <h2 class="text-dark mb-4">{{$product7->title}}</h2>
                <p class="fs-lg text-dark opacity-70 mb-md-3">The Trexonic 5 in 1 charging station features wireless charging points for your phone, headphones, and smartwatch, as well as an ambient light with three brightness levels.</p>
                <p class="showcase-price">${{number_format((float)$product7->retail_price, 2, '.', '')}}</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-md-start">
                    <a href="{{ route('product-detail',$product7->sku) }}" class="btn btn-primary-blue" data-animation="fadeInUp" data-delay=".8s" tabindex="0" style="animation-delay: 0.8s;">Shop Now</a>
                </div>
            </div>
            <div class="col-md-5 col-lg-6">
                <img class="d-block mx-auto" src="{{asset('public/wb/img/banner/mobile-showcase.png')}}" width="460" alt="Mobile App">
            </div>
        </div>
    </div>
</section>
<!--product showcase end-->
<!--home three bg area start-->
<div class="home3_bg_area">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="productbg_right_side">
                    <div class="product_container">
                        <div class="row">
                                @foreach ($products as $p)
                                <div class="col-4" style="padding-bottom: 35px">
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
                                        <figcaption class="product_content d-flex justify-content-between">
                                            <h4 class="product_name double-lines-ellipsis"><a href="{{ route('product-detail',$p->sku) }}">{{ Str::limit($p->title, 30) }}</a></h4>
                                            <div class="price_box">
                                                <span class="current_price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </article>
                                </div>
                                @endforeach
                                
                            </div>
                           
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
               <div class="productbg_right_left">
                    <div class="arrivals-add">
                        <div class="thumb mb-100">
                            <a href="{{ route('product-detail',$product8->sku) }}"><img src="{{asset('public/wb/img/banner/product-6.png')}}" alt="img"></a>
                            <h4 class="price text-end"><span>${{number_format((float)$product8->retail_price, 2, '.', '')}}</span></h4>
                        </div>
                        <div class="content">
                        <h2 class="title"><span><a href="{{ route('product-detail',$product8->sku) }}">{{$product8->title}}</a></span></h2>
                        </div>
                        <span class="top-tag">Shop Now</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--home three bg area end-->
<!-- features-area -->
<section class="features-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="features-item mb-30 align-items-center py-4 px-5 justify-content-between banner_thumb">
                    <div class="offer-banners-items align-items-center">
                        <div class="content align-self-center">
                             <div class="sell-tag mb-3">Sale</div>
                            <h2 class="text-dark mb-4 fw-normal fs-3 lh-sm double-lines-ellipsis">
                                <a href="{{ route('product-detail',$product9->sku) }}">{{$product9->title}}</a>
                            </h2>
                            <p class="text-dark opacity-70 mb-md-3 double-lines-ellipsis">
                                Your Kitten will love this table stable and beautiful cat tree house
                            </p>
                            <p class="showcase-price">${{number_format((float)$product9->retail_price, 2, '.', '')}}</p>
                        </div>
                        <div class="category-thumb">
                            <a href="{{ route('product-detail',$product9->sku) }}">
                            <img src="{{asset('public/wb/img/banner/product-7.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="features-item mb-30 align-items-center py-4 px-5 justify-content-between banner_thumb">
                    <div class="offer-banners-items align-items-center">
                        <div class="content align-self-center">
                            <div class="sell-tag mb-3">Sale</div>
                           <h2 class="text-dark mb-4 fw-normal fs-3 lh-sm double-lines-ellipsis">
                               <a href="{{ route('product-detail',$product10->sku) }}">{{$product10->title}}</a>
                           </h2>
                           <p class="text-dark opacity-70 mb-md-3 double-lines-ellipsis">
                            Joy Fish high quality,
                            commercial grade, durable
                            plastic storage basket with
                            two reinforced handles.
                           </p>
                           <p class="showcase-price">${{number_format((float)$product10->retail_price, 2, '.', '')}}</p>
                       </div>
                       <div class="category-thumb">
                           <a href="{{ route('product-detail',$product10->sku) }}">
                           <img src="{{asset('public/wb/img/banner/product-8.png')}}" alt="">
                           </a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- features-area-end -->
<!-- Category Section Start-->
<section class="category-section">
    <div class="container-fluid">
      <!-- Title -->
        <div class="row mb-4 position-relative">
            <div class="col-xl-7 mx-auto text-center category-heading">
                <h1>Categories</h1>
                <p class="category-sub-text"></p>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($categories1 as $cat)
                
          <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 card-wrapper">
            <div class="card border-0">
              <div class="position-relative rounded-circle overflow-hidden mx-auto custom-circle-image">
                <img class="w-100 h-100" src="{{asset('public/wb/img/categories/'.$cat->image)}}" alt="Card image cap">
              </div>
              <div class="card-body text-center mt-2">
                <h3 class="card-title"> <a href="{{route('cat-products', $cat->category1)}}">{{$cat->category1}}</a></h3>
              </div>
            </div>
          </div>
          @endforeach


          
        </div>
    </div>
</section>
<!-- Category Section End-->


@endsection
