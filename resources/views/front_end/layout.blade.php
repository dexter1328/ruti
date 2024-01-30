<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
{{-- <title>Nature Checkout | One-Stop E-commerce hub for online selling, in-store buying and self-checkout.</title> --}}
<title>Nature Checkout - @yield('title')</title>
{{-- <meta name="description" content="Nature checkout, a free mobile app that provides safe and convenient grocery shopping during post pandemic- Smart grocery app - Free delivery Nature checkout - buy groceries online – grocery stores online services">
<meta name="keywords" content="Smart grocery app store near me, Free delivery Nature checkout, Closest store near me Nature checkout, Shop groceries stores online, Mobile app for grocery shopping, Smart in-store shopping app, Get online coupon from Nature checkout, Scan and go mobile app from Nature checkout, Smart way to buy and sell online from Nature checkout, Smart and convenient shopping mobile app from Nature checkout, Best way to sell, Sell online, Online sells, Online seller, E-commerce selling, Ecommerce sells, Sales hub, Where to sell, Sell on instacart, Sell on Etsy, Sell on Amazon, Best place to sell, Where to sell, Best Buy and sell center "> --}}
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">

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

<link rel="icon" href="{{asset('public/wb/img/logo/favicon.png')}}" type="image/x-icon">

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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0"/>


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

    <!-- Fontawesome icons -->
    <script src="https://kit.fontawesome.com/2df627c809.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

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
    // window.Trengo = window.Trengo || {};
    // window.Trengo.key = 'oxmtCRRS03uVdb6mASWz';
    // (function(d, script, t) {
    // script = d.createElement('script');
    // script.type = 'text/javascript';
    // script.async = true;
    // script.src = 'https://static.widget.trengo.eu/embed.js';
    // d.getElementsByTagName('head')[0].appendChild(script);
    // }(document));

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

<div id="main">
  <!-- Topbar Start -->
  <div class="topbar-container">
    <div class="topbar text-white d-flex
    justify-content-between align-items-center text-sm">

    <div class="topbar-left">
          <div class="topbar-language">
            <a class="btn btn-link dropdown-toggle text-white" href="#" role="button" id="languageDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              ENGLISH
            </a>
            <div class="language-popup">
              <ul>
                <li><a href="">English</a></li>
                {{-- <li><a href="">Spanish</a></li>
                <li><a href="">French</a></li>
                <li><a href="">Dutch</a></li> --}}
              </ul>
            </div>
          </div>
      <div class="topbar-country">
        <a class="btn btn-link dropdown-toggle text-white" href="#" role="button" id="countryDropdown"
          data-bs-toggle="dropdown" aria-expanded="false">
          CURRENCY
        </a>
        <div class="country-popup">
          <ul>
            <li><a href=""><img class="language-flag-icon" src="{{ asset('public/wb/img/new_homepage/icons/united-states.png') }}" alt=""> USD</a></li>
            <li><a href=""><img class="language-flag-icon" src="{{ asset('public/wb/img/new_homepage/icons/canada.png') }}" alt=""> CAD</a></li>
            <li><a href=""><img class="language-flag-icon" src="{{ asset('public/wb/img/new_homepage/icons/france.png') }}" alt="">EURO</a></li>
          </ul>
        </div>
      </div>

    </div>

<div class="topbar-accounts">
  ACCOUNTS & LISTS
<i class="fa fa-solid fa-caret-down"></i>
<div class="accounts-popup">
  <div class="accounts-popup-top">
    <button class="button" onclick="window.location='{{ url("w2bcustomer/login") }}'">Sign in</button>
    <div>
      New customer?
      <span>
        <a href="{{url('/w2bcustomer/register')}}">
          Start here.
        </a>
      </span>
    </div>
  </div>
  <div class="accounts-popup-bottom">
    <div class="accounts-popup-lists">
      <h4>Create Account</h4>
      <a href="{{ url("/supplier/signup") }}">As a supplier</a>
      <a href="{{ url("/vendor-signup") }}">As a seller</a>
    </div>
    <div class="accounts-popup-account">
      <h4>Your Account</h4>
      @if (Auth::guard('w2bcustomer')->user())
        <a href="{{route('user-account-page')}}">My Account</a>
        <a href="{{route('user-account-page')}}">My Orders</a>
        <a href="{{route('user-account-page')}}">Track Your Order</a>
        <a href="{{route('wb-wishlist-page')}}">Wishlist</a>
        <a href="https://helpdesk.naturecheckout.com" target="_blank">Support</a>
      @else
            <a href="#" type="button" data-toggle="modal" data-target="#exampleModal25">My Account</a>
             <a href="#" type="button" data-toggle="modal" data-target="#exampleModal26">My Orders</a>
             <a href="#" type="button" data-toggle="modal" data-target="#exampleModal27">Track Your Order</a>
             <a href="#" type="button" data-toggle="modal" data-target="#exampleModal28">Wishlist</a>
        @endif
    </div>
  </div>
