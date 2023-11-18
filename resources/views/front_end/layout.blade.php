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
  <div id="main"> <!-- Topbar Start --> 

<div class="topbar-container"> 
  <div class="topbar text-white d-flex
  justify-content-between align-items-center text-sm">

  <div class="topbar-left"> 
        <div class="dropdown">
          <a class="btn btn-link dropdown-toggle text-white" href="#" role="button" id="languageDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            ENGLISH
          </a>
          <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" href="#">English</a></li>
            <!-- Add more language options here -->
          </ul>
        </div>
    <div class="dropdown">
      <a class="btn btn-link dropdown-toggle text-white" href="#" role="button" id="countryDropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        COUNTRY
      </a>
      <ul class="dropdown-menu" aria-labelledby="countryDropdown">
        <li><a class="dropdown-item" href="#">Country 1</a></li>
        <!-- Add more country options here -->
      </ul>
    </div>

</div>

<div class="topbar-accounts">
  Accounts & Lists
<i class="fa fa-solid fa-caret-down"></i>
<div class="accounts-popup">
  <div class="accounts-popup-top">
    <button class="button">Sign in</button>
    <div>
      New customer? 
      <span>
        <a href="">
          Start here.
        </a>
      </span>
    </div>
  </div>
  <div class="accounts-popup-bottom">
    <div class="accounts-popup-lists">
      <h4>Your Lists</h4>
      <a href="">Create a List</a>
      <a href="">Find a List or Registry</a>
    </div>
    <div class="accounts-popup-account">
      <h4>Your Account</h4>
      <a href="">Account</a>
      <a href="">Orders</a>
      <a href="">Recommendations</a>
      <a href="">Browsing History</a>
      <a href="">Watchlist</a>
      <a href="">Video Purchases & Rentals</a>
    </div>
  </div>
</div>
</div>


<div class="topbar-right">
  <div class="topbar-find_store">
  <i class="fa fa-solid fa-map-marker"></i>
    Find a store
  </div>

  <!-- Find a Store Popup -->
  <div class="find-store-popup">
    <div class="find-store_store">
      <div class="store-info">
        <div class="store-info-logo">
          <img src="public/wb/img/new_homepage/logo/logo.png" alt="">
        </div>
        <p>
          Rose Yost 9943 Tanya Apt 27
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
          <i class="fa fa-solid fa-map-marker"></i> 2,874 mi
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
          Rose Yost 9943 Tanya Apt 27
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
          <i class="fa fa-solid fa-map-marker"></i> 2,874 mi
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="topbar-social_icons">
    <a href="#" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-facebook-f"></i>
    </a>
    <a href="#" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-twitter"></i>
    </a>
    <a href="#" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-pinterest"></i>
    </a>
    <a href="#" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-linkedin"></i>
    </a>
    <a href="#" class="btn btn-link text-white topbar-social-icon">
      <i class="fab fa-telegram"></i>
    </a>
  </div>
  <div class="topbar-left-links">
    <div class="d-flex align-items-center justify-content-center gap-1 ps-2">
      <i class="fas fa-envelope text-white newsletter-icon"></i>
     <a href="">NEWSLETTER</a>
    </div>
    <div class="d-flex align-items-center ps-2">
    <a href="">CONTACT US</a>  
    </div>
    <div class="d-flex align-items-center ps-2">
     <a href="">FAQS</a> 
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
    <img class="logo" src="public/wb/img/new_homepage/logo/logo.png" alt="">
  </div>
  <div class="searchbar">
    <input type="text" class="searchbar-input" placeholder="Search for products">
    <div class="searchbar-category">
        <select class="" name="search-category">
          <option>Select Category</option>
          <option>Category 1</option>
          <option>Category 2</option>
          <option>Category 3</option>
          <option>Category 4</option>
        </select>
    </div>
    <a href="">
      <span class="searchbar-icon">
        <i class="fa fa-search search-icon"></i>
      </span>
    </a>
  </div>
  <div class="header-options">
    <div class="register-option">
      <a href="">LOGIN</a>/
      <a href="">REGISTER</a>
    </div>
    <a href="">
     <img class="header-icons" src="public/wb/img/new_homepage/icons/heart.png" alt="">
    </a>
    <a href="">
      <img class="header-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
    </a>
    <div class="header-price">
      <a href="">
      $98.00
      </a>
    </div>
  </div>

  <div class="mobile-header-cart-icon">
  <img class="header-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
  </div>
