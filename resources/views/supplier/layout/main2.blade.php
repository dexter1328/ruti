<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nature Vendor Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public/panel/style.css') }}">
  </head>
  <body>
    <div class="main_body">
        <div class="top_header row">
            <h2 class="col-lg-6 col-md-12 page_heading d-flex blue_color ps-4 align-items-center">Supplier Portal</h2>
            <div class="col-lg-6 col-md-12 top_header_div justify-content-around align-items-center">
            <div class="dropdowns_top_header d-flex justify-content-around">

            </div>
            <div class="top_bar_last d-flex justify-content-end w-100 align-items-center">

                <div class="sign_out_btn top_bar_elements">
                    <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-secondary px-2">
                        Sign Out
                    </a>
                    <form id="logout-form" action="{{ url('/supplier/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            <div class="user_image d-flex align-items-center top_bar_elements">
                @if(Auth::user()->image)
                @php $image = asset('public/images/suppliers/'.Auth::user()->image); @endphp
                <img src="{{$image}}" alt="{{Auth::user()->name}}" class="user_image me-2 img-circle">
                @else
                <img src="{{asset('public/images/User-Avatar.png')}}" alt="{{Auth::user()->name}}" class="user_image me-2 img-circle">
                @endif
                <p>{{Auth::user()->name}}</p>
            </div>
            </div>
        </div>
        <div class="sub_header row justify-content-between p-2 align-items-center">
            <div class="bussiness_name col-lg-4 col-md-12 ps-3">
                <h4>{{Auth::user()->name}}</h4>
            </div>
            <div class="sub_header_last justify-content-around pe-3 col-md-12 col-lg-6">

            </div>
        </div>
    </div>
    <div class="search-container p-2 w-100 justify-content-center">
        <input type="text" placeholder="Search...">
    </div>
    <div class="first_main_div p-4 m-auto">
        <div class="row justify-content-between">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <p class="mt-2">SUPPLIER PANEL</p>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 first_column">
                <p class="headings"><img src="{{ asset('public/panel/images/icon8_market.png') }}" width="30px" height="30px" alt="Market"> AFFILIATES</p>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><a class="links" href="">Suppliers</a></li>
                    <li class="li_elements"><a class="links" href="">Retailers</a></li>
                    <li class="li_elements"><a class="links" href="">Sellers</a></li>
                    <li class="li_elements"><a class="links" href="">Restaurants</a></li>
                    <li class="li_elements"><a class="links" href="">Influencers</a></li>
                    <li class="li_elements"><a class="links" href="">Deliver Drivers</a></li>
                    <li class="li_elements"><a class="links" href="">Bussiness Relations(Owners)</a></li>
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/icon8_g1.png') }}" width="30px" height="30px" alt="general"> GENERAL</p>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><a class="links" href="">Roles/Permissions</a></li>
                    <li class="li_elements"><a class="links" href="">Notifications</a></li>
                    <li class="li_elements"><a class="links" href="">Support Responses</a></li>
                    <li class="li_elements"><a class="links" href="">Transaction</a></li>
                    <li class="li_elements"><a class="links" href="">Reports</a></li>
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/receive_dollar.png') }}" width="30px" height="30px" alt="additional"> ADDITIONAL FUNDS RECEIVED</p>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Supplier Funds <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Retailer Funds <span>$3451</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Sellers Funds <span>$8237</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">W2B Funds <span>$2837</span></div></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 second_column">
                <p class="headings"><img src="{{ asset('public/panel/images/Program.png') }}" width="30px" height="30px" alt="programs"> PROGRAMS</p>
                <ul class="no_decoration_list list">
                    @if(vendor_has_permission(Auth::user()->role_id,'products','read'))
                    <li class="li_elements {{ (request()->is('supplier/products') or (request()->is('supplier/products/*') && !request()->is('supplier/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/products')}}">
                        Products
                        </a>
                    </li>
                    @endif
                    @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                    <li class="li_elements {{ (request()->is('supplier/orders') || request()->is('supplier/orders/*')) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/orders')}}">
                        Orders
                        </a>
                    </li>
                    @endif
                    {{-- <li class="li_elements">Fulfillments</li>
                    <li class="li_elements">Stores</li>
                    <li class="li_elements">Sales</li> --}}
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Manage Plans</p>
                <ul class="list">
                    <li class="li_elements "><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/choose-ruti-fullfill-page')}}"> Fulfillment Plan </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/supplier-wallet')}}">Add Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/receive-wallet')}}">Receive Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/withdraw-wallet')}}">Withdraw Funds </a></div></li>
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage product"> Manage Product Details</p>
                <ul class="list">
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/categories')}}">Manage Category </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/brand')}}">Manage Brands</a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/products')}}">Manage Product</a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/products/inventory-upload')}}">Upload Inventory </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/products/inventory')}}">Manage Product Stock</a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/product_reviews')}}">Manage Product Review</a></div></li>
                </ul>

                <p class="headings"><img src="{{ asset('public/panel/images/membership_card.png') }}" width="30px" height="30px" alt="vendor"> VENDOR MEMBERSHIP</p>
                <ul class="list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Seed <span>1214</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Sprout <span>4232</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Sellers Funds <span>$8237</span></div></li>
                </ul>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Delivery Drivers <span>8372</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Advertiser <span>8372</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Influencers Hired <span>8372</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Bussiness Relations (Owner) <span>8372</span></div></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 third_column">
                <div class="d-flex justify-content-between">
                    <p class="headings"><img src="{{ asset('public/panel/images/receive_dollar.png') }}" width="30px" height="30px" alt="funds"> FUNDS RECEIVED</p>
                </div>
                <p>Membership</p>
                <ul class="list">
                    <li class="li_elements">Customer</li>
                    <li class="li_elements">Vendor</li>
                </ul>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Advertising <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Influencer Head <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Fulfillment Service <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Customer Incentives <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Email Campaign <span>$3458</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Digital Wallets Balance <span>$3458</span></div></li>
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/Paid.png') }}" width="30px" height="30px" alt="funds paid out"> FUNDS PAID OUT</p>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Suppliers <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Retailers <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Restaurants <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Influencers <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Sellers <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Digital Wallets Payments <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Delivery Drivers <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Others <span>$8394</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Refund <span>$8394</span></div></li>
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/request_service.png') }}" width="30px" height="30px" alt="funds request"> FUNDS REQUEST</p>
                <ul class="no_decoration_list list">
                    <li class="li_elements"><div class="d-flex justify-content-between">Customer <span>$34.00</span></div></li>
                    <li class="fw-bold li_elements text-light">Rewards</li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Purchases <span>$34,451</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Friends Refferal <span>$8237</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">Store Suggests <span>$54,834</span></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between">All Users <span>$23.00</span></div></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="{{ asset('public/panel/app3.js') }}"></script>
  </body>
</html>
