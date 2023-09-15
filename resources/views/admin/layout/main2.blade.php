<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="{{asset('public/wb/img/logo/logo2.png')}}" />
    <title>Nature Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public/panel/style2.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

  </head>
  <body>
    <div class="main_body">
        <div class="top_header row">
            <h2 class="col-lg-6 col-md-12 page_heading d-flex blue_color ps-4 align-items-center">SUPER ADMIN CHANNEL</h2>
            <div class="col-lg-6 col-md-12 top_header_div justify-content-around align-items-center">
            <div class="dropdowns_top_header d-flex justify-content-around">
            {{-- <div class="country_dropdown d-flex w-50 top_bar_elements">
                <span>Country</span>
                <select name="" id="">
                    <option value="">All</option>
                    <option value="">USA</option>
                    <option value="">UAE</option>
                    <option value="">Pakistan</option>
                </select>
            </div>
            <div class="language_dropdown d-flex ms-lg-5 ms-0 w-50 top_bar_elements">
                <span>Language</span>
                <select name="" id="">
                    <option value="">All</option>
                    <option value="">English</option>
                    <option value="">French</option>
                    <option value="">Spanish</option>
                </select>
            </div> --}}
            </div>
            <div class="top_bar_last d-flex justify-content-end w-100 align-items-center">
            {{-- <div class="notifications top_bar_elements text-center">
                <img src="{{ asset('public/panel/images/notification.png') }}" class="notification_icon" alt="image">
            </div> --}}
            <div class="sign_out_btn top_bar_elements">
                <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-secondary px-2">
                    Sign Out
                </a>
                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="user_image d-flex align-items-center top_bar_elements">
                @if(Auth::user()->image)
                @php $image = asset('public/images/'.Auth::user()->image); @endphp
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
                {{-- <div class="restaurant d-flex align-items-center">
                    <img src="{{ asset('public/panel/images/RestaurantBuilding.png') }}" class="sub_header_icons" alt="image">
                    <p><a href='www.google.com' class='header_link'> Restaurant </a></p>
                </div>
                <div class="super_admin d-flex align-items-center">
                    <img src="{{ asset('public/panel/images/Administrator.png') }}" alt="image">
                    <p><a href='#' class='header_link'> Super Admin </a></p>
                </div>
                <div class="sales_receipts d-flex align-items-center">
                    <img src="{{ asset('public/panel/images/Totalsales.png') }}" alt="image">
                    <p><a href='#' class='header_link'> Sales Receipts </a></p>
                </div>
                <div class="duration d-flex align-items-center">
                    <img src="{{ asset('public/panel/images/Weekview.png') }}" alt="image">
                    <p><a href='#' class='header_link'> Duration  </a></p>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="search-container2 w-100 justify-content-center p-2">
        <input type="text" placeholder="Search...">
    </div>
    <div class="first_main_div2 p-4 m-auto">
        <div class="row ">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <p class="mt-2">SUPER ADMIN PANEL</p>
            </div>
            <div class="first_column col-xl-3 col-lg-12 col-md-12">
                <h5 class="headings"><img src="{{ asset('public/panel/images/icon8_general2.png') }}" width="30px" height="30px" alt="General" class="me-2">ADMINS & PROFILE</h5>
                    <ul class="no_decoration_list">
                        @if(has_permission(Auth::user()->role_id,'admins','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/admins') or request()->is('admin/admins/*')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/admins')}}">All Admins</a>
                        </li>
                        @endif
                        <li class="mt-2 underlined">
                            <a class="links" href="{{ url('/admin/profile') }}">My Profile</a>
                        </li>
                        {{-- @if(has_permission(Auth::user()->role_id,'membership','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/vendor')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/vendor')}}">Vendor Membership</a>
                        </li>
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/supplier')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/supplier')}}">Supplier Membership</a>
                        </li>
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/supplier_ruti_fullfill')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/supplier_ruti_fullfill')}}">Nature Fulfill Membership</a>
                        </li>
                        @endif --}}

                    </ul>
                <h5 class="headings"><img src="{{ asset('public/panel/images/Supplier.png') }}" width="30px" height="30px" alt="Supplier" class="me-2">MANAGE SUPPLIERS</h5>
                <ul class="no_decoration_list">
                    {{-- <li class="mt-2 underlined"><a href='#' class='links'>Inventory Management</a></li> --}}
                    @if(has_permission(Auth::user()->role_id,'vendor','read') || has_permission(Auth::user()->role_id,'vendor_store','read') || has_permission(Auth::user()->role_id,'vendor_configuration','read') || has_permission(Auth::user()->role_id,'vendor_coupons','read') || has_permission(Auth::user()->role_id,'vendor_coupons_used','read') )
                    <li class="mt-2 underlined {{ (request()->is('admin/supplier/*') or request()->is('admin/supplier_store/*') or request()->is('admin/supplier_configuration/*') or request()->is('admin/supplier_coupons/*') or request()->is('admin/supplier_coupons_used/*') or request()->is('admin/supplier_unverified_coupons/*')) ? 'active menu-open' : '' }}">
                        <a href='{{url('admin/supplier')}}' class='links'>View Suppliers</a>
                    </li>
                    <li class="mt-2 underlined {{ (request()->is('admin/supplier/*') or request()->is('admin/supplier_store/*') or request()->is('admin/supplier_configuration/*') or request()->is('admin/supplier_coupons/*') or request()->is('admin/supplier_coupons_used/*') or request()->is('admin/supplier_unverified_coupons/*')) ? 'active menu-open' : '' }}">
                        <a href='{{ route('supplier.create') }}' class='links'>
                            Add New Supplier
                        </a>
                    </li>

                    @endif
                </ul>
                <h5 class="headings"><img src="{{ asset('public/panel/images/best_seller.png') }}" width="30px" height="30px" alt="Best seller" class="me-2">MANAGE SELLERS</h5>
                <ul class="no_decoration_list">
                    {{-- <li class="mt-2 underlined"><a href='#' class='links'>Inventory Management</a></li> --}}
                    @if(has_permission(Auth::user()->role_id,'vendor','read'))
                    <li class="mt-2 underlined {{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor')}}" class="waves-effect links">
                            View Sellers
                        </a>
                    </li>
                    <li class="mt-2 underlined {{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
                        <a href="{{ route('vendor.create') }}" class="waves-effect links">
                            Add New Seller
                        </a>
                    </li>
                    @endif

                </ul>



            </div>
            <div class="second_column col-xl-3 col-lg-12 col-md-12">
                <h5 class="headings"><img src="{{ asset('public/panel/images/icon8_general2.png') }}" width="30px" height="30px" alt="General" class="me-2">ROLE MANAGEMENT</h5>
                <ul class="no_decoration_list">
                    @if(has_permission(Auth::user()->role_id,'admin_roles','read'))
                    <li class="mt-2 underlined {{ (request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active' : '' }}">
                        <a href='{{url('admin/admin_roles')}}' class='links'>Roles and Permissions</a>
                    </li>
                    @endif
                </ul>

                <h5 class="headings"><img src="{{ asset('public/panel/images/icon8_shipping.png') }}" width="30px" height="30px" alt="Shipping" class="me-2">WHOLESALE2B</h5>
                <ul class="no_decoration_list">

                    @if(has_permission(Auth::user()->role_id,'products','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
                            <a href="{{url('admin/w2b_products')}}" class="waves-effect links">
                                Manage Products
                            </a>
                        </li>
                    @endif
                    @if(has_permission(Auth::user()->role_id,'products','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
                            <a href="{{url('admin/w2b_products/orders')}}" class="waves-effect links">
                                Manage Orders
                            </a>
                        </li>
					@endif

                </ul>
                {{-- <h5 class="headings"><img src="{{ asset('public/panel/images/best_seller.png') }}" width="30px" height="30px" alt="Best seller" class="me-2">Seller</h5>
                <ul class="no_decoration_list">
                    @if(has_permission(Auth::user()->role_id,'vendor','read') || has_permission(Auth::user()->role_id,'vendor_store','read') || has_permission(Auth::user()->role_id,'vendor_configuration','read') || has_permission(Auth::user()->role_id,'vendor_coupons','read') || has_permission(Auth::user()->role_id,'vendor_coupons_used','read') )
                    <li class="mt-2 underlined {{ (request()->is('admin/vendor/*') or request()->is('admin/vendor_store/*') or request()->is('admin/vendor_configuration/*') or request()->is('admin/vendor_coupons/*') or request()->is('admin/vendor_coupons_used/*') or request()->is('admin/vendor_unverified_coupons/*')) ? 'active menu-open' : '' }}">
                        <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">
                                    Manage Seller Details
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class='no_decoration_list'>
                                        @if(has_permission(Auth::user()->role_id,'vendor','read'))
                                        <li class="mt-2 underlined {{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor')}}" class="waves-effect links">
                                                Manage Sellers
                                            </a>
                                        </li>
                                        @endif
                                        @if(has_permission(Auth::user()->role_id,'vendor_store','read'))
                                        <li class="mt-2 underlined {{ (request()->is('admin/vendor_store') or request()->is('admin/vendor_store/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_store')}}" class="waves-effect links">
                                                Manage Seller Stores
                                            </a>
                                        </li>
                                        @endif
                                        @php /* @endphp
                                        <li class="{{ (request()->is('admin/vendor_configuration') or request()->is('admin/vendor_configuration/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_configuration')}}" class="waves-effect">
                                                <i class="zmdi zmdi-dot-circle-alt"></i>Manage Configurations
                                            </a>
                                        </li>
                                        @php */ @endphp
                                        @if(has_permission(Auth::user()->role_id,'vendor_coupons','read'))
                                        <li class="mt-2 underlined {{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_coupons')}}" class="waves-effect links">
                                                Manage Verified Coupons
                                            </a>
                                        </li>
                                        <li class="mt-2 underlined {{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_coupons/unverified')}}" class="waves-effect links">
                                                Manage Unverified Coupons
                                            </a>
                                        </li>
                                        @endif
                                        <!-- <li class="{{ (request()->is('admin/vendor_coupons_used') or request()->is('admin/vendor_coupons_used/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_coupons_used')}}" class="waves-effect">
                                                <i class="zmdi zmdi-dot-circle-alt"></i>Manage Used Coupons
                                            </a>
                                        </li> -->
                                        <!-- <li class="{{ (request()->is('admin/vendor_payment') or request()->is('admin/vendor_payment/*')) ? 'active' : '' }}">
                                            <a href="{{url('admin/vendor_payment')}}" class="waves-effect">
                                                <i class="zmdi zmdi-dot-circle-alt"></i>Manage Accounting
                                            </a>
                                        </li> -->
                                    </ul>
                            </div>
                        </div>
                        </div>
                    </li>

                    @endif
                </ul> --}}
            </div>
            <div class="third_column col-xl-4 col-lg-12 col-md-12">
                <h5 class="headings">Sales By Customer</h5>
                <div>
                    <canvas style="height: 200px;" id="myChart2"></canvas>
                </div>
                <div id="map" class="my-2" style="height: 200px;"></div>
                <div class="double_column justify-content-between">
                    <div>
                    {{-- <h5 class="headings"><img src="{{ asset('public/panel/images/icon8_general2.png') }}" width="30px" height="30px" alt="General" class="me-2">General</h5>
                    <ul class="no_decoration_list">
                        @if(has_permission(Auth::user()->role_id,'admins','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/admins') or request()->is('admin/admins/*')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/admins')}}">All Admins</a>
                        </li>
                        @endif
                        <li class="mt-2 underlined">
                            <a class="links" href="{{ url('/admin/profile') }}">My Profile</a>
                        </li>
                        @if(has_permission(Auth::user()->role_id,'membership','read'))
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/vendor')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/vendor')}}">Vendor Membership</a>
                        </li>
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/supplier')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/supplier')}}">Supplier Membership</a>
                        </li>
                        <li class="mt-2 underlined {{ (request()->is('admin/membership/list/supplier_ruti_fullfill')) ? 'active' : '' }}">
                            <a class="links" href="{{url('admin/membership/list/supplier_ruti_fullfill')}}">Nature Fulfill Membership</a>
                        </li>
                        @endif

                    </ul>
                    <h5 class="headings"><img src="{{ asset('public/panel/images/Management.png') }}" width="30px" height="30px" alt="Management" class="me-2">Fund Management</h5>
                    <ul class="no_decoration_list">
                    <li class="mt-2 underlined">Create/View Bank Details</li>
                    <li class="mt-2 underlined">Create/View/Add/Edit Card</li>
                    <li class="mt-2 underlined">Fund Disbursed</li>
                    <li class="mt-2 underlined">Fund Balance</li>
                    <li class="mt-2 underlined">EFT Returned Details</li>
                    </ul>
                    </div>
                    <div>
                    <h5 class="headings"><img src="{{ asset('public/panel/images/Shipped.png') }}" width="30px" height="30px" alt="Shipped" class="me-2">Help</h5>
                    <ul class="no_decoration_list">
                        <li class="mt-2 underlined">Manage Tickets</li>
                        <li class="mt-2 underlined">Sign In</li>
                        <li class="mt-2 underlined">Create Account</li>
                        <li class="mt-2 underlined">Guide/Support</li>
                        <li class="mt-2 underlined">Demo Video</li>
                        <li class="mt-2 underlined">Returns</li>
                    </ul>
                    <h5 class="headings"><img src="{{ asset('public/panel/images/graph_report.png') }}" width="30px" height="30px" alt="Graph report" class="me-2">Reports</h5>
                    <ul class="no_decoration_list">
                    <li class="mt-2 underlined">Top Selling Products</li>
                    <li class="mt-2 underlined">Sales</li>
                    <li class="mt-2 underlined">Transaction(Earning)</li>
                    <li class="mt-2 underlined">Transaction(Orders)</li>
                    <li class="mt-2 ms-4"><button class="btn btn-primary py-1 px-3">Archive</button></li>
                    </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
   <script src="{{ asset('public/panel/app2.js') }}"></script>
   <script src="{{ asset('public/panel/app.js') }}"></script>
  </body>
</html>
