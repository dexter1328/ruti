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
                        <p>Simply reture it within 30<br>
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
        <div class="row mt-60">
            <div class="col-12">
                <div class="product_header">
                    <div class="page_amount">
                        <h4>Showing result(s)</h4>
                    </div>
            </div>
            </div>
        </div>
        <div class="product_container">
            <div class="row">
                    @foreach ($products as $p)

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12" style="padding-bottom: 35px">
                    <article class="single_product">
                        <figure>
                            <div class="product_thumb">
                                <a class="primary_img" href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}"><img src="{{$p->large_image_url_250x250}}" alt=""></a>
                                <a class="secondary_img" href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}"><img src="{{$p->large_image_url_250x250}}" alt=""></a>
                                <div class="label_product">
                                    <span class="label_sale">Sale</span>

                                </div>
                                <div class="action_links">
                                    <ul>
                                        <li class="add_to_cart"><a href="{{ route('add.to.cart1', $p->sku) }}" title="Add to cart"><span class="lnr lnr-cart"></span></a></li>
                                        {{-- <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box"  title="quick view"> <span class="lnr lnr-magnifier"></span></a></li> --}}
                                        @if(Auth::guard('w2bcustomer')->user())
                                        <li class="wishlist"><a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist"><span class="fa fa-heart"></span></a></li>
                                        @endif
                                     {{-- <li class="compare"><a href="#" title="Add to Compare"><span class="lnr lnr-sync"></span></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <figcaption class="product_content">
                                <h4 class="product_name double-lines-ellipsis"><a href="{{ route('product-detail',['slug' => $p->slug, 'sku' => $p->sku]) }}">{{ Str::limit($p->title, 30) }}</a></h4>
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
                <br><br>
                {!! $products->links() !!}

            </div>
    </div>
</div>
<!--product area end-->
@endsection

@section('scriptss')
<script>
    $("a#fake_anchor").click(function()
    {
    $("#submit_this_anchor").submit();
    return false;
    });
</script>


<script type="text/javascript">
    var route = "{{ url('/shop/search/autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
      return $.get(route, { term: query }, function (data) {
              return process(data);
          });
      }
    },
      {
        hint: true,
        highlight: true,
        minLength: 1
        },
      );
</script>

@endsection
