<div class="footer-wrapper">
    <div class="footer">
     <div class="footer-info">
       <img class="footer-logo" src="public/wb/img/new_homepage/logo/logo.png" alt="">
       <div class="footer-desc">
         We provide convenient and
         expeditious service to all users
         (merchants and consumers) in
         areas of consumer spending. Our
         service is to improve merchant -
         customer relations while
         offering positive contribution to
         the overall economy.
       </div>
       <div class="footer-contact">
         <a href="#">
           <i class="fa fa-solid fa-map-marker"></i>
             829 W Palmdale Blvd, Suite 133
              Palmdale, California 93551
         </a>
         {{-- <a href="#">
           <i class="fa fa-solid fa-phone"></i>
           Phone: +0 (000) 000-0000
         </a>
         <a href="#">
           <i class="fa fa-solid fa-fax"></i>
           Fax: +0 (000) 000-0000
         </a> --}}
       </div>
     </div>

     <div class="footer-posts-section">
       <h2 class="footer-heading">Recent Posts</h2>
       <div class="footer-posts">

         <div class="footer-post">
           <div class="footer-post-img">
             <img src="public/wb/img/new_homepage/blogs/blog-3.jpg" alt="aa">
           </div>
           <div class="footer-post-info">
             <h4 class="footer-post-heading">A companion for extra sleeping</h4>
             <div class="footer-post-time">
               <span class="date">
                 July 23, 2023
               </span>
               <span class="comment">
                 1 Comment
               </span>
             </div>
           </div>
         </div>
         <div class="footer-post">
           <div class="footer-post-img">
             <img src="public/wb/img/new_homepage/blogs/blog-2.jpg" alt="aa">
           </div>
           <div class="footer-post-info">
             <h4 class="footer-post-heading">Outdoor seating collection inspiration</h4>
             <div class="footer-post-time">
               <span class="date">
                 July 23, 2023
               </span>
               <span class="comment">
                 1 Comment
               </span>
             </div>
           </div>
         </div>

       </div>
     </div>
     <div class="footer-menus">
       <div class="footer-menu">
       <h2 class="footer-heading">CONNECT</h2>
       <nav>
         <ul>
             <li><a href="{{url('/home')}}">Home</a></li>
             <li><a href="{{url('/trending-products')}}">Trending Products</a></li>
             <li><a href="{{url('/special-offers')}}">Special Offers</a></li>
             <li><a href="https://naturemenu.net" target="_blank">Nature Menu</a></li>
             <li><a href="{{url('/blog')}}">Blog</a></li>
             <li><a href="{{url('privacy-policy')}}"> Privacy</a></li>
             <li><a href="{{url('terms-condition')}}">Terms</a></li>
         </ul>
       </nav>
       </div>
       <div class="footer-menu">
       <h2 class="footer-heading">TOP CATEGORIES</h2>
       <nav>
         @foreach ($categories2 as $cat)
         <ul>
             <li>
                 <a href="{{route('cat-products', $cat->category1)}}">{{$cat->category1}}</a>
             </li>
         </ul>
         @endforeach
       </nav>
       </div>
       <div class="footer-menu">
       <h2 class="footer-heading">SERVICES</h2>
       <nav>
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
       </nav>
       </div>
     </div>
    </div>
  </div>
  <!-- Footer End -->







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