</div>
<!-- Header End  -->


<!-- Landing Start  -->
<div class="landing">

  <div class="landing-top">
    <div class="landing-top-left">
      <div class="landing-top-browse">
        <div>
          <i class="fa fa-solid fa-bars"></i>
          Browse Categories
        </div>
        <i class="fa fa-solid fa-angle-down"></i>
      </div>
      <nav>
        <a href="" class="nav-item">HOME</a>
        <a href="" class="nav-item">SHOP</a>
        <a href="" class="nav-item">BLOG</a>
        <a href="" class="nav-item">PAGES</a>
        <a href="" class="nav-item">ELEMENTS</a>
        <a href="" class="nav-item">BUY</a>
      </nav>
    </div>

    <div class="landing-top-right">
      <a href="" class="special-offer-link">
        SPECIAL OFFER
      </a>
      <a href="">
        PURCHASE THEME
      </a>
    </div>
  </div>

  <div class="landing-main">
    <nav class="landing-menu-nav">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-couch"></i>
          Furniture
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>

          <!-- <div class="hover-menu">
            <div class="category-menus">
              <div class="category-menu">
                <h4>MAN</h4>
                <a href="">
                  Outerwear
                </a>
                <a href="">
                  Jackets
                </a>
                <a href="">
                  Jumpsuits
                </a>
              </div>
              <div class="category-menu">
                <h4>MAN</h4>
                <a href="">
                  Outerwear
                </a>
                <a href="">
                  Jackets
                </a>
                <a href="">
                  Jumpsuits
                </a>
              </div>
              <div class="category-menu">
                <h4>MAN</h4>
                <a href="">
                  Outerwear
                </a>
                <a href="">
                  Jackets
                </a>
                <a href="">
                  Jumpsuits
                </a>
              </div>
              <div class="category-menu">
                <h4>MAN</h4>
                <a href="">
                  Outerwear
                </a>
                <a href="">
                  Jackets
                </a>
                <a href="">
                  Jumpsuits
                </a>
              </div>
            </div>
        </div> -->
        </div>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-utensils"></i>
          Cooking
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-glasses"></i>
          Accessories
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-vest"></i>
          Fashion
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-clock"></i>
          Clocks
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-lightbulb"></i>
          Lighting
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-dice"></i>
          Toys
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-paper-plane"></i>
          Hand Made
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-wine-glass"></i>
          Minimalism
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-plug"></i>
          Electronics
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
      <a href="">
        <div class="landing-menu-item">
          <i class="fa landing-menu-icon fa-solid fa-car"></i>
          Cars
          <i class="fa fa-solid fa-angle-right landing-menu-more_icon"></i>
        </div>
      </a>
    </nav>

    <div class="landing-slider">

      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-slide carousel-slide-1">
              <div class="slide-info">
                <h2 class="slide-top_heading">
                  Top Smartwatches
                </h2>
                <h1 class="slide-main_heading">
                  Wonderful Performance
                </h1>
                <p class="slide-description">
                  Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  Autem corporis distinctio recusandae enim qui
                </p>
                <button class="button button_buy-now">
                  <span class="button-price">799$</span>
                  <span class="button-text">BUY NOW</span>
                </button>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-slide ">
              <div class="carousel-slide-filter"></div>
              <div class="carousel-slide carousel-slide-2">
                <div class="slide-info">
                  <h2 class="slide-top_heading">
                    Top Smartwatches
                  </h2>
                  <h1 class="slide-main_heading">
                    Wonderful Performance
                  </h1>
                  <p class="slide-description">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Autem corporis distinctio recusandae enim qui
                  </p>
                  <button class="button button-buy_now">
                    <span class="button-price">799$</span>
                    <span class="button-text">BUY NOW</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-slide ">
            <div class="carousel-slide-filter"></div>
              <div class="carousel-slide carousel-slide-3">
                <div class="slide-info">
                  <h2 class="slide-top_heading">
                    Top Smartwatches
                  </h2>
                  <h1 class="slide-main_heading">
                    Wonderful Performance
                  </h1>
                  <p class="slide-description">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Autem corporis distinctio recusandae enim qui
                  </p>
                  <button class="button button_buy-now">
                    <span class="button-price">799$</span>
                    <span class="button-text">BUY NOW</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

  </div>
