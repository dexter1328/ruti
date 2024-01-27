@extends('front_end.layout')
@section('content')
@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif


<!--product details start-->
<div class="product_details mt-70 mb-70">

    <div class="product-page-banners">
      <div class="product-page-banner product-page-banner-1">
        <img src="{{asset('public/wb/img/new_homepage/misc/product-page-banner-1.jpg')}}" alt="product-page-banner">
      </div>
      <div class="product-page-banner product-page-banner-2">
        <img src="{{asset('public/wb/img/new_homepage/misc/product-page-banner-2.jpg')}}" alt="product-page-banner">
      </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="product-details-tab" style="max-width: 450px; width: 100%;">
                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            <img id="zoom1" src="{{$product->original_image_url}}" data-zoom-image="{{$product->original_image_url}}" alt="{{ Str::limit($product->title, 35) }}">
                        </a>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->original_image_url}}" data-zoom-image="{{$product->original_image_url}}">
                                    <img src="{{$product->original_image_url}}" alt="{{ Str::limit($product->title, 35) }}"/>
                                </a>

                            </li>
                            @if ($product->extra_img_1)
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_1}}" data-zoom-image="{{$product->extra_img_1}}">
                                    <img src="{{$product->extra_img_1}}" alt="{{ Str::limit($product->title, 35) }}"/>
                                </a>

                            </li>
                            @endif
                            @if ($product->extra_img_2)
                            <li >
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_2}}" data-zoom-image="{{$product->extra_img_2}}">
                                    <img src="{{$product->extra_img_2}}" alt="{{ Str::limit($product->title, 35) }}"/>
                                </a>

                            </li>
                            @endif
                            @if ($product->extra_img_3)
                            <li >
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{$product->extra_img_3}}" data-zoom-image="{{$product->extra_img_3}}">
                                    <img src="{{$product->extra_img_3}}" alt="{{ Str::limit($product->title, 35) }}"/>
                                </a>

                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 mt-4 mt-lg-0">
                <div class="product_d_right">
                        <span class="shop-details-content"><i class="lnr lnr-checkmark-circle"></i>In Stock</span>
                        <span class="shop-details-content trending-right-now-text"><i class="fa fa-solid fa-fire"></i>Trending right now</span>
                        <h1 ><a href="#" style="font-size: 2rem">{{$product->title}}</a></h1>
                        <div class=" product_ratting">

                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="price_box">
                                <span class="current_price">${{number_format((float)$product->retail_price, 2, '.', '')}}</span>

                            </div>
                        </div>

                      <!-- Star ratings -->
                      <div class="product-reviews-container">
                        <div class="product-reviews">
                          <img class="product-review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                          <img class="product-review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                          <img class="product-review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                          <img class="product-review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                          <img class="product-review-star" src="{{asset('public/wb/img/new_homepage/icons/star.png')}}" alt="">
                          <div class="review-points">4.5 <span>(342)</span></div>
                        </div>
                        @if (Auth::guard('w2bcustomer')->user())
                       <div class="shop-details-Wishlist">
                            <ul>
                                <li><a href="{{route('wb-wishlist', $product->sku)}}"><i class="lnr lnr-heart"></i><p>Add to Wishlist</p></a></li>

                            </ul>
                        </div>
                        @else
                        <div class="shop-details-Wishlist">
                            <ul>
                                <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal29"><i class="lnr lnr-heart"></i><p>Add to Wishlist</p></a></li>

                            </ul>
                        </div>
                        @endif
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
                       <div class="category-type">
                            <ul>
                                <li>
                                    Seller Name:
                                </li>
                                <li>
                                    {{ $product->vendor->id == 1 ? 'Nature Checkout' : $product->vendor->name }}
                                </li>
                            </ul>
                        </div>



                        <div class="quantity-option">

                          <div class="">
                              <a class="btn btn-secondary-orange" href="{{ route('add.to.cart', $product->sku) }}"  >add to cart</a>
                              <a class="btn btn-primary-blue" href="{{ route('product-shop') }}" >Back To Shopping</a>
                          </div>

                          <div class="mr-4 d-flex">
                              <form class="" action="{{ route("vote-best-seller") }}"  method="POST">
                                  @csrf
                                  <input type="hidden" name="vendor_id" value="{{$product->vendor_id}}">

                                  <span class="tooltip-container mr-3">
                                  <button class="btn_vote btn-secondary-orange" type="submit"><img src="{{asset('public/wb/img/icons/profile-user.png')}}" width="25px" height="25px" alt=""></button>
                                  <div class="tooltip-message">Vote for best seller.</div>
                                  </span>
                              </form>
                              <form class="" action="{{ route("vote-best-product") }}"  method="POST">
                                  @csrf
                                  <input type="hidden" name="product_sku" value="{{$product->sku}}">

                              <span class="tooltip-container">
                                  <button class="btn_vote btn-primary-blue"  type="submit"><img src="{{asset('public/wb/img/icons/box.png')}}" width="25px" height="25px" alt=""></button>
                                  <div class="tooltip-message">Vote for best product.</div>
                              </span>
                              </form>
                          </div>

                        </div>

                        <div class="product_d_action mt-4">
                            <h4>Share This Product</h4>
                         </div>
                        <div class="container mt-2 ">
                            {!! $shareComponent !!}
                        </div>


                        <div class="shipping-details">
                          <h4><i class="fa fa-solid fa-truck"></i>Shipping</h4>
                          <div class="shipping-details-boxes">
                            <div class="shipping-details-box">
                              <h5>Standard: calculated on all orders</h5>
                              <div class="shipping-details-info">
                                Delivery: <span>Jan 19-24, 79.6% are < 11 days</span>
                              </div>
                              <div class="shipping-details-info">
                                Courier Company: <span>USPS, UPS</span>
                              </div>
                            </div>
                            <div class="shipping-details-box">
                              <h5>Standard: calculated on all orders</h5>
                              <div class="shipping-details-info">
                                Delivery: <span>Jan 19-24, 79.6% are < 11 days</span>
                              </div>
                              <div class="shipping-details-info">
                                Courier Company: <span>USPS, UPS</span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="shipping-details">
                          <h4><i class="fa fa-solid fa-truck"></i>Safe & Secure</h4>
                          <div class="shipping-details-boxes">
                            <div class="shipping-details-box">
                              <h5>Customer Service</h5>
                              <div class="shipping-details-info">
                                The support center has answers to questions you may have. You can also contact customer service in the support center if you can't find what you're looking for. 
                              </div>
                            </div>
                            <div class="shipping-details-box">
                              <h5>Sustainability</h5>
                              <div class="shipping-details-info">
                                As part of our ongoing commitment to environmental sustainability, Temu has partnered with Trees for the Future to plant trees across Africa to create a positive impact on the environment, air, and local communities. 
                              </div>
                            </div>
                          </div>
                        </div>
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

                        <div class="tab-pane fade" id="reviews" role="tabpanel" >
                            <div class="reviews_wrapper">
                                <div class="container">
                                        <h2>{{$ratings->count()}} review for this product</h2>
                                        @foreach ($ratings as $rating)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb">
                                                <img src="{{asset('public/wb/img/blog/comment2.jpg')}}" alt="comment">
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

