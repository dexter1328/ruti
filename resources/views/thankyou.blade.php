@extends('front_end.layout')
@section('content')


    {{-- <div style="clear:both;"></div> --}}

    <!-- terms-condition start -->
   <!-- download start -->
<section id="download" class="download">
    <h2 class="heading">
        <h1><img style="width: 10%" src="{{ asset('public/wb/img/logo/thank-you.gif')}}" alt=""></h1>
        <h2>    Thank You For Choosing Nature Checkout. Please login to continue.
        </h2>
    </h2>
    <div class="container">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                @if(isset($page_meta['downloads_description']) && $page_meta['downloads_description']!='')
                    <p>{!! $page_meta['downloads_description'] !!}</p>
                @else
                    <p>A faster way to online shopping with the hands-on in store shopping experience. A quick way to reach out and keep in touch – all on the Nature checkout App. The Nature checkout mobile app is available for iOS and Android devices.</p>
                @endif
                <ul class="banner-icon bni1 banner-icon-new">
                    <li class="apple">
                        <img src="{{ asset('public/frontend/image/ios_qrcode.png')}}" alt="">
                    </li>
                    <li>
                        <img src="{{ asset('public/frontend/image/android_qrcode.png')}}" alt="">
                    </li>
                </ul><br>
                <ul class="banner-icon bni2">
                    <li class="apple"><a href="{{isset($page_meta['downloads_ios_app_link']) && $page_meta['downloads_ios_app_link']!='' ? $page_meta['downloads_ios_app_link'] : '#'}}" target="_blank"><i class="fa fa-apple"></i><p>ios</p></a></li>
                    <li><a href="{{isset($page_meta['downloads_android_app_link']) && $page_meta['downloads_android_app_link']!='' ? $page_meta['downloads_android_app_link'] : '#'}}" target="_blank"><i class="fa fa-android"></i><p>Android</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- download end -->
   @endsection