</div>
</div>


<div class="topbar-right">
  <div class="topbar-find_store">
  <i class="fa fa-solid fa-map-marker"></i>
    FIND A STORE
  </div>

  <!-- Find a Store Popup -->
  <div class="find-store-popup">
    <div class="find-store_store">
      <div class="store-info">
        <div class="store-info-logo">
          <img src="{{ asset('public/wb/img/new_homepage/logo/logo.png') }}" alt="">
        </div>
        <p>
          New Vendor
        </p>
        <button class="button">Store Details</button>
      </div>
      <div class="store-details">
        <div class="store-timings">
          <p class="store-timings-day">Mon-Sun:</p>
          <p class="store-timings-time">9:00am to 9:00pm</p>
        </div>
        <div class="store-contact">
          <div>
          <i class="fa fa-solid fa-phone"></i> (926) 9898 98989
          </div>
          <div>
          <i class="fa fa-solid fa-map-marker"></i> 1.35 mi
          </div>
        </div>
      </div>
    </div>

    <div class="find-store_store">
      <div class="store-info">
        <div class="store-info-logo">
          
          <img src="public/wb/img/new_homepage/logo/logo.png" alt="">
          
        </div>
        <p>
          Joseph
        </p>
        <button class="button">Store Details</button>
      </div>
      <div class="store-details">
        <div class="store-timings">
          <p class="store-timings-day">Mon-Sun:</p>
          <p class="store-timings-time">9:00am to 9:00pm</p>
        </div>
        <div class="store-contact">
          <div>
          <i class="fa fa-solid fa-phone"></i> (926) 9898 98989
          </div>
          <div>
          <i class="fa fa-solid fa-map-marker"></i> 3.62 mi
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="topbar-social_icons">
    <a target="_blank" href="https://www.facebook.com/Naturecheckout" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-facebook-f"></i>
    </a>
    <a target="_blank" href="https://twitter.com/naturecheckout" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-twitter"></i>
    </a>
    <a target="_blank" href="https://www.pinterest.com/Naturecheckout" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-pinterest"></i>
    </a>
    <a target="_blank" href="https://tiktok.com/naturecheckout" class="btn btn-link text-white topbar-social-icon">
        <i class="fab fa-tiktok"></i>
      </a>
    <a target="_blank" href="https://www.linkedin.com/company/93313174/" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-linkedin"></i>
    </a>
    <a target="_blank" href="https://www.instagram.com/naturecheckout" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-instagram"></i>
    </a>
  </div>
  <div class="topbar-left-links">
    <div class="d-flex align-items-center justify-content-center gap-1 ps-2">
      <i class="fas fa-envelope text-white newsletter-icon"></i>
     <a  href="">NEWSLETTER</a>
    </div>
    {{-- <div class="d-flex align-items-center ps-2">
    <a target="_blank" href="https://helpdesk.naturecheckout.com">Support</a>
    </div> --}}
    <div class="d-flex align-items-center ps-2">
        <a href="{{ route('shop-faqs') }}">FAQ</a>
    </div>
  </div>
</div>

</div>
</div>
<!-- Topbar End  -->