</div>
<!-- Landing End  -->


<!-- Offer Cards Start -->
<div class="offer-cards">
  <div class="offer-card offer-card-1">
    <div class="offer-card-info">
      <h2 class="offer-card-top_heading">
        Top Smartwatches
      </h2>
      <h1 class="offer-card-main_heading">
        WEBCAMS 2023
      </h1>
      <p class="offer-card-description">
        Lorem ipsum dolor sit amet consectetur, adipisicing
      </p>
      <button class="button button-shop_more">
        SHOP MORE
      </button>
    </div>
    <div class="offer-card-image">
      <img src="public/wb/img/new_homepage/logitech-cam-offer.png" alt="webcam">
    </div>
  </div>

  <div class="offer-card offer-card-2">
    <div class="offer-card-info">
      <h2 class="offer-card-top_heading">
        Laptop Accessories
      </h2>
      <h1 class="offer-card-main_heading">
        Leather Cases
      </h1>
      <p class="offer-card-description">
        Lorem ipsum dolor sit amet consectetur, adipisicing
      </p>
      <button class="button button-light button-shop_more">
        SHOP MORE
      </button>
    </div>
    <div class="offer-card-image">
      <img src="public/wb/img/new_homepage/laptop-offer.png" alt="">
    </div>
  </div>
</div>
<!-- Offer Cards End -->


<!-- Product Cards Start -->
<div class="products-section">

  <div class="products-section-header">
    <h2 class="products-section-heading section-heading">Electronics</h2>
    <div class="products-section-links">
      <nav>
        <a href="" class="products-section-link active">NEW</a>
        <a href="" class="products-section-link">FEATURED</a>
        <a href="" class="products-section-link">TOP SELLERS</a>
      </nav>
    </div>
  </div>

  <div class="products">
    <div class="product">
      <img src="public/wb/img/new_homepage/products/iphone-red-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/iphone-red-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          iPhone Red 128GB
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>

    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/xbox-one-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/xbox-one-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Microsoft Xbox One S
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Google Pixel Blue
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/samsung-s8-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/samsung-s8-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Samsung Galaxy S8
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Google Pixel Blue
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Google Pixel Blue
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Google Pixel Blue
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
    <div class="product">
      <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
      <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
      <div class="product-info">
        <h3 class="product-name">
          Google Pixel Blue
        </h3>
        <h4 class="product-category">
          Electronics
        </h4>
        <p class="product-price">
          $159.00
        </p>
      </div>
       <div class="product-actions">
        <i class="fa fa-solid fa-heart"></i>
        <button class="button product-button">ADD TO CART</button>
        <i class="fa fa-solid fa-search"></i>
      </div>

      <!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. Enter code at checkout
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Product Cards End -->


