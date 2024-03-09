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
                        <h3>New Arrivals</h3>
                    </div>
                    <div class="product_tab_btn">

                    </div>
                </div>
            </div>
        </div>
        <div class="products trending-products">
            @foreach($products['goodsList'] as $p)
            <div class="product">
                <a href="https://shop.naturecheckout.com/product-detail/{{ $p['spuId'] }}">
                    <img src="{{ $p['pictureUrl'] }}" alt="{{ Str::limit($p['title'], 35) }}" class="product-img product-img-1">
                </a>
                <a href="https://shop.naturecheckout.com/product-detail/{{ $p['spuId'] }}">
                    <img src="{{ $p['pictureUrl'] }}" alt="{{ Str::limit($p['title'], 35) }}" class="product-img product-img-2">
                </a>
                <div class="product-info">
                    <h3 class="product-name">
                        {{ Str::limit($p['title'], 40) }}
                    </h3>
                    {{-- <h4 class="product-category">
                        {{ $p->w2b_category_1 }}
                    </h4> --}}
                    <p class="product-price">
                        ${{ number_format((float)$p['maxPrice'], 2, '.', '') }}
                    </p>
                </div>
                <div class="product-actions">
                    <a class="button product-button" href="https://shop.naturecheckout.com/product-detail/{{ $p['spuId'] }}">ADD TO CART</a>
                </div>
            </div>
        @endforeach


        </div>
        @php
            $totalPages = $productData['totalPages'];
            $currentPage = $productData['currentPage'];
            $maxPagesToShow = 8; // Adjust this value to control the number of page links to display
        @endphp

        @if($totalPages > 1)
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ url('new-arrivals?page=1') }}" aria-label="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                    @endif

                    @for($i = max(1, $currentPage - floor($maxPagesToShow / 2)); $i <= min($totalPages, $currentPage + floor($maxPagesToShow / 2)); $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ url('new-arrivals?page=' . $i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link" href="{{ url('new-arrivals?page=' . $totalPages) }}" aria-label="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif

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


@section('title', 'Trending Products')
