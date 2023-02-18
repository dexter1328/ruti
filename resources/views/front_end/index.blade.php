@extends('front_end.layout')
@section('content')

<!-- Body Start -->
    <!-- Home Banner Start -->
    <!-- <section id="home" class="home-banner">
        <div class="container">
            <div class="row full-screen align-items-center">
                <div class="col-10 col-sm-7 col-lg-5 col-md-5 pr0">
                    <div class="home-text-center">
                        <h5 class="font-alt ban-txt">
                            {!! isset($page_meta['header_title']) && $page_meta['header_title']!='' ? $page_meta['header_title'] : 'A smart <span>shopping experience</span> Right In Your Hand' !!}

                        </h5>
                        <ul class="banner-icon banner-icon-new">
                            <li class="apple">
                                <img src="{{ asset('public/frontend/image/ios_qrcode.png')}}" alt="">
                            </li>
                            <li>
                                <img src="{{ asset('public/frontend/image/android_qrcode.png')}}" alt="">
                            </li>
                        </ul>
                        <ul class="banner-icon"  style="margin-top: 111px">
                            <li class="apple"><a href="{{isset($page_meta['header_ios_app_link']) && $page_meta['header_ios_app_link']!='' ? $page_meta['header_ios_app_link'] : '#'}}" target="_blank"><i class="fa fa-apple"></i></a>
                            </li>
                            <li><a href="{{isset($page_meta['header_android_app_link']) && $page_meta['header_android_app_link']!='' ? $page_meta['header_android_app_link'] : '#'}}" target="_blank"><i class="fa fa-android"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 no-padding banner-img d-md-block d-none">
                    @if(isset($page_meta['header_image']) && $page_meta['header_image']!='')
                        <img src="{{asset('public/images/pagemeta/'.$page_meta['header_image'])}}" class="img-fluid" alt="">
                    @else
                        <img src="{{asset('public/frontend/image/banner-tab-image.png')}}" class="img-fluid" alt="">
                    @endif
                </div>
            </div>
        </div>
    </section> -->
    <!-- Home Banner End -->

    <!-- About us start -->
    <section id="aboutus" class="section aboutus mt-4">
        <h2 class="heading">
            {{isset($page_meta['about_title']) && $page_meta['about_title']!='' ? $page_meta['about_title'] : 'About RUTI self checkout'}}
        </h2>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="font-para about-left">
                        @if(isset($page_meta['about_description']) && $page_meta['about_description']!='')
                            {!! $page_meta['about_description'] !!}
                        @else
                            <p>How many times have  you been in a long checkout line and finally reached the front, only to realize that you forgot the item that brought you to the store in the first place? You're then faced with the decision to waste your time either backtracking and losing your place in line, or coming back to the store at a later time. Time and money are finite resources that everyone wants more of, RUTI self checkout saves both.</p>
                            <p>RUTI self checkout  is  a  revolutionary  new  mobile  application  which  combines  the  convenience  of  online shopping with the hands-on in store shopping experience. The innovative mobile application, or "app",  is  specially  designed  to  provide  both  merchants  and  consumers  with  an  easier  more efficient purchasing and selling experience by eliminating the need to wait in line.  Consumers will  save  time  by  avoiding  checkout  lines  at  grocery  markets,  retail  stores,  restaurants,  and events such as concerts and plays. Merchants will maximize their profit potential by increasing the amount of transactions they can accommodate, by shortening grocery and retail store lines, quickly turning over restaurant customers, and reaching a wider consumer base.</p>
                         @endif
                    </div>
                </div>
                <div class="col-md-5 side-video">
                    <div class="about-ss video-watch detail-side-video">
                        @if(isset($page_meta['about_image']) && $page_meta['about_image']!='')
                            <img src="{{asset('public/images/pagemeta/'.$page_meta['about_image'])}}" class="img-fluid" alt="">
                        @else
                            <img src="{{asset('public/frontend/image/about-ss-with-phone.png')}}" class="img-fluid" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About us end -->

    <!-- Vendors start -->
    <section id="vendors" class="vendors">
        <h2 class="heading">
            {{isset($page_meta['vendors_title']) && $page_meta['vendors_title']!='' ? $page_meta['vendors_title'] : 'Vendors'}}
        </h2>
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    @if(isset($page_meta['vendors_description']) && $page_meta['vendors_description']!='')
                        {!! $page_meta['vendors_description'] !!}
                    @else
                        <p>RUTI self checkout's Business Philosophy of “Saving Time, Saving Money, and Saving the Environment” is catered to give Vendors Optimal Benefit.</p>
                    @endif
                </div>
                <div class="col-md-12 vendors-inner">
                    <div class="vendors-slick">
                        @php $vendors = [];
                        if(isset($page_meta['vendors_content']) && $page_meta['vendors_content']!=''){
                            $vendors = json_decode($page_meta['vendors_content']);
                        }
                        @endphp
                        @if(!empty($vendors))
                            @php $i = 0; @endphp
                            @foreach($vendors as $vendor)
                                <div class="col-md-4 @if($i==1) text-left @endif">
                                    <div class="vendors-details">
                                        <img src="{{asset('public/images/pagemeta/'.$vendor->image)}}" alt="" class="vendorImage" />
                                        <h5>{{$vendor->name}}</h5>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="col-md-4 text-left">
                                <div class="vendors-details">
                                    <img src="{{ asset('public/frontend/image/brand-name/kroger.png')}}" alt="" />
                                    <h5>kroger</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="vendors-details">
                                    <img src="{{ asset('public/frontend/image/brand-name/fresh-by-honestbee.png')}}" alt="" />
                                    <h5>Fresh Supermarket</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="vendors-details">
                                    <img src="{{ asset('public/frontend/image/brand-name/Mall_of_america_logo13.png')}}" alt="" />
                                    <h5>Mall of America</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="vendors-details">
                                    <img src="{{ asset('public/frontend/image/brand-name/Associated.png')}}" alt="" />
                                    <h5>Associated</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Vendors End -->

    <!-- features Start -->
    <section id="features" class="section features">
        <h2 class="heading">
            {{isset($page_meta['features_title']) && $page_meta['features_title']!='' ? $page_meta['features_title'] : 'RUTI self checkout Features'}}
        </h2>
        <div class="container">
            <div class="row">
                @php $features = [];
                if(isset($page_meta['features_content']) && $page_meta['features_content']!=''){
                    $features = json_decode($page_meta['features_content']);
                }
                @endphp
                <div class="col-lg-7 col-md-6 d-md-block d-none features-left">
                    <div class="features-ss"></div>
                    <div class="features-left-slick">
                        @if(!empty($features))
                            @foreach($features as $feature)
                                <div class="slick-feature-img">
                                    <img src="{{asset('public/images/pagemeta/'.$feature->image)}}" alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/pickup.png')}}" class="img-fluid')}}" alt="">
                            </div>
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/scan-shop.png')}}" class="img-fluid')}}" alt="">
                            </div>
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/easy-checkout.png')}}" class="img-fluid')}}" alt="">
                            </div>
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/caseless.png')}}" class="img-fluid')}}" alt="">
                            </div>
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/coupon-deals.png')}}" class="img-fluid')}}" alt="">
                            </div>
                            <div class="slick-feature-img">
                                <img src="{{asset('public/frontend/image/rewards.png')}}" class="img-fluid')}}" alt="">
                            </div>
                        @endif
                    </div>
                    <div class="features-shape"></div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="features-slick-shape"></div>
                    <div class="features-slick">
                        @if(!empty($features))
                            @foreach($features as $feature)
                                <div class="features-text">
                                    <div>
                                        <h3>{{$feature->title}}</h3>
                                        <p>{!! $feature->description !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="features-text">
                                <div>
                                    <h3>Pickup</h3>
                                    <p>Too tired to go for Grocery Shopping? Planning to go somewhere but forgot to refill your groceries? RUTI self checkout will take care of it!!! Visit your Store and Order will be ready for you.</p>
                                </div>
                            </div>
                            <div class="features-text">
                                <div>
                                    <h3>Scan &amp; Shop</h3>
                                    <p>With RUTI self checkout, you can simply scan the Product with our App and add it to your Cart. With seamless cashless transactions on one click you can check out.</p>
                                </div>
                            </div>
                            <div class="features-text">
                                <div>
                                    <h3>Easy Checkout</h3>
                                    <p>Why wait in line for billing process where you can simply Scan & Shop? Experience a faster Checkout Process by using our App.</p>
                                </div>
                            </div>
                            <div class="features-text">
                                <div>
                                    <h3>Cashless</h3>
                                    <p>No need to carry cash while going for Shopping when you have RUTI self checkout’s wallet at your Service. You can also transfer money from one wallet to another.</p>
                                </div>
                            </div>
                            <div class="features-text">
                                <div>
                                    <h3>Coupons &amp; Deals</h3>
                                    <p>With our thrive to work harder for our users, RUTI self checkout will bring the most lucrative deals by partnering with brands to bring you the maximum discounts and benefits.</p>
                                </div>
                            </div>
                            <div class="features-text">
                                <div>
                                    <h3>Rewards</h3>
                                    <p>Earn Rewards points on every referral that you make which you can redeem while shopping.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- features End -->

    <!-- faq start -->
    <section id="faq" class="faq">
        <h2 class="font-alt heading3">
            {{isset($page_meta['faq_title']) && $page_meta['faq_title']!='' ? $page_meta['faq_title'] : 'Frequently Ask Questions'}}
        </h2>
        <div class="container">
            <div class="row">
                <div class="col-md-12 faq-inner">
                    <div class="faq-slick">
                        @php $faqs = [];
                        if(isset($page_meta['faq_content']) && $page_meta['faq_content']!=''){
                            $faqs = json_decode($page_meta['faq_content']);
                        }
                        @endphp
                        @if(!empty($faqs))
                            @foreach($faqs as $faq)
                                <div class="col-md-4 text-left">
                                    <div class="faq-details">
                                        <h5>{{$faq->question}}</h5>
                                        <p>{!! $faq->answer !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How do I enable Passcode Authentication?</h5>
                                    <p>Whenever you create a new account or login for the first time, you will be asked to set a new Passcode.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How can I Login With Passcode/ Touch ID/ Face ID?</h5>
                                    <p>When you open the app and if you have already logged in, you will be asked to enter passcode. You can login with Touch ID or Face ID by clicking bottom button. You can enable/disable Touch ID/Face ID from the Settings.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How Do I Unlock Store?</h5>
                                    <p>You can unlock store by clicking centered RUTI self checkout Logo button on Dashboard. When you click on button it will fetch store from your current location.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How Do I Scan &amp; Shop?</h5>
                                    <p>After Unlocking the Store, you can scan product barcode via the App Scanner and product will be automatically added to your cart.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How Can I Add Money To My Wallet?</h5>
                                    <p>You can open wallet section from side menu, then click on add money button, which will ask you to enter amount you want to add. then click on submit button which will redirect you to payment page. After successful transaction, money will be credited to your wallet.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>How Can I Transfer My Wallet Balance?</h5>
                                    <p>You can open wallet section from side menu, then click on transfer balance button. Which will ask you to enter email address of other user and amount you want to transfer. then click on submit button. This will prompt a confirmation dialog and after your confirmation, amount will be transferred to user with email address you have entered.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-left">
                                <div class="faq-details">
                                    <h5>Can I Purchase From Multiple Stores At a Time?</h5>
                                    <p>No, You can not purchase from multiple stores at time.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq End -->

    <div style="clear:both;"></div>

    <!-- download start -->
    <section id="download" class="download">
        <h2 class="heading">
            {{isset($page_meta['downloads_title']) && $page_meta['downloads_title']!='' ? $page_meta['downloads_title'] : 'Downloads'}}
        </h2>
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    @if(isset($page_meta['downloads_description']) && $page_meta['downloads_description']!='')
                        <p>{!! $page_meta['downloads_description'] !!}</p>
                    @else
                        <p>A faster way to online shopping with the hands-on in store shopping experience. A quick way to reach out and keep in touch – all on the RUTI self checkout App. The RUTI self checkout mobile app is available for iOS and Android devices.</p>
                    @endif
                    <ul class="banner-icon">
                        <li class="apple"><a href="{{isset($page_meta['downloads_ios_app_link']) && $page_meta['downloads_ios_app_link']!='' ? $page_meta['downloads_ios_app_link'] : '#'}}" target="_blank"><i class="fa fa-apple"></i><p>ios</p></a></li>
                        <li><a href="{{isset($page_meta['downloads_android_app_link']) && $page_meta['downloads_android_app_link']!='' ? $page_meta['downloads_android_app_link'] : '#'}}" target="_blank"><i class="fa fa-android"></i><p>Android</p></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- download end -->

    <div style="clear:both;"></div>

    <!-- feedbacks start -->
    <section id="feedback" class="feedbacks">
        <h2 class="font-alt heading3">
            {{isset($page_meta['client_feedback_title']) && $page_meta['client_feedback_title']!='' ? $page_meta['client_feedback_title'] : 'Client Feedback'}}
        </h2>
        <div class="container">
            <div class="row">
                <div class="col-md-12 feedback-inner">
                    <div class="feedback-slick">
                        @php $client_feedback = [];
                        if(isset($page_meta['client_feedback_content']) && $page_meta['client_feedback_content']!=''){
                            $client_feedback = json_decode($page_meta['client_feedback_content']);
                        }
                        @endphp
                        @if(!empty($client_feedback))
                            @foreach($client_feedback as $feedback)
                            <div class="col-md-4 text-center">
                                <div class="feedback-details">
                                    @php if($feedback->image!='' && file_exists(public_path('images/pagemeta/'.$feedback->image))){ @endphp
                                        <img src="{{asset('public/images/pagemeta/'.$feedback->image)}}" class="img-fluid feedbackImage" alt="">
                                    @php } @endphp
                                    @php /* if($feedback->image!=''){
                                        $image = asset('public/images/pagemeta/'.$feedback->image);
                                    }else{
                                        $image = asset('public/frontend/image/feedback-image-1.png');
                                    } */ @endphp
                                    <h2>{{$feedback->name}}</h2>
                                    @if(isset($feedback->state))
                                        <h5>{{$feedback->state}}</h5>
                                    @endif
                                    <p>{!! $feedback->description !!}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-md-4 text-center">
                                <div class="feedback-details">
                                    <img src="{{ asset('public/frontend/image/feedback-image-1.png')}}" class="img-fluid" alt="">
                                    <h2>Johnson</h2>
                                    <p>RUTI self checkout is the future of grocery shopping! The App is very easy to use and the highlight of this whole idea for me is that I do not have to wait in a long queue for the Billing Process. Scan, Confirm, Checkout and  Vola! I am out of the Store. Highly Recommended</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feedback-details">
                                    <img src="{{ asset('public/frontend/image/feedback-image-2.png')}}" class="img-fluid" alt="">
                                    <h2>Sophia</h2>
                                    <p>Hi Guys, I am sharing my experience with RUTI self checkout. I am a regular user of RUTI self checkout as while going back home from my office, I always order fresh groceries from the Store on my way and ask them for a Pick Up option, so by the time I reach the Store, my order is ready and good to go. It has saved me a lot of time.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feedback-details">
                                    <img src="{{ asset('public/frontend/image/feedback-image-3.png')}}" class="img-fluid" alt="">
                                    <h2>Hailey</h2>
                                    <p>Thanks to RUTI self checkout, I can now transfer money from my wallet to my daughter’s wallet for her shopping which helps me keep tab on her expenses. Also, pick up option is something I frequently use</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </section>
    <!-- feedbacks End -->
   @endsection
