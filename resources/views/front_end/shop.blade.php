@extends('front_end.layout')

@section('content')

{{-- @include('front_end.banner')
@include('front_end.features') --}}



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
                  {{ Str::limit($product20->title, 100) }}
              </p>
              <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product20->slug, 'sku' => $product20->sku]) }}'" >
                <span class="button-price">{{number_format((float)$product20->retail_price, 2, '.', '')}}$</span>
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
                  Top Gadgets
                </h2>
                <h1 class="slide-main_heading">
                  Most Reliable
                </h1>
                <p class="slide-description">
                    {{ Str::limit($product21->title, 100) }}
                </p>
                <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product21->slug, 'sku' => $product21->sku]) }}'" >
                    <span class="button-price">{{number_format((float)$product21->retail_price, 2, '.', '')}}$</span>
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
                  Top Home Accessories
                </h2>
                <h1 class="slide-main_heading">
                  Most Beautiful
                </h1>
                <p class="slide-description">
                    {{ Str::limit($product22->title, 100) }}
                </p>
                <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product22->slug, 'sku' => $product22->sku]) }}'" >
                    <span class="button-price">{{number_format((float)$product22->retail_price, 2, '.', '')}}$</span>
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
</div>


<!-- Offer Cards Start -->
<div id="main">


<div class="offer-cards">
  <div class="offer-card offer-card-1">
    <div class="offer-card-info">
      <h2 class="offer-card-top_heading">
        Top Cameras
      </h2>
      <h1 class="offer-card-main_heading">
        WEBCAMS 2023
      </h1>
      <p class="offer-card-description">
        Get cameras at discounted rated
      </p>
      <button class="button button-shop_more" onclick="window.location='{{ route('product-detail',['slug' => $product31->slug, 'sku' => $product31->sku]) }}'">
        SHOP Now
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
        Get most beautiful laptop accessories
      </p>
      <button class="button button-light button-shop_more" onclick="window.location='{{ route('product-detail',['slug' => $product32->slug, 'sku' => $product32->sku]) }}'">
        SHOP Now
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
    <h2 class="products-section-heading section-heading">Products</h2>
    <div class="products-section-links">
      <nav>
        <a href="" class="products-section-link active">NEW</a>
        <a href="" class="products-section-link">FEATURED</a>
        <a href="" class="products-section-link">TOP SELLERS</a>
      </nav>
    </div>
  </div>

  <div class="products">
    @foreach ($products33 as $p)

    <div class="product">
        <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
            <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" class="product-img product-img-1">
        </a>
        <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
            <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" class="product-img product-img-2">
        </a>
      <div class="product-info">
        <h3 class="product-name">
            {{ Str::limit($p->title, 40) }}
        </h3>
        <h4 class="product-category">
            {{$p->w2b_category_1}}
        </h4>
        <p class="product-price">
            ${{number_format((float)$p->retail_price, 2, '.', '')}}
        </p>
      </div>
       <div class="product-actions">
        @if(Auth::guard('w2bcustomer')->user())
        <a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist">
            <i class="fa fa-solid fa-heart"></i>
        </a>
        @endif
        <a class="button product-button" href="{{ route('add.to.cart1', $p->sku) }}">ADD TO CART</a>
      </div>

      <!-- triggers on hover -->


    </div>
    @endforeach


  </div>
  {{ $products33->links() }}

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
        @foreach ($products34 as $p)

      <div class="hot-deals-product">
        <div class="product">
          <div class="product-image">
            <div class="hot-deals-product_menu">
                @if(Auth::guard('w2bcustomer')->user())
                    <a href="{{route('wb-wishlist', $p->sku)}}"><img class="product_menu-icons" src="public/wb/img/new_homepage/icons/heart.png" alt=""></a>
                @endif
              <a href="{{ route('add.to.cart1', $p->sku) }}"> <img class="product_menu-icons" src="public/wb/img/new_homepage/icons/cart.png" alt=""></a>
            </div> 
            <div class="hot-deals-product-img">
              <img src="{{$p->original_image_url}}" alt="product-img"
                class="product-img product-img-1">
              <img src="{{$p->original_image_url}}" alt="product-img" class="product-img product-img-2">
            </div>

            <div class="hot-deals-add_to_cart">
                <a href="{{ route('add.to.cart1', $p->sku) }}">
                    Add To Cart
                </a>
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-name">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                {{ Str::limit($p->title, 40) }}
                </a>
            </h3>
            <h4 class="product-category">
                {{$p->w2b_category_1}}
            </h4>
            <p class="product-price">
                ${{number_format((float)$p->retail_price, 2, '.', '')}}
            </p>
          </div>
        </div>
        <div class="hot-deals-timer">
          <div class="countdown" class="row h-100 justify-content-center align-items-center"></div>
        </div>
      </div>
      @endforeach


    </div>
    <button class="button button-hot_offers">
      View All Deals
    </button>
  </div>
