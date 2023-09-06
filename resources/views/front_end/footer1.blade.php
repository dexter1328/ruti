<!-- footer-area -->
<footer>
    <div class="footer-area">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 left-footer-section">
                        <div class="footer-widget mb-30">
                            {{-- <div class="footer-contact">
                                <span>CALL US FREE</span>
                                <a href="tel:+0 (000) 000-0000" class="contact">+0 (000) 000-0000</a>
                            </div> --}}
                            {{-- <div class="f-logo mb-25">
                                <a href="index.html"><img src="assets/img/logo/footer-logo.png" alt="logo"></a>
                            </div> --}}
                            <div class="footer-content">
                                <p>We provide convenient and
                                expeditious service to all users
                                (merchants and consumers) in
                                areas of consumer spending. Our
                                service is to improve merchant -
                                customer relations while
                                offering positive contribution to
                                the overall economy.</p>
                            </div>
                            <div class="footer-address rs-footer footer-main-home">
                                <ul class="address-widget">
                                    <li>
                                        <i class="lnr lnr-map"></i>
                                        <div class="contact">
                                            829 W Palmdale Blvd, Suite
                                            133 Palmdale, California 93551
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-7 col-xl-8 p-5">
                        <div class="row justify-content-center justify-content-lg-start justify-content-md-start justify-content-sm-start">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12  ">
                                <div class="footer-widget mb-md-3 mb-xl-5">
                                <div class="fw-title">
                                    <h2 class="title">CONNECT</h2>
                                </div>
                                <div class="fw-link">
                                    <ul>
                                        {{-- <li><a href="{{url('/home')}}">Home</a></li> --}}
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li><a href="{{url('/trending-products')}}">Trending Products</a></li>
                                        <li><a href="{{url('/special-offers')}}">Special Offers</a></li>
                                        <li><a href="https://naturemenu.net" target="_blank">Restaurants</a></li>
                                        <li><a href="{{url('/blog')}}" >Blog</a></li>
                                        {{-- <li><a href="contact.html">Privacy Policy</a></li>
                                        <li><a href="contact.html">Term and Conditions</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6 col-12">
                                <div class="footer-widget mb-md-3 mb-xl-5">
                                <div class="fw-title">
                                    <h2 class="title">TOP CATEGORIES</h2>
                                </div>
                                <div class="fw-link">
                                    @foreach ($categories2 as $cat)
                                    <ul>
                                        <li><a href="{{route('cat-products', $cat->category1)}}">{{$cat->category1}}</a></li>

                                    </ul>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-3 col-lg-5 col-md-6 col-sm-6 col-12">
                                <div class="footer-widget mb-md-3 mb-xl-5">
                                    <div class="fw-title">
                                        <h2 class="title">SERVICE</h2>
                                    </div>
                                    <div class="fw-link">
                                        <ul>
                                            @if (Auth::guard('w2bcustomer')->user())
                                            <li><a href="{{route('user-account-page')}}">My Account</a></li>
                                            <li><a href="{{route('user-account-page')}}">My Orders</a></li>
                                            <li><a href="{{route('user-account-page')}}">Track Your Order</a></li>
                                            <li><a href="{{route('wb-wishlist-page')}}">Wishlist</a></li>
                                            <li><a href="https://helpdesk.naturecheckout.com" target="_blank">Support</a></li>
                                            @else
                                            <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal25">My Account</a></li>
                                            <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal26">My Orders</a></li>
                                            <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal27">Track Your Order</a></li>
                                            <li><a href="#" type="button" data-toggle="modal" data-target="#exampleModal28">Wishlist</a></li>
                                            @endif
                                            {{-- <li><a href="contact.html">Support</a></li>
                                            <li><a href="contact.html">Compare</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center justify-content-lg-start justify-content-md-start justify-content-sm-start">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12 align-self-center mb-4">
                                <div class="footer-widget">
                                    <p class="web-address mb-0">@naturecheckout.com/</p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12 align-self-center mb-md-3 mb-xl-4">
                                <div class="privacy-terms">
                                    <ul class="d-flex">
                                        <li><a href="{{url('privacy-policy')}}"> Privacy</a></li>
                                        <li><a href="{{url('terms-condition')}}">Terms</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-12 col-12 align-self-center mb-md-0 mb-xl-4">
                                <div class="">
                                    <div class="footer-social">
                                        <ul>
                                            <li><a  target="_blank" href="https://www.facebook.com/Naturecheckout"><i class="fa fa-facebook-f"></i></a></li>
                                            <li><a  target="_blank" href="https://www.instagram.com/naturecheckout"><i class="fa fa-instagram"></i></a></li>
                                            <li><a  target="_blank" href="https://twitter.com/naturecheckout"><i class="fa fa-twitter"></i></a></li>
                                            <li><a  target="_blank" href="https://tiktok.com/naturecheckout"><i class="fa fa-tiktok"></i></a></li>
                                            <li><a  target="_blank" href="https://www.pinterest.com/Naturecheckout"><i class="fa fa-pinterest"></i></a></li>
                                            <li><a  target="_blank" href="https://www.linkedin.com/company/93313174/"><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-area-end -->







<!-- Modal -->
<div class="modal fade" id="exampleModal25" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Login First to see your Account
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal -->




<!-- Modal -->
<div class="modal fade" id="exampleModal26" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Login First to see Your Orders
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal -->



<!-- Modal -->
<div class="modal fade" id="exampleModal27" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Login First to Track your orders
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal -->



<!-- Modal -->
<div class="modal fade" id="exampleModal28" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Login First to see your wishlist
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal -->




<!-- Modal -->
<div class="modal fade" id="exampleModal29" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Login First to add this to your wishlist
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal -->

