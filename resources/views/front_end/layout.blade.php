<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nature Checkout | One-Stop E-commerce hub for online selling, in-store buying and self-checkout.</title>
<meta name="description" content="Nature checkout, a free mobile app that provides safe and convenient grocery shopping during post pandemic- Smart grocery app - Free delivery Nature checkout - buy groceries online – grocery stores online services">
<meta name="keywords" content="Smart grocery app store near me, Free delivery Nature checkout, Closest store near me Nature checkout, Shop groceries stores online, Mobile app for grocery shopping, Smart in-store shopping app, Get online coupon from Nature checkout, Scan and go mobile app from Nature checkout, Smart way to buy and sell online from Nature checkout, Smart and convenient shopping mobile app from Nature checkout, Best way to sell, Sell online, Online sells, Online seller, E-commerce selling, Ecommerce sells, Sales hub, Where to sell, Sell on instacart, Sell on Etsy, Sell on Amazon, Best place to sell, Where to sell, Best Buy and sell center ">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
<!-- <meta http-equiv="Content-type" content="text/html; charset=UTF-8"> -->
<meta name="theme-color" content="#003366" />
<meta property="og:title" content="{{ config('app.name', 'Nature checkout') }}" />
<meta property="og:description" content="We provide convenient and expeditious service to all users (merchants and consumers) in areas of consumer spending. Our service is to improve merchant - customer relations while offering positive contribution to the overall economy." />
<meta property="og:image" content="{{asset('public/wb/img/logo/logo2.png')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://naturecheckout.com/" />
<meta property="fb:app_id" content="482623692719207" />
<style>
/*/    .dropbtn {
        background-color: #003366;
        color: #fff;
        padding: 7px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
}*/

.dropbtn {
    background-color: #003366;
    color: #fff;
    padding: 7px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    position: relative;
    padding-right: 44px;
}
.dropbtn .sign-down {
    font-size: 20px;
    position: fixed;
    margin: 5px 10px;
}
/*.dropdown .dropbtn:hover .sign-down:before{
    content: '\f106';
    transition: all 0.3s ease;

}*/
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 175px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  border-radius: 5px;
  margin-left: -147px;
  padding: 10px;
  padding-bottom: 15px;
}
.dropdown-content-caret{
    content: '';
    top: calc(100% + -22.5rem);
    background-color: #f1f1f1;
    border-top-left-radius: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-top: 1px solid #aab7c2;
    border-left: 1px solid #aab7c2;
    border-bottom-color: transparent;
    transform: rotateZ(45deg);
    position: absolute;
    z-index: 1061;
    right: 20px;
}
.dropdown-box{
    padding-bottom: 10px;
}
.dropdown-box2{
    margin-top: 8px;
}
.dropdown-content .common-link:hover{
    text-decoration: underline;
}
.dropdown-content .common-link
{
    color: #09757a!important;
}


.dropdown-content a {
  color: #000!important;
  padding: 12px 16px!important;
  text-decoration: none;
  display: block!important;
  padding: 4px 10px !important; text-align: left !important;
}

/*.dropdown-content a:hover {background-color: #ddd;}*/

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #003366;}

.fa.fa-tiktok {
    background: url("{{ asset('public/frontend/image/tiktok-white.png')}}") no-repeat;
    width: 22px;
    height: 25px;
}
.follow a:hover .fa.fa-tiktok {
    background: url("{{ asset('public/frontend/image/tiktok-blue.png')}}") no-repeat;
    width: 22px;
    height: 25px;
}
</style>

<link rel="icon" href="{{asset('public/wb/img/logo/favicon.ico')}}" type="image/x-icon">

<!---Font Icon-->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Plugin CSS -->
<link href="{{asset('public/frontend/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{ asset('public/frontend/css/slick.css')}}" rel="stylesheet">
<link href="{{ asset('public/frontend/css/jquery.css')}}" rel="stylesheet">
 <link href="{{ asset('public/frontend/css/animate.css')}}" rel="stylesheet">
<link href="{{ asset('public/frontend/css/magnific-popup.css')}}" rel="stylesheet">
<link href="{{ asset('public/frontend/css/YouTubePopUp.css')}}" rel="stylesheet">
<link href="{{asset('public/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>