</div>

</div>

<!-- Timer -->
<script src="public/shop/js/countdown.js"></script>
<script>
  // TODO timer of the hot offers can be set from here
  setTimeout(() => {
    $('.countdown').countdown({
      year: 2023,
      month: 12,
      day: 22,
      hour: 0,
      minute: 0,
      second: 0,
      timezone: +5,
    });
    
  }, 1000);
</script>

<!-- Hot Deals End -->

<div id="main">
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
        @foreach ($products35 as $p)
        <div class="featured-product">
            <img class="featured-product-image" src="{{$p->original_image_url}}" alt="">
            <div class="featured-product-info">
              <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                <h3 class="featured-product-title">{{ Str::limit($p->title, 10) }}</h3>
              </a>
              <div class="featured-product-price">
                ${{number_format((float)$p->retail_price, 2, '.', '')}}
              </div>
            </div>
          </div>
        @endforeach


      </div>
    </div>
  </div>
  <div>
    <div class="products-section-header">
      <h2 class="products-section-heading section-heading">Top Products</h2>
      <div class="products-section-links">
        <nav>
          <a href="" class="products-section-link active">NEW</a>
          <a href="" class="products-section-link">FEATURED</a>
          <a href="" class="products-section-link">TOP SELLERS</a>
        </nav>
      </div>
    </div>

    <div class="products products-2">
        @foreach ($products36 as $p)
        <div class="product">
            <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" class="product-img product-img-1">
            </a>
            <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" class="product-img product-img-2">
            </a>
          <div class="product-info">
            <h3 class="product-name">
                {{ Str::limit($p->title, 40) }}
            </h3>
            <h4 class="product-category">
                {{$p->w2b_category_1}}
            </h4>
            <p class="product-price">
                ${{number_format((float)$p->retail_price, 2, '.', '')}}
            </p>
          </div>
           <div class="product-actions">
            @if(Auth::guard('w2bcustomer')->user())
            <a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist">
                <i class="fa fa-solid fa-heart"></i>
            </a>
            @endif
            <a class="button product-button" href="{{ route('add.to.cart1', $p->sku) }}">ADD TO CART</a>
          </div>

          <!-- triggers on hover -->


        </div>
        @endforeach
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

</div>
 <!-- Blogs End -->

@endsection

@section('title', 'One-Stop E-commerce hub for online selling, in-store buying and self-checkout.')
@section('description', 'Nature checkout, a free mobile app that provides safe and convenient grocery shopping during post pandemic- Smart grocery app - Free delivery Nature checkout - buy groceries online – grocery stores online services')
@section('keywords', 'Smart grocery app store near me, Free delivery Nature checkout, Closest store near me Nature checkout, Shop groceries stores online, Mobile app for grocery shopping, Smart in-store shopping app, Get online coupon from Nature checkout, Scan and go mobile app from Nature checkout, Smart way to buy and sell online from Nature checkout, Smart and convenient shopping mobile app from Nature checkout, Best way to sell, Sell online, Online sells, Online seller, E-commerce selling, Ecommerce sells, Sales hub, Where to sell, Sell on instacart, Sell on Etsy, Sell on Amazon, Best place to sell, Where to sell, Best Buy and sell center')




