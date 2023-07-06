@extends('supplier.layout.main')
@section('content')

{{-- Subscription cancel page start --}}
@if ($supplier->fulfill_type == 'nature')
 <div class="i_cancel_body d-flex justify-content-center">
    <div class="i_sub_container m-4">
        <div class="inner-container">
            <h4 class="i_funds_heading text-center mt-3 pb-2 p-2">Congratulations.. You have successfully subscribed to Nature Checkout Fulfillment Plan</h4>
    <svg id="i_svg" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 590 484.7">
      <g id="blobs">
        <path id="blob-1" d="M545.5,299c0,80.3-28.6,150.4-126.4,139.4-63.2-7.1-109.3-37.3-142.6-37.3-45.7,0-105.4,29.3-146.8,22.2-69-11.7-85.3-66.8-85.3-135.8,0-56.3,25.5-99.9,46.2-140.8,18.3-36.1,55.9-97.8,125.1-100.5,53.3-2.1,97.4,50.5,138.4,74.2,49.9,28.8,98.4-1.8,126,1.3C537.9,127.9,545.5,265.5,545.5,299Z" fill="#eddfeb"/>
        <path id="blob-3" d="M55.1,300.7c0,80.3,27.4,150.4,121,139.4,60.5-7.1,104.7-37.3,136.5-37.3,43.8,0,100.9,29.3,140.5,22.2,66-11.7,81.7-66.8,81.7-135.8,0-56.3-16.2-103.6-36.1-144.5-17.6-36.1-54.9-97.4-121.2-100.1-51-2.1-100.1,53.8-139.4,77.5-47.8,28.8-94.3-1.8-120.7,1.3C62.4,129.6,55.1,267.1,55.1,300.7Z" fill="#eddfeb"/>
      </g>
      <g id="confetti" class="confetti">
        <rect x="284" y="230.4" width="17.7" height="17.67" rx="4" ry="4" fill="#543093"/>
        <rect x="284" y="230.4" width="17.7" height="17.67" rx="4" ry="4" fill="#543093"/>
        <rect x="285.4" y="231.7" width="17.7" height="17.67" rx="4" ry="4" fill="#fff"/>
        <rect x="285.4" y="231.7" width="17.7" height="17.67" rx="4" ry="4" fill="#fff"/>
        <rect x="285.4" y="230.1" width="17.7" height="17.67" rx="4" ry="4" fill="#d960ae"/>
        <rect x="285.4" y="230.1" width="17.7" height="17.67" rx="4" ry="4" fill="#d960ae"/>
        <rect x="285.4" y="231.7" width="17.7" height="17.67" rx="4" ry="4" fill="#f3c1df"/>
        <rect x="285.4" y="231.7" width="17.7" height="17.67" rx="4" ry="4" fill="#f3c1df"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#543093"/>
        <circle cx="294.1" cy="243.6" r="12" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="294.2" cy="243.6" r="12" fill="#fff"/>
        <circle cx="294.2" cy="243.6" r="12" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="294.2" cy="243.6" r="12" fill="none" stroke="#d960ae" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="294.2" cy="243.6" r="12" fill="none" stroke="#d960ae" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="295.9" cy="242.1" r="12" fill="none" stroke="#543093" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="295.9" cy="242.1" r="12" fill="none" stroke="#543093" stroke-miterlimit="10" stroke-width="2"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#d960ae"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#d960ae"/>
        <circle cx="292.9" cy="241.3" r="9.7" fill="#fff"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#d960ae"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#543093"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#d960ae"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#543093"/>
        <circle cx="294.1" cy="241.3" r="9.7" fill="#543093"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#f3c1df"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#543093"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#d960ae"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#f3c1df"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#fff"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#543093"/>
        <path d="M300.9,243.1l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.1Z" fill="#d960ae"/>
        <path d="M300.9,243.1l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.1Z" fill="#f3c1df"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#543093"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#d960ae"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#f3c1df"/>
        <path d="M300.9,243.2l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.2Z" fill="#fff"/>
        <path d="M300.9,243.1l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.1Z" fill="#d960ae"/>
        <path d="M300.9,243.1l-3-3a1.5,1.5,0,0,1,0-2.1l3-3a2,2,0,0,0,.3-2.5,1.9,1.9,0,0,0-2.9-.3l-3.1,3.1a1.5,1.5,0,0,1-2.1,0l-3-3a2,2,0,0,0-2.5-.3,1.9,1.9,0,0,0-.3,2.9l3.1,3.1a1.5,1.5,0,0,1,0,2.1l-3,3a2,2,0,0,0-.3,2.5,1.9,1.9,0,0,0,2.9.3l3.1-3.1a1.5,1.5,0,0,1,2.1,0l3.1,3.1a1.9,1.9,0,0,0,2.9-.3A2,2,0,0,0,300.9,243.1Z" fill="#f3c1df"/>
      </g>
      <g id="envelope">
        <path id="Background" d="M452.9,376.3a26.1,26.1,0,0,1-25.5,20.8H162.6a26.1,26.1,0,0,1-26-26V193.2a26.1,26.1,0,0,1,26-26H427.4a26.1,26.1,0,0,1,26,26V371.1a25.9,25.9,0,0,1-.5,5.2" fill="#d960ae" stroke="#543093" stroke-miterlimit="10" stroke-width="5"/>
        <g id="paper-group">
          <rect id="paper" x="157.3" y="87.6" width="275.3" height="266.33" rx="26" ry="26" fill="#fff" stroke="#543093" stroke-miterlimit="10" stroke-width="5"/>
          <g id="face">
            <g id="mouth">
              <path id="mouth-scared" d="M275,220a18.7,18.7,0,0,1,35.9.1" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              <path id="mouth-sad" d="M258.8,231.9c3.9-14.5,17.7-25.2,34-25.2s30.3,10.8,34.1,25.4" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              <path id="mouth-worry" d="M259.3,207c3.9,14.5,17.7,25.2,34,25.2s30.3-10.8,34.1-25.4" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              <path id="mouth-happy" d="M259.3,207c3.9,14.5,17.7,25.2,34,25.2s30.3-10.8,34.1-25.4" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              <g id="mouth-laughing">
                <path id="open-mouth" d="M323.8,208.3c3.9,0,6.7,3.9,5.9,7.9a37.5,37.5,0,0,1-73.5,0c-0.9-4.1,2-7.9,5.9-7.9h61.7Z" fill="#543093" opacity="0.98"/>
                <path id="tongue" d="M293.2,241.1c6.9,0,13.1-2.3,17.3-5.9a2.1,2.1,0,0,0,.5-2.6c-3.1-5.8-9.9-9.8-17.8-9.8s-14.7,4-17.8,9.8a2.1,2.1,0,0,0,.5,2.5C280,238.8,286.2,241.1,293.2,241.1Z" fill="#d960ae"/>
              </g>
            </g>
            <g id="eye-group">
              <g id="eyes" class="eyes">
                <ellipse id="eye-right" cx="349" cy="172.8" rx="11.2" ry="13.8" fill="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" />
                <ellipse id="eye-left" cx="235.5" cy="172.8" rx="11.2" ry="13.8" fill="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" />         <path id="eyebrow-sad-right" d="M366.2,146.3c-2.6-5.3-14.8-14.1-24.3-14.7" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
                <path id="eyebrow-sad-left" d="M216.4,146.3c2.6-5.3,14.8-14.1,24.3-14.7" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>

              </g>
              <g id="eyes-laughing">
         <path id="eye-laughing-right" d="M332.2,174c0-8.3,7.5-15,16.8-15s16.8,6.7,16.8,15" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
                <path id="eye-laughing-left" d="M218.7,174c0-8.3,7.5-15,16.8-15s16.8,6.7,16.8,15" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              </g>
              <g id="eyebrows-happy">
                <path id="eyebrow-happy-right" d="M366.2,146.3c-2.6-5.3-14.8-14.1-24.3-14.7" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
                <path id="eyebrow-happy-left" d="M216.4,146.3c2.6-5.3,14.8-14.1,24.3-14.7" fill="none" stroke="#543093" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5"/>
              </g>
            </g>
          </g>
        </g>
        <path id="back" d="M451.9,186.7S322.4,288.2,313.4,294.1s-27,5.8-36.9,0S137.9,186.5,137.9,186.5a23.6,23.6,0,0,0-1.3,6.7V371.1a26.1,26.1,0,0,0,26,26H427.4a26,26,0,0,0,26-26V193.2C453.4,190.7,452.5,188.9,451.9,186.7Z" fill="#f3c1df" stroke="#543093" stroke-miterlimit="10" stroke-width="5"/>
        <g id="shadow">
          <path id="shadow-3" d="M263.3,279.7s11.3-8.1,13.1-9.3c9.9-6.5,27-5.8,36.9,0,1.7,1,13.5,9.3,13.5,9.3" fill="none" stroke="#eddfeb" stroke-linejoin="bevel" stroke-width="7"/>
          <path id="shadow-2" d="M430.2,193.3L313.4,282.2a26.1,26.1,0,0,1-36.8,0L159.8,193.3V201l116.8,90.6c7.9,5.7,26.9,6.4,37,0l116.6-90.9v-7.4Z" fill="#eddfeb"/>
        </g>
        <path id="shadow-1" d="M425.2,381.5h-262c-14.1,0-24.2-11-24.2-24.4v13.2c0,13.4,10.1,24.3,24.2,24.3h262c12.7,1.2,23.9-8.4,25.2-19.5a42.8,42.8,0,0,0,.5-4.9V358.1a14.7,14.7,0,0,1-.5,3.9C448,373.1,437.6,381.5,425.2,381.5Z" fill="#d960ae" opacity="0.5"/>
        <g id="Front">
          <path id="Front-2" data-name="Front" d="M139.8,381.9s127.5-99.5,136.5-105.4,27-5.8,36.9,0S449.8,382.1,449.8,382.1" fill="none" stroke="#543093" stroke-miterlimit="10" stroke-width="5"/>
          <path id="Front-3" data-name="Front" d="M225.4,315.3s41.9-33,51-38.9,27-5.8,36.9,0S355,307.9,355,307.9" fill="#f3c1df" stroke="#543093" stroke-miterlimit="10" stroke-width="5"/>
        </g>
      </g>
    </svg>


        <div class="i_bottom">
            <h5 class="title">Do you want to unsubscribe?</h5>
            <p class="subtitle">And Want to switch to Seller Fulfillment plan.</p>
            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('supplier_fulfill')}}" >
                @csrf
                <input type="hidden" name="fulfill_type" value="self">
                <div class="i_buttons">
                    <button id="unsubscribe" type="submit">Unsubscribe</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>