<!-- Banner Cards Start -->
<div class="banner-cards">
  <div class="banner-card banner-card-1">
    <img class="banner-card-img" src="public/wb/img/new_homepage/banner-cards/banner-card-1.png" alt="banner-bg">
    <h2 class="banner-card-top_heading">
      High Tech News
    </h2>
    <h1 class="banner-card-main_heading">
      Monster Beats Headphones
    </h1>

    <button class="button button-light button-banner">
      READ MORE
    </button>
  </div>

  <div class="banner-cards-group">
    <div class="banner-card banner-card-2"> <img class="banner-card-img"
        src="public/wb/img/new_homepage/banner-cards/banner-card-2.png" alt="banner-bg">
      <h2 class="banner-card-top_heading">
        Play The Dream
      </h2>
      <h1 class="banner-card-main_heading">
        Apple iPhone 7
        <div>
          Color Red
        </div>
      </h1>

    </div>
    <div class="banner-card banner-card-3"> <img class="banner-card-img"
        src="public/wb/img/new_homepage/banner-cards/banner-card-3.png" alt="banner-bg">
      <h2 class="banner-card-top_heading">
        Minimalism Design
      </h2>
      <h1 class="banner-card-main_heading">
        Music Makes
        <div>
          Feel Better
        </div>
      </h1>
    </div>
  </div>

  <div class="banner-card banner-card-4"> <img class="banner-card-img"
      src="public/wb/img/new_homepage/banner-cards/banner-card-4.png" alt="banner-bg">
    <h2 class="banner-card-top_heading">
      Health & Fit
    </h2>
    <h1 class="banner-card-main_heading">
      Apple
      <div>
        iWatch Nike
      </div>
      <div>
        Edition
      </div>
    </h1>

    <button class="button button-light button-banner">
      WATCH DEMO
    </button>
  </div>
</div>

<!-- Banner Cards End -->



<!-- Hot Deals Start -->
<div class="hot-deals-wrapper">

  <div class="hot-deals">
    <h2 class="hot-deals-heading section-heading">
      Today Hot Deals
    </h2>
    <div class="hot-deals-products">

      <div class="hot-deals-product">
        <div class="product">
          <div class="product-image">
            <div class="hot-deals-product_menu">
              <a href=""><img class="product_menu-icons" src="public/wb/img/new_homepage/icons/heart.png" alt=""></a>
              <a href=""> <img class="product_menu-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
              </a>
            </div> <img src="public/wb/img/new_homepage/products/iphone-red-1.jpg" alt="product-img"
              class="product-img product-img-1">
            <img src="public/wb/img/new_homepage/products/iphone-red-2.jpg" alt="product-img" class="product-img product-img-2">
            <div class="hot-deals-add_to_cart">
              Add To Cart
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-name">
              iPhone Red 128GB
            </h3>
            <h4 class="product-category">
              Electronics
            </h4>
            <p class="product-price">
              $159.00
            </p>
          </div>
        </div>
        <div class="hot-deals-timer">
          <div class="countdown" class="row h-100 justify-content-center align-items-center"></div>
        </div>
      </div>

      <div class="hot-deals-product">
        <div class="product">
          <div class="product-image">
            <div class="hot-deals-product_menu">
              <a href=""><img class="product_menu-icons" src="public/wb/img/new_homepage/icons/heart.png" alt=""></a>
              <a href=""> <img class="product_menu-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
              </a>
            </div>
            <img src="public/wb/img/new_homepage/products/xbox-one-1.jpg" alt="product-img" class="product-img product-img-1">
            <img src="public/wb/img/new_homepage/products/xbox-one-2.jpg" alt="product-img" class="product-img product-img-2">
            <div class="hot-deals-add_to_cart">
              Add To Cart
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-name">
              Microsoft Xbox One S
            </h3>
            <h4 class="product-category">
              Electronics
            </h4>
            <p class="product-price">
              $159.00
            </p>
          </div>
        </div>
        <div class="hot-deals-timer">
          <div class="countdown" class="row h-100 justify-content-center align-items-center"></div>
        </div>
      </div>
      <div class="hot-deals-product">
        <div class="product">
          <div class="product-image">
            <div class="hot-deals-product_menu">
              <a href=""><img class="product_menu-icons" src="public/wb/img/new_homepage/icons/heart.png" alt=""></a>
              <a href=""> <img class="product_menu-icons" src="public/wb/img/new_homepage/icons/cart.png" alt="">
              </a>
            </div>
            <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img"
              class="product-img product-img-1">
            <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img"
              class="product-img product-img-2">
            <div class="hot-deals-add_to_cart">
              Add To Cart
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-name">
              Google Pixel Blue
            </h3>
            <h4 class="product-category">
              Electronics
            </h4>
            <p class="product-price">
              $159.00
            </p>
          </div>
        </div>
        <div class="hot-deals-timer">
          <div class="countdown" class="row h-100 justify-content-center align-items-center"></div>
        </div>
      </div>
    </div>
    <button class="button button-hot_offers">
      View All Deals
    </button>
  </div>
