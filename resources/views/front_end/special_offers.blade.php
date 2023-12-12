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
                        <h3>Special Offers</h3>
                    </div>
                    <div class="product_tab_btn">

                    </div>
                </div>
            </div>
        </div>

        <div class="container">
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
</div>
</div>
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


@section('title', 'Special Offers')