<!-- Header Start  -->
<div class="header">
  <div class="mobile-menu-logo">
    <i class="fa fa-solid fa-bars"></i>
  </div>
  <div class="header-logo">
    <a href="https://www.naturecheckout.com">
      <img class="logo" src="public/wb/img/new_homepage/logo/logo.png" alt="">
    </a>
  </div>

    <div class="search-container">
        <form action="{{ route('shop-search') }}" method="get">
            <div class="searchbar">
                <input class="searchbar-input typeahead" placeholder="Search for products" type="text" name="query" id="query" value="{{ request()->input('query') }}">
                <div class="searchbar-category">
                    <select name="search-category">
                        <option value="">Select Category</option>
                        @foreach ($categories2 as $c)
                            <option value="{{ $c->category1 }}">{{ $c->category1 }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit">
                    <span class="searchbar-icon">
                        <i class="fa fa-search search-icon"></i>
                    </span>
                </button>
            </div>
        </form>


      {{-- <div class="searched-products">
        <div class="searched-product">
          <a href="">
            <div class="cart-product">
              <div class="cart-product-image">
                <img src="public/wb/img/new_homepage/logitech-cam-offer.png" alt="webcam">
              </div>
            <div class="cart-product-info">
              <h4 class="cart-product-title">
                Google
                <span class="matched-keyword">Pixel Blue</span>
              </h4>
              <h4 class="cart-product-price">$159.00</h4>
            </div>
          </div>
          </a>
      </div>
        <div class="searched-product">
          <div class="cart-product">
            <div class="cart-product-image">
              <img src="public/wb/img/new_homepage/logitech-cam-offer.png" alt="webcam">
            </div>
          <div class="cart-product-info">
            <h4 class="cart-product-title">
              Google
              <span class="matched-keyword">Pixel Blue</span>
              Google Pixel Blue Google Pixel Blue</h4>
            <h4 class="cart-product-price">
              $159.00</h4>
          </div>
        </div>
      </div>
      </div> --}}
    </div>

  {{-- <div class="searchbar">
    <input type="text" class="searchbar-input" placeholder="Search for products">

    <a href="">
      <span class="searchbar-icon">
        <i class="fa fa-search search-icon"></i>
      </span>
    </a>
  </div> --}}

  <div class="header-options">
    @if (!Auth::guard('w2bcustomer')->user())
        <div class="register-option">
        <a href="{{url('/w2bcustomer/login')}}">LOGIN</a>/
        <a href="{{url('/w2bcustomer/register')}}">REGISTER</a>
        </div>
    @else
        <div class="register-option">
            <b >{{ Auth::guard('w2bcustomer')->user()->fullName() }}</b>/
            <b><a  href="" onclick="event.preventDefault(); document.getElementById('logout-form5').submit();">Logout</a></b>
            <form id="logout-form5" action="{{ route('w2bcustomer.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    @endif
    @if (Auth::guard('w2bcustomer')->user())
    <a href="{{route('wb-wishlist-page')}}">
      <div class="header-wishlist">
        <img class="header-icons" src="{{asset('public/wb/img/new_homepage/icons/heart.png')}}" alt="">
        <div class="header-wishlist-count">{{ $wb_wishlist ? $wb_wishlist->count() : 0 }}</div>
      </div>
    </a>
    @endif

    {{-- @endif --}}
    <!-- <a
    href="{{ route('product-cart') }}"
    > -->
    <div class="header-cart">
      <img
      class="header-icons cart-open-btn"
      src="{{asset('public/wb/img/new_homepage/icons/cart.png')}}"
      alt=""
      >
      <div class="header-cart-count">{{ count((array) session('cart')) }}</div>
    </div>
    <!-- </a> -->

    @php $total = 0 @endphp
    @foreach((array) session('cart') as $sku => $details)
        @php $total += $details['retail_price'] * $details['quantity'] @endphp
    @endforeach
    <div class="header-price">
      <a href="">
        ${{number_format((float)$total, 2, '.', '')}}
      </a>
    </div>
  </div>

  <div class="mobile-header-cart-icon">
  <img class="header-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
  </div>
</div>

<!-- Cart  -->
<div class="side-cart-wrapper"></div>
<div class="side-cart">
  <div class="cart-header">
    <h4>Cart</h4>
    <i class="cart-close-btn fa fa-solid fa-close"></i>
  </div>

  <div class="cart-products">
    @php $total = 0 @endphp
    @foreach((array) session('cart') as $sku => $details)
        @php $total += $details['retail_price'] * $details['quantity'] @endphp
    @endforeach

    @if(session('cart'))
    @foreach(session('cart') as $sku => $details)
    <div class="cart-product">
      <div class="cart-product-image">
        <img src="{{ $details['original_image_url'] }}" alt="{{ Str::limit($details['title'], 35) }}">
      </div>
      <div class="cart-product-info">
        <h4 class="cart-product-title">{{ Str::limit($details['title'], 40) }} X {{ $details['quantity'] }}</h4>
        <h4 class="cart-product-price">${{number_format((float)$details['retail_price'], 2, '.', '')}}</h4>
      </div>
    </div>
    @endforeach
    @endif

    {{-- <div class="cart-product">
      <div class="cart-product-image">
        <img src="public/wb/img/new_homepage/logitech-cam-offer.png" alt="webcam">
      </div>
      <div class="cart-product-info">
        <h4 class="cart-product-title">Google Pixel Blue Lorem Ipsum  Lorem Ipsum  Lorem Ipsum</h4>
        <h4 class="cart-product-price">$159.00</h4>
      </div>
    </div> --}}

  </div>

  <div class="cart-info">
    <h5>Sub Total</h5>
    <h5 class="cart-info-price">${{number_format((float)$total, 2, '.', '')}}</h5>
  </div>
  <div class="cart-buttons">
    <a class="button" href="{{ route('product-cart') }}">
    <i class="fa fa-solid fa-shopping-cart"></i>
      View Cart
    </a>
    <a class="button" href="{{ route('product-checkout') }}">
    <i class="fa fa-solid fa-share"></i>
      Checkout
    </a>
  </div>
</div>

<script>
  $('.cart-close-btn').click(()=>{
    $('.side-cart-wrapper').css("display", "none");
    $('.side-cart').css("right", "-400px");
    $('.side-cart-wrapper').css("display", "none");
    $('.side-cart').css("right", "-400px");
  })

  $('.cart-open-btn').click(()=>{
    $('.side-cart-wrapper').css("display", "flex");
    $('.side-cart').css("right", "0");
  })

  $('.side-cart-wrapper').click(()=>{
    $('.side-cart-wrapper').css("display", "none");
    $('.side-cart').css("right", "-400px");
  })
</script>
<!-- Header End  -->


<div class="landing">
        <div class="landing-top">
            <div class="landing-top-left">
            <div class="landing-top-browse">
                <div class="categories-menu-title">
                <i class="fa fa-solid fa-bars"></i>
                BROWSE CATEGORIES
                </div>
                <i class="fa fa-solid fa-angle-down"></i>
            </div>
                <nav>
                    <a href="{{url('/')}}" class="nav-item">HOME</a>
                    <!-- <a href="{{url('/trending-products')}}" class="nav-item">TRENDING PRODUCTS</a> -->
                    <a href="{{url('/special-offers')}}" class="nav-item">SPECIAL PRODUCTS</a>
                    <!-- <a href="{{url('/trending-products')}}" class="nav-item">PRODUCTS</a> -->
                </nav>
            </div>

            {{-- <div class="landing-top-right">
                <a href="" class="special-offer-link">
                    SPECIAL OFFER
                </a>
                <a href="">
                    PURCHASE THEME
                </a>
            </div> --}}
        </div>

        <div class="landing-main">
            <nav class="landing-menu-nav opacity-0">
                @foreach ($categories as $category)
                @if ($category->parent_id == 0 && !($category->childrens)->isEmpty())
                    <div class="landing-menu-item">
                        <a href="{{ route('cat-products', $category->category1) }}">{{ $category->category1 }}</a>
                        <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>

                        <div class="subcategories-menu">
                            <div class="category-menus">
                                @if($category->childrens->count() > 0)
                                    @foreach($category->childrens as $subcategory)
                                        <div class="category-menu">
                                            <a href="{{ route('cat-products', $subcategory->category1) }}">
                                            <h4>{{ $subcategory->category1 }}</h4>
                                            </a>
                                            <!-- Display subcategory links here -->
                                            @foreach($subcategory->childrens as $subsubcategory)
                                                <a href="{{ route('cat-products', $subsubcategory->category1) }}">{{ $subsubcategory->category1 }}</a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </nav>
        </div>
            </div>






            @yield('content')


        <!-- header area start-->
        <button class="chat_btn">
            <a href="https://helpdesk.naturecheckout.com" target="_blank"><i class="fa fa-comments-o"></i></a>
        </button>
        <button onclick="topFunction()" id="myTopBtn" title="Go to top"><i class="fa fa-chevron-up"></i></button>
        <div class="clearfix"></div>

            @include('front_end.footer1')





</div>
<!-- Main end -->

<script>
  $('.thank-you-close-icon').click(()=>{
    $('.thankyou-popup-wrapper').css('display', 'none');
  })
</script>

<script>
  $('.bought-product-close-icon').click(()=>{
    $('.bought-product-popup').css('display', 'none');
  })
</script>

<script>
  $('.landing-top-browse').click(()=>{
    $('.landing-menu-nav').toggleClass('opacity-0');
  })
</script>
<script>
    document.querySelector('a[href="#faq-section"]').addEventListener('click', function (e) {
        e.preventDefault();

        const targetElement = document.getElementById('faq-section');

        window.scrollTo({
            top: targetElement.offsetTop,
            behavior: 'smooth'
        });
    });
</script>

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
    <script src="{{asset('public/wb/js/timer.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

</body>
</html>