</div>

<!-- Timer -->
<script src="public/shop/js/countdown.js"></script>
<script>
  // TODO timer of the hot offers can be set from here 
  $('.countdown').countdown({
    year: 2023,
    month: 11,
    day: 2,
    hour: 0,
    minute: 0,
    second: 0,
    timezone: +5,
  });
</script>

<!-- Hot Deals End -->

  <!-- Products section - 2 start -->
<div class="products-section products-section-2">
  <div class="products-2-side-banners">
    <div class="side-banner-1">
      <div class="side-banner-1-filter"></div>
      <img class="side-banner-img" src="public/wb/img/new_homepage/side-banner-1.png" alt="banner-bg">
      <h2 class="banner-card-top_heading">
        High Tech News
      </h2>
      <h1 class="banner-card-main_heading side-banner-main_heading">
        Google Smart Home 2022
      </h1>

      <button class="button button-light button-banner">
        READ MORE
      </button>
    </div>
    <div class="side-banner-2 featured-products-section">
      <div class="featured-products-heading">
        Featured Products
      </div>
      <div class="featured-products">
        <div class="featured-product">
          <img class="featured-product-image" src="public/wb/img/new_homepage/products/nikon-camera-1.jpg" alt="">
          <div class="featured-product-info">
            <a href="">
              <h3 class="featured-product-title">Nikon Camera</h3>
            </a>
            <div class="featured-product-price">
              $159.00
            </div>
          </div>
        </div>
        <div class="featured-product">
          <img class="featured-product-image" src="public/wb/img/new_homepage/products/nikon-camera-1.jpg" alt="">
          <div class="featured-product-info">
            <a href="">
              <h3 class="featured-product-title">Nikon Camera</h3>
            </a>
            <div class="featured-product-price">
              $159.00
            </div>
          </div>
        </div>
        <div class="featured-product">
          <img class="featured-product-image" src="public/wb/img/new_homepage/products/nikon-camera-1.jpg" alt="">
          <div class="featured-product-info">
            <a href="">
              <h3 class="featured-product-title">Nikon Camera</h3>
            </a>
            <div class="featured-product-price">
              $159.00
            </div>
          </div>
        </div>
        <div class="featured-product">
          <img class="featured-product-image" src="public/wb/img/new_homepage/products/nikon-camera-1.jpg" alt="">
          <div class="featured-product-info">
            <a href="">
              <h3 class="featured-product-title">Nikon Camera</h3>
            </a>
            <div class="featured-product-price">
              $159.00
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="products-section-header">
      <h2 class="products-section-heading section-heading">Electronics</h2>
      <div class="products-section-links">
        <nav>
          <a href="" class="products-section-link active">NEW</a>
          <a href="" class="products-section-link">FEATURED</a>
          <a href="" class="products-section-link">TOP SELLERS</a>
        </nav>
      </div>
    </div>

    <div class="products products-2">
      <div class="product">
        <img src="public/wb/img/new_homepage/products/iphone-red-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/iphone-red-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            iPhone Red 128GB
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
      <div class="product">
        <img src="public/wb/img/new_homepage/products/xbox-one-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/xbox-one-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            Microsoft Xbox One S
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
      <div class="product">
        <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            Google Pixel Blue
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
      <div class="product">
        <img src="public/wb/img/new_homepage/products/samsung-s8-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/samsung-s8-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            Samsung Galaxy S8
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
      <div class="product">
        <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            Google Pixel Blue
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
      <div class="product">
        <img src="public/wb/img/new_homepage/products/google-pixel-1.jpg" alt="product-img" class="product-img product-img-1">
        <img src="public/wb/img/new_homepage/products/google-pixel-2.jpg" alt="product-img" class="product-img product-img-2">
        <div class="product-info">
          <h3 class="product-name">
            Google Pixel Blue
          </h3>
          <h4 class="product-category">
            Electronics
          </h4>
          <p class="product-price">
            $159.00
          </p>
        </div>
        <div class="product-actions">
          <i class="fa fa-solid fa-heart"></i>
          <button class="button product-button">ADD TO CART</button>
          <i class="fa fa-solid fa-search"></i>