<!--product info end-->


<h3 class='sections_coupons_header like_products_heading p-2' >Products You may also like</h3>

<!-- Product Slider -->

        <!-- Products Slider -->
        <!-- Please add only 10 products -->
        <div class="slider-container">
      <div class="slider-wrapper">
        <button id="prev-slide" class="slide-button material-symbols-rounded">
          chevron_left
        </button>
        <ul class="image-list">

            @foreach ($related_productss as $p)
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
                  <a href="{{ route('add.to.cart', $p->sku) }}">
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



<!--product area start-->
<section class="product_area related_products">

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
                        <a class="primary_img" href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}"><img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}"></a>
                        <a class="secondary_img" href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}"><img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}"></a>
                        <div class="label_product">
                            <span class="label_sale">Sale</span>

                        </div>
                        <div class="action_links">
                            <ul>
                                <li class="add_to_cart"><a href="{{ route('add.to.cart1', $p->sku) }}" title="Add to cart"><span class="lnr lnr-cart"></span></a></li>

                                @if(Auth::guard('w2bcustomer')->user())
                                <li class="wishlist"><a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist"><span class="fa fa-heart"></span></a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    <figcaption class="product_content">
                        <h4 class="product_name double-lines-ellipsis"><a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">{{ Str::limit($p->title, 35) }}</a></h4>
                        <h5 class='text-left'><i class='fa fa-check'></i> In Stock</h5>
                        <div class="price_box">
                            <span class="current_price">${{number_format((float)$p->retail_price, 2, '.', '')}}</span>
                        </div>
                        <a href="{{ route('add.to.cart1', $p->sku) }}"><button class='btn btn-primary rounded p-2 my-2 w-100 cart_btn'>Add to Cart</button></a>
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
        $('.alert-danger').fadeOut('fast');
        }, 3000);

    });

</script>

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


@section('title', $product->meta_title)
@section('description', $product->meta_title)
@section('keywords', $product->meta_keywords)
