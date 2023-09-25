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
                       <h3>{{$cat_name}} Items</h3>
                    </div>
                    <div class="product_tab_btn">

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-20">
            <div class="col-12">
                <div class="product_header">
                        <div class="page_amount">
                            <h4>Showing results for {{$cat_name}}</h4>
                        </div>
                </div>
            </div>
        </div>
        <div class="product_container">
            <div class="row">
                    @foreach ($products as $p)

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12"style="padding-bottom: 35px" >
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
                                        {{-- <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box"  title="quick view"> <span class="lnr lnr-magnifier"></span></a></li> --}}
                                        @if(Auth::guard('w2bcustomer')->user())
                                        <li class="wishlist"><a href="{{route('wb-wishlist', $p->sku)}}" title="Add to Wishlist"><span class="fa fa-heart"></span></a></li>
                                        @endif
                                     {{-- <li class="compare"><a href="#" title="Add to Compare"><span class="lnr lnr-sync"></span></a></li> --}}
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
                <br><br>
                {!! $products->links() !!}

            </div>
            <div class="mt-5">
                @include('front_end.cat_content')
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

@if ($cat_name == 'Accessories')

    @section('title', 'Discover Nature Checkout, Haven for Men’s & Women’s Fashion Accessories')
    @section('description', 'Want to shop women’s & men’s fashion accessories at your convenience? Get ready for a seamless online shopping experience & redefine your style')
    @section('keywords', 'women\'s fashion accessories, men\'s fashion accessories, ultra thin socks, breastfeeding scarf, clothing/shoe/accessory stores, Heated Body Pillow, body pillow with heater')

@elseif($cat_name == 'Costumes & Props')

    @section('title', 'Explore Nature Checkout: The Hub of unique Cartoon Costumes & Props')
    @section('description', 'Looking to shop a diverse range of cartoon costumes for adults & kids at your convenience? Prepare yourself for a seamless online shopping experience that will ensure your event becomes truly memorable.')
    @section('keywords', 'cartoon costumes for adults, cartoon costumes, cartoon characters costumes, halloween cartoon costumes, cartoon costumes for women, female cartoon character outfits, sexy cartoon costumes, woman fire fighter costume')

@elseif($cat_name == 'Travel & Bags')

    @section('title', 'Flaunt with Nature Checkout’s captivating little women tote bag & western makeup bags to redefine your style.')
    @section('description', 'If you are looking for trendy bags, we have got you covered. Discover a diverse collection of bags at Nature checkout including Boho bags, Tote Bags, Wallets & Traveller’s bags.')
    @section('keywords', 'western makeup bags, little women tote bag, colombian leather bag, boho bags, what is a tote bag, denim tote bag, tote bag women, tote bag nursing, nurse tote bag, bi fold women\'s wallet, tri fold leather wallet, foldable dry/wet separation travel bag, traveller\'s bag ')

@elseif($cat_name == 'Grocery')

    @section('title', 'Nature Checkout: A one-stop online shop for your daily use grocery.')
    @section('description', 'Searching for a reliable grocery delivery service?Look no further, Nature Checkout provides a convenient solution for your daily use grocery and late night cravings at your doorstep so order cheap snacks online and enjoy.')
    @section('keywords', 'order snacks online, cheap snacks online, cholula chipotle hot sauce, cholula hot sauce, cholula hot sauce gluten free, late night keto snacks, daily use grocery, grocery delivery service')

@elseif($cat_name == 'Home, Garden & Furniture')

    @section('title', 'Decorate your home with unique home decorative items available at the doorstep.')
    @section('description', 'Want to know how to decorate a bedroom with slanted walls? At Nature checkout, find top selling home decor items, garden decoration items, eco friendly kitchen products & a lot more to discover trendy decor ideas and add style to your space.')
    @section('keywords', 'unique home decorative items, top selling home decor items, wooden home decor items, crystal home decor items, garden decoration items, bedroom door decorations, how to decorate a bedroom with slanted walls, comforter sets with decorative pillows, luxury pillows for sofa, fall throw pillows, eco friendly kitchen products, sustainable kitchen products, commercial kitchen cleaning products')

@elseif($cat_name == 'Health & Beauty')

    @section('title', 'Find the most authentic & original collection of beauty products for women at Nature Checkout.')
    @section('description', 'Whether you want to buy reliable basic makeup products, aesthetic makeup products, professional health products or any beauty products for women, Nature Checkout has got you covered. The good news is one-click online delivery at your doorstep.')
    @section('keywords', 'beauty products for women, cosmetics for women, cosmetic travel bags for women, hunchback posture corrector, professional health products, health line massage products, aesthetic makeup products, basic makeup products, high porosity hair products, ultrasonic humidifier, best organic skin care products, vegan skin care products, aesthetic skin care products')

@elseif($cat_name == 'Vitamins & Supplements')

    @section('title', 'Elevate your quality of life by using the Nature Checkout best vitamin e supplements')
    @section('description', 'Nature Checkout’s handpicked best vitamin E supplements, organic vitamin C supplements and organic vitamin D supplements are key to live a healthy and prosperous life all available at one online destination. Not only this, we also have a collection of supplements to treat acute diseases like migraine and acne etc')
    @section('keywords', 'best vitamin e supplements, organic vitamin c supplement, suppliment for acne, organic vitamin d supplement, herbal iron supplement, herbal supplements for migraines')

@elseif($cat_name == 'Jewelry')

    @section('title', 'Checkout is delighted to introduce a striking collection of gold plated and silver plated jewellery.')
    @section('description', 'Redefine your style and order gold plated brass jewellery, silver plated jewellery, indian jewellery & stainless steel jewellery online. Find exquisite Neck Jewellery, Earings, Bangles, Anklets & What not. We are sure you will fall in love with our timeless pieces')
    @section('keywords', 'neck jewellery, brass jewellery, brass jewelry, gold plated brass jewelry, silver indian jewelry, silver plated jewelry, brass ring jewelry, how to clean stainless steel jewelry, stainless steel jewelry')

@elseif($cat_name == 'Eyewear')

    @section('title', 'Enhance your vision with our unique collection of women’s reading glasses & men’s reading glasses.')
    @section('description', 'Whether it is about style or vision, We have got you covered. Check the amazing range of ray ban women’s glasses, women’s safety glasses, browline as well as men’s reading glasses, sun glasses & computer glasses all at a single destination online.')
    @section('keywords', 'women\'s reading glasses, ray ban women\'s glasses, women\'s safety glasses, women\'s square glasses frames, women\'s browline glasses, women\'s shooting glasses, women\'s bifocal reading glasses, metal frame glasses women\'s, women\'s rimless reading glasses, men\'s reading glasses, gold frame glasses men\'s, men\'s bifocal reading glasses, men\'s computer glasses')

@elseif($cat_name == 'Pet Supplies')

    @section('title', 'Welcome to Nature Checkout - Your Source for Perfect Pet Accessories')
    @section('description', 'If you are looking for the perfect pet accessories and want them to be delivered right at your doorstep, You are just a few steps away! We have wooden pet house, decorative bird cage, outdoor cat house and everything you need to pamper your lovely friends.')
    @section('keywords', 'wooden pet house, painted dog house, wooden outdoor cat house, wooden cat house, perfect pet accessories, decorative bird cage, bird travel cage, outdoor bird cage, pet stainless steel bowls, dog bowls made in usa, stainless steel water buckets for dogs')

@elseif($cat_name == 'Sports Fan Gifts')

    @section('title', 'Simplify your search for sports gifts for boys & girls at Nature Checkout.')
    @section('description', 'Make your loved one’s events memorable with unique & useful sports fan gifts available at Nature Checkout online shopping store. Buy cool wall clocks, custom car gifts & a lot more to show love and association to your dear friends & acquaintances.')
    @section('keywords', 'sports gifts for boys, unique wall clocks, cool wall clocks, gift for car guys, men\'s rope bracelets, personalized car gifts, custom car gifts, useful car accessories')

@endif

