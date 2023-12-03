@extends('front_end.layout')
@section('content')



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
                        <p>Simply return it within 30<br>
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

<!--product area start-->
<div class="product_area treew  mb-64">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title">
                        <h3>Trending Products</h3>
                    </div>
                    <div class="product_tab_btn">

                    </div>
                </div>
            </div>
        </div>
        <div class="products">
            @foreach ($products as $p)

            <div class="product">
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}"
                        class="product-img product-img-1">
                </a>
                <a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">
                    <img src="{{$p->original_image_url}}" alt="{{ Str::limit($p->title, 35) }}"
                        class="product-img product-img-2">
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
        {{ $products->links() }}
    </div>
</div>


 <!-- THIS SECTION WILL BE MOVED TO A NEW PAGE /FAQs -->
 <div class="faq-section">
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

        <!-- FAQS END -->
<!--product area end-->
@endsection

@section('scriptss')
<script>
    $("a#fake_anchor").click(function () {
        $("#submit_this_anchor").submit();
        return false;
    });
</script>


@endsection


@section('title', 'Trending Products')