{{-- Subscription cancel page end --}}

@else
<div class="body_subscribtion d-flex justify-content-center">
    <div class="i_sub_container m-auto p-4">
        <div class="inner-container">
            <div class="mt-4 mb-2">
                <div class="i_heading_main text-center">
                    <h1>
                        Nature Checkout Fulfill Plan
                    </h1>
                    <span class="mt-4">Subscribe only for $25</span>
                </div>
            </div>
          <div class="row my-2 mx-0">
                <div class="accordion w-100" id="faq">
                    <div class="card w-75 mx-auto">
                        <div class="card-header" id="faqhead1">
                            <a href="#" class="btn btn-header-link text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq1"
                            aria-expanded="true" aria-controls="faq1">Pay with Card</a>
                        </div>

                        <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="card-body">
                                <div class="col-lg-12 mb-4  required">
                                    <form role="form"
                                    action="{{ route('ruti-fullfill-submit') }}"
                                    method="post"
                                    class="require-validation"
                                    data-cc-on-file="false"
                                    data-stripe-publishable-key="{{$stripe_key}}"
                                    id="payment-form">
                                    @csrf
                                      <label>Name on Card <span>*</span></label>
                                      <input class='form-control' size='4' type='text' placeholder='Enter Name on Card'>
                                      </div>
                                      <div class="col-lg-12 mb-4 required" style="border: none">
                                          <label>Card Number  <span>*</span></label>
                                          <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='Enter Card Number'>
                                      </div>
                                      <div class="row">
                                          <div class="col-4 mb-4 cvc required">
                                              <label>CVC</label>
                                              <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'type='text'>
                                          </div>
                                          <div class="col-4 mb-4 expiration required">
                                              <label>Expiration Month  <span>*</span></label>
                                              <input class='form-control card-expiry-month' placeholder='MM' size='2'type='text'>
                                          </div>
                                          <div class="col-4 mb-4 expiration required">
                                              <label>Expiration Year <span>*</span></label>
                                              <input class='form-control card-expiry-year' placeholder='YYYY' size='4'type='text'>
                                          </div>
                                      </div>
                                      <div class="mx-auto order_button i_buttons">
                                          <button class="btn custom-button w-100" type="submit">Pay Now</button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card w-75 mx-auto">
                        <div class="card-header" id="faqhead2">
                            <a href="#" class="btn btn-header-link collapsed text-dark i_link w-100 text-left" data-toggle="collapse" data-target="#faq2"
                            aria-expanded="true" aria-controls="faq2">Pay with Digital Wallet</a>
                        </div>

                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('fulfill-with-wallet')}}" >
                                @csrf
                                <div class="card-body">
                                    @php
                                    $tp = 25
                                    @endphp
                                    <div class="text-center">
                                        <div class="my-4">
                                            <h4>Your Balance: <span>${{$supplier->wallet_amount}}</span></h4>
                                            <h4>Subscription fee: <span>$25</span></h4>
                                            <input type="hidden" name="amount" value="{{$tp}}">
                                        </div>
                                            @if ($errors->has('amount'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                            @endif
                                        <div class="mx-auto i_buttons">
                                            <button class="btn custom-button w-100" type="submit">Click to Pay</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
@endif



{{-- cancel Subscription page start --}}


{{--cancel Subscription page end --}}

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

$(function() {

    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('d-none');
            e.preventDefault();
          }
        });

        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }

    });

    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});
</script>
@endsection