<!--shop page css-->
<!--owl carousel min css-->
<link href="{{ asset('public/wb/css/owl.carousel.min.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/font.awesome.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/ionicons.min.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/linearicons.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/slinky.menu.css')}}" rel="stylesheet">
<link href="{{ asset('public/wb/css/plugins.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="{{ asset('public/wb/css/style.css')}}" rel="stylesheet">
{{-- <link href="{{ asset('public/wb/css/style2.css')}}" rel="stylesheet"> --}}





<!-- Theme Style -->
@if (request()->is('home') || Request::path() == 'w2bcustomer/register' || Request::is('thank-you-page') || Request::is('thank-you'))
<link href="{{ asset('public/frontend/css/style.css')}}" rel="stylesheet">
@endif
<link href="{{ asset('public/frontend/css/responsive.css')}}" rel="stylesheet">


@if (Request::path() == '/home')
    <style>
        .navbar {
            position: fixed;
            width: 100%;
            padding-top: 12px;
            padding-bottom: 12px;
            transition: all linear .3s;
        }
    </style>
@else
	<style>

		.navbar{
			background: linear-gradient(to right, rgba(0,51,102,1) 0%, rgba(236,103,36,1) 100%);
		}
        /*.dropdown{
            top:17px;
        }*/
		/*.header-nav .m-nav {
		    margin-right: 0;
		    margin-top: -20px;
		}*/
		#inner-main-content {
		    position: relative;
		    width: 100%;
		    /*padding: 135px 0;*/
		}
	</style>

@endif

    @include('front_end.style1')

    <!-- jQuery -->
    <script src="{{asset('public/frontend/js/jquery-3.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery-migrate-3.js')}}"></script>

    <!-- Plugins -->
    <script src="{{asset('public/frontend/js/popper.js')}}"></script>
    <script src="{{asset('public/frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/counter.js')}}"></script>
    <script src="{{asset('public/frontend/js/waypoints.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.js')}}"></script>
    <script src="{{asset('public/frontend/js/YouTubePopUp.js')}}"></script>
    <script src="{{asset('public/frontend/js/SmoothScroll.js')}}"></script>
    <script src="{{ asset('public/plugins/select2/js/select2.min.js') }}"></script>
    <!-- custom -->
    <script src="{{asset('public/frontend/js/custom.js')}}"></script>
    <script src="{{asset('public/frontend/js/preloader.js')}}"></script>

   <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6B55NDVCGD"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6B55NDVCGD');
    </script>




    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JNHSLQJ5TS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-JNHSLQJ5TS');
    </script>

    <!-- Start of HubSpot Embed Code -->
    <script id="hs-script-loader" async defer src="//js.hs-scripts.com/22066612.js"></script>
    <!-- End of HubSpot Embed Code -->

    <script>
        function geoFindMe() {

            /*const status = document.querySelector('#status');
            const mapLink = document.querySelector('#map-link');

            mapLink.href = '';
            mapLink.textContent = '';*/

            function success(position) {
                const latitude  = position.coords.latitude;
                const longitude = position.coords.longitude;

                /*status.textContent = '';
                mapLink.href = `https://www.openstreetmap.org/#map=18/${latitude}/${longitude}`;
                mapLink.textContent = `Latitude: ${latitude} °, Longitude: ${longitude} °`;*/
            }

            function error() {
                // status.textContent = 'Unable to retrieve your location';
            }

            if(!navigator.geolocation) {
                // status.textContent = 'Geolocation is not supported by your browser';
            } else {
                // status.textContent = 'Locating…';
                navigator.geolocation.getCurrentPosition(success, error);
            }
        }
        geoFindMe();
    </script>

    @if(request()->is('vendor-signup'))
    <!-- Global site tag (gtag.js) - Google Ads: 978318545 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-978318545"></script>
    <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-978318545'); </script>
    @endif

    @if(request()->is('thank-you'))
    <!-- Event snippet for Sign-up conversion page -->
    <script> gtag('event', 'conversion', {'send_to': 'AW-978318545/cm4ECOHUtKEDENHpv9ID'}); </script>
    @endif

     @if(request()->is('read-first') || request()->is('vendor-signup'))
    <!-- Support Widget -->
    <script type="text/javascript">
    window.Trengo = window.Trengo || {};
    window.Trengo.key = 'oxmtCRRS03uVdb6mASWz';
    (function(d, script, t) {
    script = d.createElement('script');
    script.type = 'text/javascript';
    script.async = true;
    script.src = 'https://static.widget.trengo.eu/embed.js';
    d.getElementsByTagName('head')[0].appendChild(script);
    }(document));

    $(document).ready(function () {
        $('.back-top-btn').css('right', '90px');
    })
    </script>
    @endif



    <!--modernizr min js here-->
    <script src="{{asset('public/wb/js/modernizr-3.7.1.min.js')}}"></script>
