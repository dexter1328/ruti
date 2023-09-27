<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nature Vendor Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public/panel/style.css') }}">
    <link rel="icon" href="{{asset('public/wb/img/logo/favicon.ico')}}" type="image/x-icon">

</head>
  <body>
    <div class="main_body">
        <button class="chat_btn">
            <a href="https://helpdesk.naturecheckout.com" target="_blank"><i class="fa fa-comments-o"></i></a>
        </button>
        <div class="top_header row">
            <h2 class="col-lg-6 col-md-12 page_heading d-flex blue_color ps-4 align-items-center">Vendor Portal</h2>
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
                <div class="sign_out_btn top_bar_elements">
                    <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-secondary px-2">
                        Sign Out
                    </a>
                    <form id="logout-form" action="{{ url('/vendor/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            <div class="user_image d-flex align-items-center top_bar_elements">
                @if(Auth::user()->image)
                @php $image = asset('public/images/vendors/'.Auth::user()->image); @endphp
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
                <h4>{{ Auth::user()->name }}</h4>
            </div>
        </div>
    </div>
    <div class="search-container p-2 w-100 justify-content-center">
        <input type="text" placeholder="Search...">
    </div>
    <div class="first_main_div p-4 m-auto">
        <div class="row justify-content-between">
            <div class="col-xl-2 col-lg-3 col-md-12">
                <p class="mt-2">VENDOR PANEL</p>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 first_column">
                <p class="headings"><img src="{{ asset('public/panel/images/Program.png') }}" width="30px" height="30px" alt="programs"> MANAGE PRODUCTS</p>
                <ul class="no_decoration_list list">
                    @if(vendor_has_permission(Auth::user()->role_id,'products','read'))
                    <li class="li_elements {{ (request()->is('vendor/products') or (request()->is('vendor/products/*') && !request()->is('vendor/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{url('vendor/products')}}">
                        View Products
                        </a>
                    </li>
                    <li class="li_elements {{ (request()->is('vendor/products') or (request()->is('vendor/products/*') && !request()->is('vendor/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{ route('vendor.products.create') }}">
                        Add New Product
                        </a>
                    </li>
                    <li class="li_elements {{ (request()->is('vendor/products') or (request()->is('vendor/products/*') && !request()->is('vendor/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{route('vendor.inventory.upload')}}">
                        Import Products
                        </a>
                    </li>
                    @endif
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/Program.png') }}" width="30px" height="30px" alt="programs"> MANAGE ORDERS</p>
                <ul class="no_decoration_list list">
                    @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                    <li class="li_elements {{ (request()->is('vendor/orders') or request()->is('vendor/orders/*')) ? 'active' : '' }}">
                        <a href="{{url('vendor/orders')}}" class="links">View Orders </a>
                    </li>
                    @endif
                </ul>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 second_column">

                <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Manage Plans</p>
                <ul class="list">
                    <li class="li_elements "><div class="d-flex justify-content-between"><a class="links" href="{{url('vendor/choose-ruti-fullfill-page')}}"> Fulfillment Plan </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('vendor/vendor-wallet')}}">Add Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('vendor/receive-wallet')}}">Receive Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('vendor/withdraw-wallet')}}">Withdraw Funds </a></div></li>
                </ul>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 third_column">

                    <p class="headings"><img src="{{ asset('public/panel/images/receive_dollar.png') }}" width="30px" height="30px" alt="funds receive"> MARKETPLACE</p>
                    {{-- <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Marketplace</p> --}}
                    <ul class="list">
                        <li class="li_elements "><div class="d-flex justify-content-between"><a class="links" href="{{route('vendor.marketplace-page')}}"> View Marketplace </a></div></li>
                    </ul>
                    <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Manage Account</p>
                    {{-- <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Marketplace</p> --}}
                    <ul class="list">
                        <li class="li_elements "><div class="d-flex justify-content-between"><a class="links" href="{{ url('/vendor/profile') }}"> View Profile </a></div></li>
                    </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="{{ asset('public/panel/app3.js') }}"></script>
  </body>
</html>