</div>
<!-- triggers on hover -->
      <div class="product-popup">
        <div class="brand-name">
          Wantdo Outdoor
        </div>
        <div class="product-popup-heading">
          35% Off for Orders Over $200
        </div>
        <div class="product-popup-desc">
          Expires in <strong>116 days</strong>. 
          <div>
            Enter code at checkout

          </div>
        </div>
        <div class="product-popup-code">
          <input type="text">
          <button class="button">Shop</button>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<!-- Products section - 2 end -->


<!-- Banner 2 Start -->
<div class="banner-2">
  <img class="banner-2-img" src="public/wb/img/new_homepage/ps4-banner-1.png" alt="banner-bg">
  <h2 class="banner-card-top_heading">
    GAMING COLLECTION
  </h2>
  <h1 class="banner-card-main_heading">
    Sony Playstation 4
    <div>
      Dualshok Controller
    </div>
  </h1>

  <div>
    <button class="button button_banner-2">
      Buy Now
    </button>
    <span class="banner-2-read_more">
      <a href="">
        Read More
      </a>
    </span>
  </div>
</div>
<!-- Banner 2 End -->



    <!-- Blogs Start -->
  <div class="blogs-section">
        <h2 class="hot-deals-heading section-heading">
      Innovative Gadgets
    </h2>

    <div class="blogs">

      <div class="blog blog-1">
        <div class="blog-head">
          <img class="blog-img" src="public/wb/img/new_homepage/blogs/blog-2.jpg" alt="">
          <div class="blog-tag">
            <span>
              DESIGN TRENDS, INSPIRATION
            </span>
          </div>
        </div>
        <div class="blog-data">
          <a href="">
          <div class="blog-title">
              Collar brings back coffee brewing ritual
            </div>
          </a>
          <div class="blog-info">
            <div class="blog-author">
            <span>
            Posted by
            </span> 
              <div  class="blog-info-author-img">
                <img src="public/wb/img/new_homepage/blog-author.jpg" alt="">
              </div>
            </div>
            <a href="">
              S. Rogers
            </a>
           <a href="">
             <i class="fa fa-solid fa-comment"></i>
           </a>
           <a href="">
             <i class="fa fa-solid fa-share"></i>
           </a>
          </div>
          <div class="blog-desc">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores sequi quam distinctio velit quam distinctio velit quaerat ratione...
          </div>
          <a href="" class="blog-link">CONTINUE READING</a>
        </div>
      </div>
      <div class="blog blog-1">
        <div class="blog-head">
          <img class="blog-img" src="public/wb/img/new_homepage/blogs/blog-3.jpg" alt="">
          <div class="blog-tag">
            <span>
              DESIGN TRENDS, INSPIRATION
            </span>
          </div>
        </div>
        <div class="blog-data">
          <a href="">
          <div class="blog-title">
              Collar brings back coffee brewing ritual
            </div>
          </a>
          <div class="blog-info">
            <div class="blog-author">
            <span>
            Posted by
            </span> 
              <div  class="blog-info-author-img">
                <img src="public/wb/img/new_homepage/blog-author.jpg" alt="">
              </div>
            </div>
            <a href="">
              S. Rogers
            </a>
           <a href="">
             <i class="fa fa-solid fa-comment"></i>
           </a>
           <a href="">
             <i class="fa fa-solid fa-share"></i>
           </a>
          </div>
          <div class="blog-desc">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores sequi quam distinctio velit quam distinctio velit quaerat ratione...
          </div>
          <a href="" class="blog-link">CONTINUE READING</a>
        </div>
      </div>
      <div class="blog blog-1">
        <div class="blog-head">
          <img class="blog-img" src="public/wb/img/new_homepage/blogs/blog-1.jpg" alt="">
          <div class="blog-tag">
            <span>
              DESIGN TRENDS, INSPIRATION
            </span>
          </div>
        </div>
        <div class="blog-data">
          <a href="">
          <div class="blog-title">
              Collar brings back coffee brewing ritual
            </div>
          </a>
          <div class="blog-info">
            <div class="blog-author">
            <span>
            Posted by
            </span> 
              <div  class="blog-info-author-img">
                <img src="public/wb/img/new_homepage/blog-author.jpg" alt="">
              </div>
            </div>
            <a href="">
              S. Rogers
            </a>
           <a href="">
             <i class="fa fa-solid fa-comment"></i>
           </a>
           <a href="">
             <i class="fa fa-solid fa-share"></i>
           </a>
          </div>
          <div class="blog-desc">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores sequi quam distinctio velit quam distinctio velit quaerat ratione...
          </div>
          <a href="" class="blog-link">CONTINUE READING</a>
        </div>
      </div>


    </div>
  </div>
 <!-- Blogs End -->



    
 <!-- Footer Start  -->
 <div class="footer-wrapper">
   <div class="footer">
    <div class="footer-info">
      <img class="footer-logo" src="public/wb/img/new_homepage/logo/logo.png" alt="">
      <div class="footer-desc">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores optio id a quibusdam quo blanditiis.
      </div>
      <div class="footer-contact">
        <a href="#">
          <i class="fa fa-solid fa-map-marker"></i>
          451 Wall Street, UK, London
        </a>
        <a href="#">
          <i class="fa fa-solid fa-phone"></i>
          Phone: (064) 332-1233
        </a>
        <a href="#">
          <i class="fa fa-solid fa-fax"></i>
          Fax: (099) 453-1357
        </a>
      </div>
    </div>

    <div class="footer-posts-section">
      <h2 class="footer-heading">Recent Posts</h2>
      <div class="footer-posts">

        <div class="footer-post">
          <div class="footer-post-img">
            <img src="public/wb/img/new_homepage/blogs/blog-3.jpg" alt="aa">
          </div>
          <div class="footer-post-info">
            <h4 class="footer-post-heading">A companion for extra sleeping</h4>
            <div class="footer-post-time">
              <span class="date">
                July 23, 2023
              </span>
              <span class="comment">
                1 Comment
              </span>
            </div>
          </div>
        </div>
        <div class="footer-post">
          <div class="footer-post-img">
            <img src="public/wb/img/new_homepage/blogs/blog-2.jpg" alt="aa">
          </div>
          <div class="footer-post-info">
            <h4 class="footer-post-heading">Outdoor seating collection inspiration</h4>
            <div class="footer-post-time">
              <span class="date">
                July 23, 2023
              </span>
              <span class="comment">
                1 Comment
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="footer-menus">
      <div class="footer-menu">
      <h2 class="footer-heading">Our Stories</h2>
      <nav>
        <ul>
          <li><a href="">New York</a></li>
          <li><a href="">London</a></li>
          <li><a href="">Edinburgh</a></li>
          <li><a href="">Los Angeles</a></li>
          <li><a href="">Chicago</a></li>
          <li><a href="">Las Vegas</a></li>
        </ul>
      </nav>
      </div>
      <div class="footer-menu">
      <h2 class="footer-heading">Useful Links</h2>
      <nav>
        <ul>
          <li><a href="">Privacy Policy</a></li>
          <li><a href="">Returns</a></li>
          <li><a href="">Terms & Conditions</a></li>
          <li><a href="">Contact Us</a></li>
          <li><a href="">Latest News</a></li>
          <li><a href="">Our Sitemap</a></li>
        </ul>
      </nav>
      </div>
      <div class="footer-menu">
      <h2 class="footer-heading">Footer Menu</h2>
      <nav>
        <ul>
          <li><a href="">Instagram Profile</a></li>
          <li><a href="">New Collection</a></li>
          <li><a href="">Woman Dress</a></li>
          <li><a href="">Contact Us</a></li>
          <li><a href="">Latest News</a></li>
          <li><a href="">Blogs</a></li>
        </ul>
      </nav>
      </div>
    </div>
   </div>
 </div>
 <!-- Footer End -->
  </div>

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