</head>
<body>


    <div class="off_canvars_overlay"></div>
    <div class="home_three_container">
        <!--header area start-->
<header>
            <div class="main_header header_three color_three">
                <div class="header_middle">
                    <div class="container-fluid px-5">
                        <div class="row align-items-end">
                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                <div class="logo logo-new">
                                    <a href="{{url('/')}}"><img src="{{asset('public/wb/img/logo/logo.png')}}" alt="Nature Checkout"></a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-9 col-12">
                                <div class="header_right_info">
                                    <div class="search_container">
                                       <form action="{{route('shop-search')}}" method="get">
                                            <div class="search_box">
                                                <input class="typeahead" placeholder="Search product..." type="text" name="query" id="query" value="{{request()->input('query')}}">
                                                 <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="header_account_area">
                                        <div class="header-action">
                                    <ul>
                                        @if (!Auth::guard('w2bcustomer')->user())
                                        <li class="header-sine-in dropdown">
                                            <a href="" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="lnr lnr-user fa-3x d-flex"></i>
                                                <p class="sign-in-text">Sign in<span>Account</span></p>
                                            </a>
                                            <div class="dropdown-menu login-dropdown p-3" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-box">
                                                    <p>Sign in or Register</p>
                                                    <div class="sign_in_links d-flex align-items-center">
                                                        <a href="{{url('/w2bcustomer/login')}}" class="p-2 btn_height w-50 text-center">Sign in</a>
                                                        <a href="{{url('/w2bcustomer/register')}}" class="p-2 btn_height w-50 ml-2 text-center"> Sign up</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @else
                                        <li class="header-sine-in dropdown">
                                            <a href="" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if (Auth::guard('w2bcustomer')->user()->image)
                                                <img class="rounded-circle" src="{{asset('public/user_photo/'.Auth::guard('w2bcustomer')->user()->image)}}" style="max-width: 45px; margin-right: 8px;" alt="{{Auth::guard('w2bcustomer')->user()->fullName()}}">
                                                @else
                                                <i class="lnr lnr-user fa-3x d-flex"></i>
                                                @endif
                                                <p class="sign-in-text">{{Auth::guard('w2bcustomer')->user()->fullName()}} </p>
                                            </a>
                                            <div class="dropdown-menu login-dropdown" aria-labelledby="dropdownMenuLink">


                                                <a class="dropdown-item text-dark" href="{{route('user-account-page')}}" >My Account</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-dark" href="" onclick="event.preventDefault(); document.getElementById('logout-form5').submit();">Logout</a>
                                                <form id="logout-form5" action="{{ route('w2bcustomer.logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </li>
                                        @endif
                                        <li class="header-shop header_wishlist">
                                            @if (Auth::guard('w2bcustomer')->user())
                                            <a href="{{route('wb-wishlist-page')}}">
                                            @else
                                            <a href="#" type="button" data-toggle="modal" data-target="#exampleModal28">
                                            @endif

                                                <i class="lnr lnr-heart fa-3x"></i>
                                                <!--Wishlist-->
                                                <span class="cart-count">{{ $wb_wishlist ? $wb_wishlist->count() : 0 }}</span>
                                            </a>
                                        </li>
                                        <li class="header-shop mini_cart_wrapper">
                                            <a href="#">
                                                <i class="lnr lnr-cart fa-3x"></i>
                                                <!--Cart-->
                                                <span class="cart-count">{{ count((array) session('cart')) }}</span>
                                            </a>
                                             <!--mini cart-->
                                            <div class="mini_cart">
                                                <div class="cart_gallery">
                                                    <div class="cart_close">
														<div class="cart_text">
															<h3>cart</h3>
														</div>
														<div class="mini_cart_close">
															<a href="javascript:void(0)"><i class="icon-x" style="color: black"></i></a>
														</div>
													</div>


                                                    @php $total = 0 @endphp
                                                    @foreach((array) session('cart') as $sku => $details)
                                                        @php $total += $details['retail_price'] * $details['quantity'] @endphp
                                                    @endforeach

                                                    @if(session('cart'))
                                                    @foreach(session('cart') as $sku => $details)
                                                    <div class="cart_item" style="padding: 5px 0px;">
                                                        <div class="cart_img">
                                                            <a href="#"><img style="max-width: 50%" src="{{ $details['original_image_url'] }}" alt="{{ Str::limit($details['title'], 35) }}"></a>
                                                        </div>
                                                        <div class="cart_info">
                                                            <h4>{{ Str::limit($details['title'], 40) }}</h4>
                                                            <p style="font-size: 15px">{{ $details['quantity'] }} x <span> ${{number_format((float)$details['retail_price'], 2, '.', '')}} </span></p>
                                                        </div>
                                                        <div class="cart_remove">
                                                            <a href="#"><i class="icon-x"></i></a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif

                                                </div>
                                                <div class="mini_cart_table">
                                                    <div class="cart_table_border">
                                                        <div class="cart_total">
                                                            <span><strong> Sub Total:</strong></span>
                                                            <span class="price">${{number_format((float)$total, 2, '.', '')}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="mini_cart_footer">
                                                   <div class="mb-3">
                                                        <a href="{{ route('product-cart') }}" class=" btn btn-primary-blue"><i class="fa fa-shopping-cart"></i> View cart</a>
                                                    </div>
                                                    <div class="">
                                                        <a href="{{ route('product-checkout') }}" class=" btn btn-secondary-orange"><i class="fa fa-sign-in"></i> Checkout</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--mini cart end-->
                                        </li>
                                        <li class="header-sine-in p-0">
                                            <a href="contact.html">
                                                <p class="text-center">Total<span>${{number_format((float)$total, 2, '.', '')}}</span></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header_bottom">
                    <div class="container-fluid px-5">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-6 col-lg-4 col-xl-3 col-10">
                                <div class="categories_menu categories_three">
                                    <div class="categories_title">
                                            <i class="lnr lnr-menu fa-lg"></i>
                                            <h2 class="categori_toggle">Browse Categories</h2>
                                            <i class="lnr lnr-chevron-down ms-auto"></i>
                                    </div>
                                    <div class="categories_menu_toggle">
                                        <ul>
                                            @if ($categories)
                                                @foreach ($categories as $category)

                                                @if ($category->parent_id == 0 && !($category->childrens)->isEmpty())
                                                <li class="menu_item_children"><a href="{{route('cat-products', $category->category1)}}"><i class='lnr lnr-list pr-2'></i>{{ $category->category1 }}<i class="fa fa-angle-right"></i></a>
                                                    <ul class="categories_mega_menu first_submenu new_sub_menu<?php echo $category->id ?>" style="display:list-item;">
                                                    <div class='list_nav_menu'>
                                                        @foreach ($category->childrens as $subcategory)
                                                            @if ($subcategory->parent_id > 0 && !($subcategory->childrens)->isEmpty())
                                                        <li class="menu_item_children"><a href="{{route('cat-products', $subcategory->category1)}}">{{ $subcategory->category1 }}</a>
                                                        <ul class="categorie_sub_menu ">
                                                                @foreach ($subcategory->childrens as $subsubcategory)
                                                                        <li><a href="{{route('cat-products', $subsubcategory->category1)}}">{{ $subsubcategory->category1 }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                                    @elseif ($subcategory->parent_id > 0 && ($subcategory->childrens)->isEmpty())
                                                                            <li><a href="{{route('cat-products', $subcategory->category1)}}">{{ $subcategory->category1 }}</a> </li>
                                                                        @endif
                                                                    @endforeach
                                                    </div>
                                                                    <div class="nav_menu_image d-flex align-items-center justify-content-end pr-4">
                                                                        <img class='nav_img' src="{{asset('public/wb/img/categories/'.$category->image)}}" alt="{{ Str::limit($category->category1, 35) }}">
                                                                    </div>
                                                                </ul>
                                                            </li>
                                                            @elseif ($category->parent_id == 0 && ($category->childrens)->isEmpty())
                                                                <li><a href="{{route('cat-products', $category->category1)}}"> {{ $category->category1 }}</a></li>
                                                            @endif

                                                        @endforeach
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-8 col-xl-9 col-2">
                                <!--offcanvas menu area start-->
                                <div class="offcanvas_menu offcanvas_three">
                                    <div class="container">
                                        <div class="row justify-content-end">
                                            <div class="">
                                                <div class="canvas_open">
                                                    <a href="javascript:void(0)"><i class="icon-menu"></i></a>
                                                </div>
                                                <div class="offcanvas_menu_wrapper">
                                                    <div class="canvas_close">
                                                        <a href="javascript:void(0)"><i class="icon-x"></i></a>
                                                    </div>
                                                    <div class="search_container">
                                                       <form action="#">
                                                            <div class="search_box">
                                                                <input placeholder="Search product..." type="text">
                                                                 <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="menu" class="text-left ">
                                                        <ul class="offcanvas_main_menu">

                                                            <li class="menu-item-has-children">
                                                                <a href="{{url('/')}}">Home</a>
                                                            </li>
                                                            <li class="menu-item-has-children">
                                                                <a href="{{url('/trending-products')}}">Trending Products</a>
                                                            </li>

                                                            <li class="menu-item-has-children">
                                                                <a href="{{url('/special-offers')}}">Special Offers</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="offcanvas_footer">
                                                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                                                        <div class="header_social text-right">
                                                        <ul>
                                                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                                            <li><a href="#"><i class="ion-social-googleplus-outline"></i></a></li>
                                                            <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                                                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                                            <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--offcanvas menu area end-->
                                <!--main menu start-->
                                <div class="main_menu menu_position">
                                    <nav>
                                        <ul class="justify-content-end">
                                            {{-- <li><a class="{{ Route::is('home-page') ? 'active' : '' }}"  href="{{url('/')}}">Home</a></li> --}}
                                            <li><a class="{{ Route::is('product-shop') ? 'active' : '' }}"  href="{{url('/')}}">Home</a></li>
                                            <li><a class=""  href="{{url('/trending-products')}}">Trending Products</a></li>
                                            <li><a class=""  href="{{url('/special-offers')}}">Special Offers</a></li>
                                            <li><a class=""  href="https://naturemenu.net" target="_blank">Restaurants</a></li>
                                            {{-- <li><a class=""  href="#">Support</a></li> --}}
                                        </ul>
                                    </nav>
                                </div>
                                <!--main menu end-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--header area end-->

        <button onclick="topFunction()" id="myTopBtn" title="Go to top"><i class="fa fa-chevron-up"></i></button>
<div class="clearfix"></div>
	<div class="content-wrapper">
		@yield('content')
	</div>
    @include('front_end.footer1')
    <script>
        let mybutton = document.getElementById("myTopBtn");
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
        }
        function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        }
		$("#subscribe_btn").click(function(){
			var email = $("#email").val();
			if(email != ''){
				$.ajax({

					url: "{{ url('/subscribe_newsletter') }}/"+email,
					type: "GET",
					dataType: 'json',
					success: function (data) {
						if(data.error != ''){
							$("#subscribe_success").html(data.error);
						}
						if(data.success != ''){
							$("#subscribe_success").html(data.success);
						}
					},
					error: function (data) {
					}
				});
			}else{
				$("#email_error").html('Please enter email.');
				$("#subscribe_success").html('');
			}
		});
	</script>
	<script>
        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>
    <script>
      window.addEventListener('load', function(){
        jQuery('button:contains("SignUp")').click(function(){
          gtag('event', 'conversion', {'send_to': 'AW-10934253752/EO76CLahpMsDELjx7d0o'});
        });
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
    </script>
    @yield('scriptss')
    @include('front_end.scripts2')
    <script src="{{asset('public/wb/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/wb/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('public/wb/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('public/wb/js/jquery.countdown.js')}}"></script>
    <script src="{{asset('public/wb/js/jquery.ui.js')}}"></script>
    <script src="{{asset('public/wb/js/jquery.elevatezoom.js')}}"></script>
    <script src="{{asset('public/wb/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('public/wb/js/slinky.menu.js')}}"></script>
    <script src="{{asset('public/wb/js/printThis.js')}}"></script>
    <script src="{{asset('public/wb/js/plugins.js')}}"></script>
    <script src="{{asset('public/wb/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

</body>
</html>
