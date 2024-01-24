@extends('front_end.layout')

@section('content')

{{-- @include('front_end.banner')
@include('front_end.features') --}}

<!-- THIS SECTION WILL BE MOVED TO A NEW PAGE
 <div class="faq-section" id="faq-section">
  <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <h2>How do I place an order?</h2>
                <p>
                    Ordering from Nature Checkout is easy! Simply browse our
                    products, click on the item you want, choose your
                    options/specs (size, color, etc.), and click "Add to Cart."
                    When you're ready to complete your purchase, click the
                    shopping cart icon and follow the checkout process.
                </p>
            </div>

            <div class="faq-item">
                <h2>What payment methods do you accept?</h2>
                <p>
                    We accept major credit and debit cards, including Visa,
                    Mastercard, American Express, and Discover. Additionally, we
                    also accept PayPal for a convenient and secure checkout.
                </p>
            </div>

            <div class="faq-item">
                <h2>How long will the delivery take?</h2>
                <p>
                    The delivery time depends on your location and the shipping
                    method you choose during the checkout process. Our standard
                    shipping option typically takes between 2 to 10 business
                    days, while express shipping delivers within 5 business
                    days.
                </p>
            </div>

            <div class="faq-item">
                <h2>What is your return policy?</h2>
                <p>
                    If you're not completely satisfied with your purchase, we
                    offer a 30-day return policy. Please review our
                    <a href="#">Return Policy</a> for detailed instructions on
                    returning items and processing refunds.
                </p>
            </div>

            <div class="faq-item">
                <h2>Do you ship internationally?</h2>
                <p>
                    Yes, we ship our products worldwide. Please note that
                    shipping times and fees may vary depending on your location.
                    For more information, visit our
                    <a href="#">Shipping Policy</a>.
                </p>
            </div>

            <div class="faq-item">
                <h2>How can I track my order?</h2>
                <p>
                    To track your order, log in to your Nature Checkout account
                    and navigate to the "Order History" section. There, you can
                    find the tracking information for your purchase.
                </p>
            </div>

            <div class="faq-item">
                <h2>
                    What if I have a question about a product or need
                    assistance?
                </h2>
                <p>
                    We're here to help! Feel free to contact our Customer
                    Support team via email at info@naturecheckout.com or contact
                    helpdesk during our business hours. We're always happy to
                    assist with any inquiries or concerns.
                </p>
            </div>

            <div class="faq-item">
                <h2>
                    How can I stay updated with Nature Checkout's latest
                    products and promotions?
                </h2>
                <p>
                    You can follow us on our social media platforms – Facebook,
                    Instagram, Twitter, and Pinterest – or subscribe to our
                    newsletter. By doing so, you'll be the first to know about
                    new arrivals, promotions, and eco-conscious tips.
                </p>
            </div>
        </div>

 -->


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
              <!-- Top Smartwatches -->
            </h2>
            <h1 class="slide-main_heading">
              <!-- Wonderful Performance -->
            </h1>
            <p class="slide-description">
              <!-- {{ Str::limit($product20->title, 100) }} -->
            </p>
            <!-- <button class="button button_buy-now" onclick="window.location='{{ route('product-detail',['slug' => $product20->slug, 'sku' => $product20->sku]) }}'" >
                <span class="button-price">{{number_format((float)$product20->retail_price, 2, '.', '')}}$</span>
                <span class="button-text">BUY NOW</span>
              </button> -->
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
              <button class="button button_buy-now"
                onclick="window.location='{{ route('product-detail',['slug' => $product21->slug, 'sku' => $product21->sku]) }}'">
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
              <button class="button button_buy-now"
                onclick="window.location='{{ route('product-detail',['slug' => $product22->slug, 'sku' => $product22->sku]) }}'">
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
        <button class="button button-shop_more"
          onclick="window.location='{{ route('product-detail',['slug' => $product31->slug, 'sku' => $product31->sku]) }}'">
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
        <button class="button button-light button-shop_more"
          onclick="window.location='{{ route('product-detail',['slug' => $product32->slug, 'sku' => $product32->sku]) }}'">
          SHOP Now
        </button>
      </div>
      <div class="offer-card-image">
        <img src="public/wb/img/new_homepage/laptop-offer.png" alt="">
        <img src="public/wb/img/new_homepage/newyear.jpg" alt="">

      </div>
    </div>
  </div>
  <!-- Offer Cards End -->





        <!-- Products Slider -->
        <!-- Please add only 10 products -->
    <div class="slider-container">
      <div class="slider-wrapper">
        <button id="prev-slide" class="slide-button material-symbols-rounded">
          chevron_left
        </button>
        <ul class="image-list">

        <!-- Slider product -->
        @foreach ($products40 as $p)
          <div class="slider-product">
            <!-- Product Image -->
            <div class="slider-product-image">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                </a>
              <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
              <div class="product-limited-text">Limited Time Offer!</div>
            </div>
            <!-- name -->
            <div class="slider-product-info">
                {{ Str::limit($p->title, 40) }}
            <!-- Price -->
            <div class="slider-product-info2">
              <div class="slider-product-price">
                $ {{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">{{ number_format((float)($p->retail_price + 10), 2, '.', '') }}
                </span>
              </div>
              <div class="percent-off">Upto 30% Off</div>
            </div>

            <!-- Star ratings -->
            <div class="slider-product-info2">
              <div class="slider-product-review">
                <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                <div class="review-points">4.5 </div>
              </div>
              <!-- Cart Icon -->
              <div class="slider-product-cart">
                <a href="{{ route('add.to.cart1', $p->sku) }}">
                    <i class="fa fa-solid fa-shopping-cart"></i>
                </a>
              </div>
            </div>
            </div>
          </div>

          @endforeach
          <!-- Slider product end -->

      </ul>
        <button id="next-slide" class="slide-button material-symbols-rounded">
          chevron_right
        </button>
      </div>
      <div class="slider-scrollbar">
        <div class="scrollbar-track">
          <div class="scrollbar-thumb"></div>
        </div>
      </div>
    </div>
<!-- Product Slider End -->



  <!-- Product Cards Start -->
  <div class="products-section">

    <div class="products-section-header">
      <h2 class="products-section-heading section-heading">Products</h2>
      <div class="products-section-links">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new"
              aria-selected="true">New</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="featured-tab" data-toggle="tab" href="#featured" role="tab" aria-controls="featured"
              aria-selected="false">Featured</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="top-tab" data-toggle="tab" href="#top" role="tab" aria-controls="top"
              aria-selected="false">Top Sellers</a>
          </li>
        </ul>
        <select class="" name="search-category">
          <option selected>Default Sorting</option>
          <option>Sort by popularity</option>
          <option>Sort by average rating</option>
          <option>Sort by latest</option>
          <option>Sort by price: Low to High</option>
          <option>Sort by price: High to Low</option>
        </select>
      </div>
    </div>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
        <div class="products">
          @foreach ($products33 as $p)
        <!-- Slider product -->
        <div class="slider-product">
          <!-- Product Image -->
          <div class="slider-product-image">
            <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
            <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
            </a>
            <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
            <div class="product-limited-text">Limited Time Offer!</div>
          </div>
          <!-- name -->
          <div class="slider-product-info">
            <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
            {{ Str::limit($p->title, 40) }}
            </a>
          <!-- Price -->
          <div class="slider-product-info2">
            <div class="slider-product-price">
              ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
            </div>
            <div class="percent-off">Upto 55% Off</div>
          </div>

          <!-- Star ratings -->
          <div class="slider-product-info2">
            <div class="slider-product-review">
              <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
              <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
              <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
              <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
              <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
              <div class="review-points">4.5 </div>
            </div>
            <!-- Cart Icon -->
            <div class="slider-product-cart">
                <a href="{{ route('add.to.cart1', $p->sku) }}">
                    <i class="fa fa-solid fa-shopping-cart"></i>
                </a>
            </div>
          </div>
          </div>
        </div>
        <!-- Slider product end -->


          @endforeach
        </div>
        {{ $products33->links() }}
      </div>


      <div class="tab-pane fade" id="featured" role="tabpanel" aria-labelledby="featured-tab">
        <div class="products">
            @foreach ($products33a as $p)
          <!-- Slider product -->
          <div class="slider-product">
            <!-- Product Image -->
            <div class="slider-product-image">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                </a>
              <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
              <div class="product-limited-text">Limited Time Offer!</div>
            </div>
            <!-- name -->
            <div class="slider-product-info">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    {{ Str::limit($p->title, 40) }}
                </a>
            <!-- Price -->
            <div class="slider-product-info2">
              <div class="slider-product-price">
                ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
              </div>
              <div class="percent-off">Upto 55% Off</div>
            </div>

            <!-- Star ratings -->
            <div class="slider-product-info2">
              <div class="slider-product-review">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <div class="review-points">4.5 </div>
              </div>
              <!-- Cart Icon -->
              <div class="slider-product-cart">
                <a href="{{ route('add.to.cart1', $p->sku) }}">
                    <i class="fa fa-solid fa-shopping-cart"></i>
                </a>
              </div>
            </div>
            </div>
          </div>
          <!-- Slider product end -->


            @endforeach
          </div>
        {{ $products33->links() }}
      </div>

      <div class="tab-pane fade" id="top" role="tabpanel" aria-labelledby="top-tab">
        <div class="products">
            @foreach ($products33b as $p)
          <!-- Slider product -->
          <div class="slider-product">
            <!-- Product Image -->
            <div class="slider-product-image">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                </a>
              <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
              <div class="product-limited-text">Limited Time Offer!</div>
            </div>
            <!-- name -->
            <div class="slider-product-info">
              {{ Str::limit($p->title, 40) }}
            <!-- Price -->
            <div class="slider-product-info2">
              <div class="slider-product-price">
                ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
              </div>
              <div class="percent-off">Upto 55% Off</div>
            </div>

            <!-- Star ratings -->
            <div class="slider-product-info2">
              <div class="slider-product-review">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                <div class="review-points">4.5 </div>
              </div>
              <!-- Cart Icon -->
              <div class="slider-product-cart">
                <a href="{{ route('add.to.cart1', $p->sku) }}">
                    <i class="fa fa-solid fa-shopping-cart"></i>
                </a>
              </div>
            </div>
            </div>
          </div>
          <!-- Slider product end -->


            @endforeach
          </div>
        {{ $products33->links() }}
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

      {{-- <button class="button button-light button-banner">
        READ MORE
      </button> --}}
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

      {{-- <button class="button button-light button-banner">
        WATCH DEMO
      </button> --}}
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
                <a href="{{route('wb-wishlist', $p->sku)}}"><img class="product_menu-icons"
                    src="public/wb/img/new_homepage/icons/heart.png" alt=""></a>
                @endif
                <a href="{{ route('add.to.cart1', $p->sku) }}"> <img class="product_menu-icons"
                    src="public/wb/img/new_homepage/icons/cart.png" alt=""></a>
              </div>
              <div class="hot-deals-product-img">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img src="{{$p->original_image_url}}" alt="product-img" class="product-img product-img-1">
                    <img src="{{$p->original_image_url}}" alt="product-img" class="product-img product-img-2">
                </a>
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
      {{-- <button class="button button-hot_offers">
        View All Deals
      </button> --}}
    </div>
  </div>

</div>

<!-- Timer -->
<script src="public/shop/js/countdown.js"></script>
<script>
  // TODO timer of the hot offers can be set from here
  setTimeout(() => {
    $('.countdown').countdown({
      year: 2024,
      month: 2,
      day: 23,
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

        {{-- <button class="button button-light button-banner">
          READ MORE
        </button> --}}
      </div>
      <div class="side-banner-2 featured-products-section">
        <div class="featured-products-heading">
          Featured Products
        </div>
        <div class="featured-products">
          @foreach ($products35 as $p)
          <div class="featured-product">
            <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                <img class="featured-product-image" src="{{$p->original_image_url}}" alt="">
            </a>
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
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="new2-tab" data-toggle="tab" href="#new2" role="tab" aria-controls="new2"
                aria-selected="true">New</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="featured2-tab" data-toggle="tab" href="#featured2" role="tab"
                aria-controls="featured2" aria-selected="false">Featured</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="top2-tab" data-toggle="tab" href="#top2" role="tab" aria-controls="top2"
                aria-selected="false">Top Sellers</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="new2" role="tabpanel" aria-labelledby="new2-tab">
            <div class="products products-2">
                @foreach ($products36 as $p)
                <div class="slider-product">
                <!-- Product Image -->
                <div class="slider-product-image">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                        <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                    </a>
                    <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
                    <div class="product-limited-text">Limited Time Offer!</div>
                </div>
                <!-- name -->
                <div class="slider-product-info">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                        {{ Str::limit($p->title, 40) }}
                    </a>
                <!-- Price -->
                <div class="slider-product-info2">
                    <div class="slider-product-price">
                    ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                    </div>
                    <div class="percent-off">Upto 55% Off</div>
                </div>

                <!-- Star ratings -->
                <div class="slider-product-info2">
                    <div class="slider-product-review">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <div class="review-points">4.5 </div>
                    </div>
                    <!-- Cart Icon -->
                    <div class="slider-product-cart">
                        <a href="{{ route('add.to.cart1', $p->sku) }}">
                            <i class="fa fa-solid fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
                </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="featured2" role="tabpanel" aria-labelledby="featured2-tab">
            <div class="products products-2">
                @foreach ($products36a as $p)
                <div class="slider-product">
                <!-- Product Image -->
                <div class="slider-product-image">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                        <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                    </a>
                    <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
                    <div class="product-limited-text">Limited Time Offer!</div>
                </div>
                <!-- name -->
                <div class="slider-product-info">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    {{ Str::limit($p->title, 40) }}
                    </a>
                <!-- Price -->
                <div class="slider-product-info2">
                    <div class="slider-product-price">
                    ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                    </div>
                    <div class="percent-off">Upto 55% Off</div>
                </div>

                <!-- Star ratings -->
                <div class="slider-product-info2">
                    <div class="slider-product-review">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <div class="review-points">4.5 </div>
                    </div>
                    <!-- Cart Icon -->
                    <div class="slider-product-cart">
                    <i class="fa fa-solid fa-shopping-cart"></i>
                    </div>
                </div>
                </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="top2" role="tabpanel" aria-labelledby="top2-tab">
            <div class="products products-2">
                @foreach ($products36b as $p)
                <div class="slider-product">
                <!-- Product Image -->
                <div class="slider-product-image">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img class="image-item" src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}" />
                    </a>
                    <div class="instock-text"><i class="fa fa-solid fa-check"></i> In Stock</div>
                    <div class="product-limited-text">Limited Time Offer!</div>
                </div>
                <!-- name -->
                <div class="slider-product-info">
                    <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                        {{ Str::limit($p->title, 40) }}
                    </a>
                <!-- Price -->
                <div class="slider-product-info2">
                    <div class="slider-product-price">
                    ${{number_format((float)$p->retail_price, 2, '.', '')}} <span class="cutout-price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                    </div>
                    <div class="percent-off">Upto 55% Off</div>
                </div>

                <!-- Star ratings -->
                <div class="slider-product-info2">
                    <div class="slider-product-review">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <img class="review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                    <div class="review-points">4.5 </div>
                    </div>
                    <!-- Cart Icon -->
                    <div class="slider-product-cart">
                        <a href="{{ route('add.to.cart1', $p->sku) }}">
                            <i class="fa fa-solid fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
                </div>
                </div>
                @endforeach
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
      Featured Blogs
    </h2>

    <div class="blogs">
      @foreach ($latest_blogs as $blog)

      <div class="blog blog-1">
        <div class="blog-head">
          <img class="blog-img" src="{{ asset('public/images/blog/' . $blog->image) }}" alt="">
          <div class="blog-tag">
            <span>
              Admin - Nature Checkout
            </span>
          </div>
        </div>
        <div class="blog-data">
          <a href="">
            <div class="blog-title">
              {{ Str::limit($blog->title, 40) }}
            </div>
          </a>
          <div class="blog-info">
            <div class="blog-author">
              <span>
                Posted by
              </span>
              <div class="blog-info-author-img">
                <img src="public/wb/img/new_homepage/blog-author.jpg" alt="">
              </div>
            </div>
            <a href="#">
              Admin
            </a>
            {{-- <a href="">
              <i class="fa fa-solid fa-comment"></i>
            </a>
            <a href="">
              <i class="fa fa-solid fa-share"></i>
            </a> --}}
          </div>
          <div class="blog-desc">
            {{ Str::limit($blog->description, 130) }}
          </div>
          <a href="{{ route('nature-blog-detail', ['id' => $blog->id]) }}" class="blog-link">CONTINUE READING</a>
        </div>
      </div>
      @endforeach

      {{-- <div class="blog blog-1">
        <div class="blog-head">
          <img class="blog-img" src="{{ asset('public/images/blog/' . $blog->image) }}" alt="">
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
              <div class="blog-info-author-img">
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
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores sequi quam distinctio velit quam distinctio
            velit quaerat ratione...
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
              <div class="blog-info-author-img">
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
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores sequi quam distinctio velit quam distinctio
            velit quaerat ratione...
          </div>
          <a href="" class="blog-link">CONTINUE READING</a>
        </div>
      </div> --}}


    </div>
  </div>

</div>

<!-- Blogs End -->

    <script>
    // Product image slider script
    const initSlider = () => {
    const imageList = document.querySelector(".slider-wrapper .image-list");
    const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
    const sliderScrollbar = document.querySelector(".slider-container .slider-scrollbar");
    const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
    const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;

    // Handle scrollbar thumb drag
    scrollbarThumb.addEventListener("mousedown", (e) => {
        const startX = e.clientX;
        const thumbPosition = scrollbarThumb.offsetLeft;
        const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;

        // Update thumb position on mouse move
        const handleMouseMove = (e) => {
            const deltaX = e.clientX - startX;
            const newThumbPosition = thumbPosition + deltaX;

            // Ensure the scrollbar thumb stays within bounds
            const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
            const scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;

            scrollbarThumb.style.left = `${boundedPosition}px`;
            imageList.scrollLeft = scrollPosition;
        }

        // Remove event listeners on mouse up
        const handleMouseUp = () => {
            document.removeEventListener("mousemove", handleMouseMove);
            document.removeEventListener("mouseup", handleMouseUp);
        }

        // Add event listeners for drag interaction
        document.addEventListener("mousemove", handleMouseMove);
        document.addEventListener("mouseup", handleMouseUp);
    });

    // Slide images according to the slide button clicks
    slideButtons.forEach(button => {
        button.addEventListener("click", () => {
            const direction = button.id === "prev-slide" ? -1 : 1;
            const scrollAmount = imageList.clientWidth * direction;
            imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
    });

     // Show or hide slide buttons based on scroll position
    const handleSlideButtons = () => {
        slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
        slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
    }

    // Update scrollbar thumb position based on image scroll
    const updateScrollThumbPosition = () => {
        const scrollPosition = imageList.scrollLeft;
        const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
        scrollbarThumb.style.left = `${thumbPosition}px`;
    }

    // Call these two functions when image list scrolls
    imageList.addEventListener("scroll", () => {
        updateScrollThumbPosition();
        handleSlideButtons();
    });
}

window.addEventListener("resize", initSlider);
window.addEventListener("load", initSlider);
    </script>



<!-- Newsletter Popup start -->
<div class="newsletter-popup">
  <div class="newsletter">
    <div class="newsletter-inner"></div>
    <h4>Connect to Nature Checkout & get </h4>
    <h2>Get upto 30% Off!
    </h2>
    <p>Be the first one to know about our Special offers and get upto 30% <br> Discount Coupon instantly!
    </p>
    <i class="fa fa-solid fa-close newsletter-close-icon"></i>
    <form action="{{ route('sub-newsletter') }}" method="POST" class="newsletter-form">
      @csrf
      <input type="text" name="name" placeholder="Name">
      <input type="email" name="email" placeholder="Email">
      <button class="button" type="submit">Subscribe</button>
      <div class="newsletter-footer">
        <i>
          By signing up, you agree to our <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
        </i>
        <i>
          Discount coupon will be emailed to your address.
        </i>
      </div>
    </form>
  </div>
</div>


 <!-- Someone bought a product popup -->
 <div class="bought-product-popup">
    @if($product_s)
        <div class="bought-product-image">
            <img src="{{ $product_s->original_image_url }}" alt="">
        </div>
        <i class="fa fa-solid fa-close bought-close-icon"></i>

        <div class="bought-product-info">
            <div class="bought-product-text">
                Someone bought <a href="{{ route('product-detail',['slug' => $product_s->slug, 'sku' => $product_s->sku]) }}">{{ Str::limit($product_s->title, 100) }}</a>
            </div>
            <div class="bought-product-time">
                <div class="slider-product-review">
                    <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                    <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                    <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                    <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                    <img class="review-star" src="{{ asset('public/wb/img/new_homepage/icons/star.png') }}" alt="">
                    <div class="review-points">4.5 </div>
                </div>
                27 Minutes Ago
            </div>
        </div>
    @endif
  </div>



<script>

  let newsletterPopupShown = localStorage.getItem('newsletterShown');

  if(!newsletterPopupShown){
    $(".newsletter-popup").css("display", "flex");
  }
  
  $(".newsletter-close-icon").click(() => {
    $(".newsletter-popup").css("display", "none")
    localStorage.setItem('newsletterShown', true);
  })

  $(".bought-close-icon").click(() => {
    $(".bought-product-popup").css("display", "none")
  })
  
  setInterval(() => {
    $(".bought-product-popup").css("display", "flex")
    setTimeout(()=>{
      $(".bought-product-popup").css("display", "none")
    }, 5*1000)
  }, 13*1000);

</script>
<!-- Newsletter Popup end -->
@endsection

@section('title', 'One-Stop E-commerce hub for online selling, in-store buying and self-checkout.')
@section('description', 'Nature checkout, a free mobile app that provides safe and convenient grocery shopping during
post pandemic- Smart grocery app - Free delivery Nature checkout - buy groceries online – grocery stores online
services')
@section('keywords', 'Smart grocery app store near me, Free delivery Nature checkout, Closest store near me Nature
checkout, Shop groceries stores online, Mobile app for grocery shopping, Smart in-store shopping app, Get online coupon
from Nature checkout, Scan and go mobile app from Nature checkout, Smart way to buy and sell online from Nature
checkout, Smart and convenient shopping mobile app from Nature checkout, Best way to sell, Sell online, Online sells,
Online seller, E-commerce selling, Ecommerce sells, Sales hub, Where to sell, Sell on instacart, Sell on Etsy, Sell on
Amazon, Best place to sell, Where to sell, Best Buy and sell center')
