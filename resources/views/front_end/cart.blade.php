@extends('front_end.layout')
@section('content')

<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>Cart</h3>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
@if(session('success'))
<div class="container alert alert-success text-center">
  {{ session('success') }}
</div>
@endif


<div class='row w-100 justify-content-between ml-0 p-5'>
    <div class="col-12 order_main px-0 border">
        <div class='d-flex justify-content-between p-3 border orders_header'>
            <div class='orders_header1 d-flex justify-content-between w-100'>
                <div class='width-20'>
                    Product
                </div>
                <div class='width-20'>
                    Product Name
                </div>
                <div class='width-20'>
                    Quantity
                </div>
                <div class='width-20'>
                   Price
                </div>

                <div  class='width-20'>
                   Total Price
                </div>
            </div>
        </div>
        <div class="orders_body p-3">
            @php $total = 0 @endphp
            @if(session('cart'))
            @foreach(session('cart') as $sku => $details)
            @php $total += $details['retail_price'] * $details['quantity'] @endphp

            <div data-id="{{ $sku }}" class='w-100 justify-content-between order_tab d-flex mt-4 sku-class'>

                <div class='width-20'>
                    <a role="button" class="remove-from-cart"><i class="fa fa-trash-o"></i></a>
                    <img src="{{ $details['original_image_url'] }}" class='table_product_image ml-4' alt="{{ Str::limit($details['title'], 35) }}">
                </div>
                <div class='px-2 width-20 image_title'>
                    <span>{{ Str::limit($details['title'], 35) }}</span>
                    <br>
                    {{-- <button class='border buy_again'>Buy it again</button> --}}
                </div>
                <div class='width-20'>
                    <span><input min="1" max="100" class="quantity update-cart" value="{{$details['quantity']}}" type="number"></span>
                </div>
                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'], 2, '.', '')}}</span>
                </div>

                <div class='width-20'>
                    <span>${{number_format((float)$details['retail_price'] * $details['quantity'], 2, '.', '')}}</span>
                </div>

            </div>
            @endforeach
            @endif
        </div>
        <div class="orders_footer border-top text-right p-2">
            <button class="checkout_btn mr-3 p-0 border-0">
                <a class='' href="{{ route('remove-everything') }}">Remove Everything</a>
            </button>
        </div>
    </div>
    <div class="coupon_area mt-5 col-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                               <div class="cart_subtotal">
                                   <p>Subtotal</p>
                                   <p class="cart_amount">${{number_format((float)$total, 2, '.', '')}}</p>
                               </div>
                               <hr>
                               {{-- <div class="cart_subtotal ">
                                   <p>Shipping</p>
                                   <p class="cart_amount"><span>Flat Rate:</span> £255.00</p>
                               </div>
                               <a href="#">Calculate shipping</a> --}}

                               <div class="cart_subtotal">
                                   <p>Total</p>
                                   <p class="cart_amount">${{number_format((float)$total, 2, '.', '')}}</p>
                               </div>
                               <div class="checkout_btn">
                                    <a href="{{ route('product-shop') }}">Back to Shopping</a>
                                   <a href="{{ route('product-checkout') }}">Proceed to Checkout</a>
                               </div>
                               {{-- <div class="checkout_btn">
                                <a href="{{ route('product-shop') }}">Back to Shopping</a>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='main_parent_div border col-lg-8 col-sm-12 m-auto px-4'>
                <h3 class='sections_coupons_header like_products_heading p-2' >Products You may like</h3>
        <!-- Products Slider -->
        <!-- Please add only 10 products -->
        <div class="slider-container">
      <div class="slider-wrapper">
        <button id="prev-slide" class="slide-button material-symbols-rounded">
          chevron_left
        </button>
        <ul class="image-list">

        <!-- Slider product -->
        @foreach ($suggested_products as $p)
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
            </div>
    </div>

@endsection

@section('scriptss')

<script type="text/javascript">

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                sku: ele.parents(".sku-class").attr("data-id"),
                quantity: ele.parents(".sku-class").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    sku: ele.parents(".sku-class").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

    $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 3000);

    });


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

@endsection
