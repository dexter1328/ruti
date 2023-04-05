@extends('front_end.layout')
@section('content')

{{-- <!--error section area start-->
<div class="error_section">
    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <div class="error_form">
                    <h1><img style="width: 10%" src="{{ asset('public/wb/img/logo/thank-you.gif')}}" alt=""></h1>
                    <h2>Thank You For Ordering</h2>
                    <h5>A Smart Shopping Experience Right In Your Hand</h5>
                    <ul class="banneer-icon banneer-icon-new text center">
                        <li class="apple">
                            <img src="{{ asset('public/frontend/image/ios_qrcode.png')}}" alt="">
                        </li>
                        <li>
                            <img src="{{ asset('public/frontend/image/android_qrcode.png')}}" alt="">
                        </li>
                    </ul>
                    <ul class="banneer-icon"  style="margin-top: 111px">
                        <li class="apple"><a href="{{isset($page_meta['header_ios_app_link']) && $page_meta['header_ios_app_link']!='' ? $page_meta['header_ios_app_link'] : '#'}}" target="_blank"><i class="fa fa-apple"></i></a>
                        </li>
                        <li><a href="{{isset($page_meta['header_android_app_link']) && $page_meta['header_android_app_link']!='' ? $page_meta['header_android_app_link'] : '#'}}" target="_blank"><i class="fa fa-android"></i></a>
                        </li>
                    </ul>
                    <a href="{{ url('/') }}">Back to Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

<!-- download start -->
<section id="download" class="download">
    <h2 class="heading">
        <h1><img style="width: 10%" src="{{ asset('public/wb/img/logo/thank-you.gif')}}" alt=""></h1>
        <h2>Thank You For Ordering</h2>
    </h2>
    <div class="container">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                @if(isset($page_meta['downloads_description']) && $page_meta['downloads_description']!='')
                    <p>{!! $page_meta['downloads_description'] !!}</p>
                @else
                    <p>A faster way to online shopping with the hands-on in store shopping experience. A quick way to reach out and keep in touch – all on the Nature checkout App. The Nature checkout mobile app is available for iOS and Android devices.</p>
                @endif
                <ul class="banner-icon bni1 banner-icon-new">
                    <li class="apple">
                        <img src="{{ asset('public/frontend/image/ios_qrcode.png')}}" alt="">
                    </li>
                    <li>
                        <img src="{{ asset('public/frontend/image/android_qrcode.png')}}" alt="">
                    </li>
                </ul><br>
                <ul class="banner-icon bni2">
                    <li class="apple"><a href="{{isset($page_meta['downloads_ios_app_link']) && $page_meta['downloads_ios_app_link']!='' ? $page_meta['downloads_ios_app_link'] : '#'}}" target="_blank"><i class="fa fa-apple"></i><p>ios</p></a></li>
                    <li><a href="{{isset($page_meta['downloads_android_app_link']) && $page_meta['downloads_android_app_link']!='' ? $page_meta['downloads_android_app_link'] : '#'}}" target="_blank"><i class="fa fa-android"></i><p>Android</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- download end -->

<div style="clear:both;"></div>
<br>
<div class="product_area treew  mb-64">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title">
                       <h2>Products You Would Like</h2>
                    </div>
                    <div class="product_tab_btn">

                    </div>
                </div>
            </div>
        </div><br>
        <div class="product_container">
           <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="productbg_right_side">
                    <div class="product_container">
                        <div class="row">
                                @foreach ($products as $p)
                                <div class="col-lg-3 col-sm-6" style="padding-bottom: 35px">
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

            </div>
            <br><br>

        </div>
    </div>
</div>
<!--product area end-->




@endsection
