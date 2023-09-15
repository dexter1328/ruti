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
                <p class="headings"><img src="{{ asset('public/panel/images/Program.png') }}" width="30px" height="30px" alt="programs"> MANAGE PRODUCTS</p>
                <ul class="no_decoration_list list">
                    @if(vendor_has_permission(Auth::user()->role_id,'products','read'))
                    <li class="li_elements {{ (request()->is('supplier/products') or (request()->is('supplier/products/*') && !request()->is('supplier/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/products')}}">
                        View Products
                        </a>
                    </li>
                    <li class="li_elements {{ (request()->is('supplier/products') or (request()->is('supplier/products/*') && !request()->is('supplier/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{ route('supplier.products.create') }}">
                        Add New Products
                        </a>
                    </li>
                    <li class="li_elements {{ (request()->is('supplier/products') or (request()->is('supplier/products/*') && !request()->is('supplier/products/inventory'))) ? 'active' : '' }}">
                        <a class="links" href="{{ route('supplier.inventory.upload') }}">
                        Import Products
                        </a>
                    </li>
                    @endif

                    @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                    <li class="li_elements {{ (request()->is('supplier/marketplace-orders') || request()->is('supplier/marketplace-orders/*')) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/marketplace-orders')}}">
                        Marketplace Orders
                        </a>
                    </li>
                    @endif
                    {{-- <li class="li_elements">Fulfillments</li>
                    <li class="li_elements">Stores</li>
                    <li class="li_elements">Sales</li> --}}
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/Program.png') }}" width="30px" height="30px" alt="programs"> MANAGE ORDERS</p>
                <ul class="no_decoration_list list">
                    @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                    <li class="li_elements {{ (request()->is('supplier/orders') || request()->is('supplier/orders/*')) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/orders')}}">
                        View Orders
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 second_column">

                <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Manage Plans</p>
                <ul class="list">
                    <li class="li_elements "><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/choose-ruti-fullfill-page')}}"> Fulfillment Plan </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/supplier-wallet')}}">Add Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/receive-wallet')}}">Receive Funds to Wallet </a></div></li>
                    <li class="li_elements"><div class="d-flex justify-content-between"><a class="links" href="{{url('supplier/withdraw-wallet')}}">Withdraw Funds </a></div></li>
                </ul>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 third_column">
                <p class="headings"><img src="{{ asset('public/panel/images/receive_dollar.png') }}" width="30px" height="30px" alt="funds receive"> MARKETPLACE</p>
                {{-- <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Marketplace</p> --}}
                <ul class="list">
                    @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                    <li class="li_elements {{ (request()->is('supplier/marketplace-orders') || request()->is('supplier/marketplace-orders/*')) ? 'active' : '' }}">
                        <a class="links" href="{{url('supplier/marketplace-orders')}}">
                        Marketplace Orders
                        </a>
                    </li>
                    @endif
                </ul>
                <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Manage Account</p>
                {{-- <p class="headings"><img src="{{ asset('public/panel/images/icon_c1.png') }}" width="30px" height="30px" alt="manage plans">Marketplace</p> --}}
                <ul class="list">
                    <li class="li_elements "><div class="d-flex justify-content-between">
                        <a class="links" href="{{ url('/supplier/profile') }}"> View Profile </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="{{ asset('public/panel/app3.js') }}"></script>
  </body>
</html>
