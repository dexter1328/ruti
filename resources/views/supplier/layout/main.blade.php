<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="{{ config('app.name', 'EZShop') }}" />
        <meta property="og:description" content="We provide convenient and expeditious service to all users (merchants and consumers) in areas of consumer spending. Our service is to improve merchant - customer relations while offering positive contribution to the overall economy." />
        <meta property="og:image" content="{{ asset('public/images/logo-icon.png') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://rutiselfcheckout.com/" />
        <meta property="fb:app_id" content="482623692719207" />

        <title>{{ config('app.name', 'Nature Checkout') }}</title>
        <!--favicon-->
        <link rel="icon" href="{{ asset('public/images/logo-icon-xx.png') }}" type="image/x-icon">
        <!-- Vector CSS -->
        <link href="{{ asset('public/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
        <!-- simplebar CSS-->
        <link href="{{ asset('public/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
        <!-- Bootstrap core CSS-->
        <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!--Data Tables -->
        <link href="{{ asset('public/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <!-- animate CSS-->
        <link href="{{ asset('public/css/animate.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Icons CSS-->
        <link href="{{ asset('public/css/icons.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Sidebar CSS-->
        <link href="{{ asset('public/css/sidebar-menu.css') }}" rel="stylesheet"/>
        <!-- Custom Style-->
        <link href="{{ asset('public/css/app-style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('public/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
        <link rel="stylesheet" href="{{asset('public/plugins/summernote/dist/summernote-bs4.css')}}"/>
        <!-- multi select -->
        <link href="{{asset('public/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
        <!-- nestable css -->
        <link rel="stylesheet" href="{{asset('public/css/nestable.css')}}">
        <link rel="stylesheet" href="{{ asset('public/css/prettyPhoto.css') }}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <!-- custome_css -->
        <link href="{{ asset('public/css/custom_style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('public/css/new_style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('public/css/wickedpicker.min.css') }}" rel="stylesheet"/>
        <style type="text/css">
            .fa.fa-angle-down{
            float: right;
            }

            .sidebar-submenu.menu-open{

            display: block;
            left: 16px;
            position: relative;
            }
            .sidebar-menu .sidebar-submenu>li.active>a, .sidebar-menu .sidebar-submenu>li>a:hover {

            background: rgba(255, 255, 255, 0.15);
            }
            .wrapper{
            min-height: 100vh;
            }
            .content-wrapper{
            min-height: 100vh;
            }
            .back_btn:hover {
                opacity: 60%;
            }
        </style>

        <!-- Styles -->
        <!--<link href="/css/app.css" rel="stylesheet">-->
        <!-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> -->
        <!-- Scripts -->
        @php
        $csrfToken = csrf_token();
        @endphp

        <script>
            window.Laravel = {
                csrfToken: @json($csrfToken)
            };
        </script>
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('public/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/js/popper.min.js') }}"></script>
        <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
        <!-- simplebar js -->
        <script src="{{ asset('public/plugins/simplebar/js/simplebar.js') }}"></script>
        <!-- sidebar-menu js -->
        <script src="{{ asset('public/js/sidebar-menu.js') }}"></script>
        <!-- loader scripts -->
        <!--   <script src="{{ asset('public/js/jquery.loading-indicator.js') }}"></script> -->
        <!-- Custom scripts -->
        <script src="{{ asset('public/js/app-script.js') }}"></script>

        <script src="{{ asset('public/plugins/Chart.js/Chart.min.js') }}"></script>

        <!-- nestable js -->
        <script src="{{ asset('public/js/jquery.nestable.js') }}"></script>

        <!--Data Tables js-->
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ asset('public/plugins/jquery-knob/excanvas.js') }}"></script>
        <script src="{{ asset('public/plugins/jquery-knob/jquery.knob.js') }}"></script>

        <!-- Easy Pie Chart JS -->
        <script src="{{ asset('public/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
        <script src="{{asset('public/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
        <!-- Sparkline JS -->
        <script src="{{ asset('public/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
        <!-- Vector map JavaScript -->
        <script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
        <script src="{{ asset('public/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/jquery.prettyPhoto.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('public/js/wickedpicker.min.js') }}" type="text/javascript" charset="utf-8"></script>
        <script>
        $( document ).ready(function() {
            $('#summernoteEditor').summernote({
                height: 400,
                tabsize: 2
            });
            $('.autoclose-datepicker').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            $("a[rel^='prettyPhoto']").prettyPhoto({
                social_tools:false,
                deeplinking:false,
            });

            //inventoryUpdateReminderCheck();
        });

        /*function inventoryUpdateReminderCheck()
        {
            $.ajax({
                type: "post",
                url: "{{ url('/supplier/suppliers/inventory_update_reminder_check/'.Auth::user()->id) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {

                }
            });
        }*/
        </script>
        <!-- Index js -->
        <!--<script src="{{ asset('public/js/index.js') }}"></script>-->

        <!-- Scripts -->
        <!--<script src="/js/app.js"></script>-->
        <!--<script src="{{ asset('public/js/app.js') }}"></script>-->

        <script type="text/javascript">
        // window.Trengo = window.Trengo || {};
        // window.Trengo.key = 'oxmtCRRS03uVdb6mASWz';
        // (function(d, script, t) {
        // script = d.createElement('script');
        // script.type = 'text/javascript';
        // script.async = true;
        // script.src = 'https://static.widget.trengo.eu/embed.js';
        // d.getElementsByTagName('head')[0].appendChild(script);
        // }(document));
        </script>
    </head>
<body>
    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner" >
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->
    <!-- Start wrapper-->
    <div id="wrapper">
        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" class="bg-theme bg-theme2" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
				<a href="{{url('supplier/home')}}">
					<img src="{{ asset('public/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
					<span class="logo-mini"><img src="{{ asset('public/images/ez-icon-white.png') }}" class="logo-icon" alt="logo icon"></span>
				</a>
			</div>
            <ul class="sidebar-menu do-nicescrol">
                {{-- @if($data['percentage'] < 100)
                <li style="margin: 15px;">
                    <div class="list-group">
                        <a href="{{url('supplier/profile')}}" class="list-group-item" style="background-color: #fff; border-color: #fff;">
                            <div class="progress-wrapper">
                                <strong class="d-block mb-2 text-center text-dark">
                                    Complete your profile
                                </strong>
                                <div class="progress" style="height: auto;">
                                    <div class="progress-bar bg-success" style="width: {{$data['percentage']}}%;">
                                        <span class="progress-value">{{$data['percentage']}}%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                @endif--}}
                <li>
                    <a href="{{url('supplier/home')}}" class="waves-effect">
                        <i class="fa fa-home"></i><span>Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->parent_id == 0)
                    <li class="{{ (request()->is('supplier/choose-plan') or request()->is('supplier/active-plans')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-book"></i><span>Manage Plans</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="{{ request()->is('supplier/choose-plan') ? 'active' : '' }}">
                                <a href="{{url('supplier/choose-plan')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Choose Plan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/choose-ruti-fullfill-page') ? 'active' : '' }}">
                                <a href="{{url('supplier/choose-ruti-fullfill-page')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Fullfilment Plan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/active-plans') ? 'active' : '' }}">
                                <a href="{{url('supplier/active-plans')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Active Plan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/profile#manage-card') ? 'active' : '' }}">
                                <a href="{{url('supplier/profile#manage-card')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Manage Cards</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/supplier-wallet') ? 'active' : '' }}">
                                <a href="{{url('supplier/supplier-wallet')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Add funds to Wallet</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/receive-wallet') ? 'active' : '' }}">
                                <a href="{{url('supplier/receive-wallet')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Receive funds to Wallet</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('supplier/withdraw-wallet') ? 'active' : '' }}">
                                <a href="{{url('supplier/withdraw-wallet')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Withdraw funds from Wallet</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'suppliers','read') || vendor_has_permission(Auth::user()->role_id,'vendor_roles','read') || vendor_has_permission(Auth::user()->role_id,'stores','read') || vendor_has_permission(Auth::user()->role_id,'vendor_coupons','read') )
                    <li class="{{ (request()->is('supplier/suppliers') or request()->is('supplier/suppliers/*') or request()->is('supplier/supplier_roles') or request()->is('supplier/supplier_roles/*') or request()->is('supplier/stores/*') or request()->is('supplier/supplier_configuration/*') or request()->is('supplier/supplier_coupons/*') or request()->is('supplier/supplier_coupons_used/*')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-user-circle"></i><span>Manage Supplier Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'vendor_roles','read'))
                                <li class="{{ (request()->is('supplier/supplier_roles') or request()->is('supplier/supplier_roles/*')) ? 'active' : '' }}">
                                    <a href="{{url('supplier/supplier_roles')}}" class="waves-effect">
                                        <i class="fa fa-edit"></i>Manage Role
                                    </a>
                                </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'suppliers','read'))
                                <li class="{{ (request()->is('supplier/suppliers') or request()->is('supplier/suppliers/*')) ? 'active' : '' }}">
                                    <a href="{{url('supplier/suppliers')}}">
                                        <i class="fa fa-user"></i>Manage Employee
                                    </a>
                                </li>
                            @endif
                           {{--@if(vendor_has_permission(Auth::user()->role_id,'vendor_coupons','read'))
                                <li class="{{ (request()->is('supplier/supplier_coupons') or request()->is('supplier/supplier_coupons/*')) ? 'active' : '' }}">
                                    <a href="{{url('supplier/supplier_coupons')}}" class="waves-effect">
                                        <i class="fa fa-tags"></i>Manage Coupon
                                    </a>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'products','read') || vendor_has_permission(Auth::user()->role_id,'product_reviews','read') || vendor_has_permission(Auth::user()->role_id,'categories','read') || vendor_has_permission(Auth::user()->role_id,'attributes','read') || vendor_has_permission(Auth::user()->role_id,'brand','read'))
                    <li class="{{ (request()->is('supplier/products/*') or request()->is('supplier/product_reviews/*') or request()->is('supplier/categories/*') or request()->is('supplier/attributes/*') or request()->is('supplier/brand/*') or request()->is('supplier/discount_offers/*')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-list"></i><span>Manage Product Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'categories','read'))
                            <li class="{{ (request()->is('supplier/categories') or request()->is('supplier/categories/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/categories')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Category
                                </a>
                            </li>
                            @endif
                            {{-- @if(vendor_has_permission(Auth::user()->role_id,'attributes','read'))
                            <li class="{{ (request()->is('supplier/attributes') or request()->is('supplier/attributes/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/attributes')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Attribute
                                </a>
                            </li>
                            @endif --}}
                            @if(vendor_has_permission(Auth::user()->role_id,'brand','read'))
                            <li class="{{ (request()->is('supplier/brand') or request()->is('supplier/brand/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/brand')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Brand
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'products','read'))
                            <li class="{{ (request()->is('supplier/products') or (request()->is('supplier/products/*') && !request()->is('supplier/products/inventory'))) ? 'active' : '' }}">
                                <a href="{{url('supplier/products')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product
                                </a>
                            </li>
                            <li class="{{ (request()->is('supplier/products/inventory')) ? 'active' : '' }}">
                                <a href="{{url('supplier/products/inventory')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Stock
                                </a>
                            </li>
                            {{-- <li class="{{ (request()->is('supplier/products/generate-barcodes')) ? 'active' : '' }}">
                                <a href="{{url('supplier/products/generate-barcodes')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Barcode
                                </a>
                            </li> --}}
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'product_reviews','read'))
                            <li class="{{ (request()->is('supplier/product_reviews') or request()->is('supplier/product_reviews/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/product_reviews')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Review
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'orders','read') || vendor_has_permission(Auth::user()->role_id,'order_return','read') || vendor_has_permission(Auth::user()->role_id,'cancelled_orders','read'))
                    <li class="{{ (request()->is('supplier/orders/*') || request()->is('supplier/order_return/*') || request()->is('supplier/cancelled_orders/*') || request()->is('supplier/orders/inshop_order') || request()->is('supplier/orders/pickup_order')
                         || request()->is('supplier/orders/return/request')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-shopping-cart"></i><span>Manage Orders Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                            <li class="{{ (request()->is('supplier/orders') || request()->is('supplier/orders/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/orders')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
                                </a>
                            </li>
                            {{-- <li class="{{ (request()->is('supplier/orders/inshop_order')) ? 'active' : '' }}">
                                <a href="{{url('supplier/orders/inshop_order')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage In Store Order
                                </a>
                            </li>
                            <li class="{{ (request()->is('supplier/orders/pickup_order')) ? 'active' : '' }}">
                                <a href="{{url('supplier/orders/pickup_order')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Pickup Order
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'order_return','read'))
                            <li class="{{ (request()->is('supplier/orders/return/request')) ? 'active' : '' }}">
                                <a href="{{url('supplier/orders/return/request')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Request Orders
                                </a>
                            </li>
                            <li class="{{ (request()->is('supplier/order_return') or request()->is('supplier/order_return/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/order_return')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders Return
                                </a>
                            </li> --}}
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'cancelled_orders','read'))
                            <li class="{{ (request()->is('supplier/cancelled_orders') or request()->is('supplier/cancelled_orders/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/cancelled_orders')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Cancel Orders
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'customer','read') || vendor_has_permission(Auth::user()->role_id,'customer_transaction','read'))
                    <li class="{{ (request()->is('supplier/customer/*') or request()->is('supplier/customer_feedback/*') or request()->is('supplier/customer_reviews/*') or request()->is('supplier/customer_reward_points/*') or request()->is('supplier/customer_used_reward_points/*') or request()->is('supplier/customer_transaction') or request()->is('supplier/customer_transaction/*')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-user-circle"></i><span>Manage Customer Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'customer','read'))
                            <li class="{{ (request()->is('supplier/customer') or request()->is('supplier/customer/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/customer')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Customer
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'customer_transaction','read'))
                            <li class="{{ (request()->is('supplier/customer_transaction') or request()->is('supplier/customer_transaction/*')) ? 'active' : '' }}">
                                <a href="{{url('supplier/customer_transaction')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Customer Transaction
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'newsletters','read') || vendor_has_permission(Auth::user()->role_id,'push_notifications','read') )
                    <li class="{{ (request()->is('supplier/newsletters/*') or request()->is('supplier/push_notifications/*')) ? 'active menu-open' : '' }}">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="fa fa-globe"></i><span>Manage Front Website</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            {{-- @if(vendor_has_permission(Auth::user()->role_id,'newsletters','read'))
                                <li class="{{ (request()->is('supplier/newsletters') or request()->is('supplier/newsletters/*')) ? 'active' : '' }}">
                            <a href="{{url('supplier/newsletters')}}" class="waves-effect">
                                <i class="fa fa-newspaper-o"></i>Manage Newsletters
                            </a>
                            </li>
                            @endif --}}
                            @if(vendor_has_permission(Auth::user()->role_id,'push_notifications','read'))
                                <li class="{{ (request()->is('supplier/push_notifications') or request()->is('supplier/push_notifications/*')) ? 'active' : '' }}">
                                    <a href="{{url('supplier/push_notifications')}}" class="waves-effect">
                                        <i class="fa fa-bell"></i>Manage Push Notification
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'setting','read') )
                    <li class="{{ (request()->is('supplier/settings') or request()->is('supplier/settings/*')) ? 'active' : '' }}">
                        <a href="{{url('supplier/settings')}}" class="waves-effect">
                            <i class="fa fa-cog"></i><span>Manage Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top justify-content-between">
                <!-- <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    @if(!empty($data['sales']))
                        <li>
                            <strong>Sales Person:</strong> {{$data['sales']->name}} - <a href="tel:+1{{$data['sales']->mobile}}">+1{{$data['sales']->mobile}}</a>
                        </li>
                    @endif
                </ul> -->
                <a class='text-dark mr-4 back_btn' id="goBackButton" href="#">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <ul class="navbar-nav align-items-center right-nav-link">
                     <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#" style="font-size: 14px;font-weight: 500;">
                            <span class="user-profile">
                             @if(Auth::user()->image)
                                @php $image = asset('public/images/suppliers/'.Auth::user()->image); @endphp
                                <img class="align-self-start mr-3" src="{{$image}}">
                            @else
                                <img src="{{asset('public/images/User-Avatar.png')}}" class="align-self-start mr-3" alt="user avatar">
                            @endif
                            </span>
                            {{Auth::user()->name}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="avatar">
                                        @if(Auth::user()->image)
                                            @php $image = asset('public/images/suppliers/'.Auth::user()->image); @endphp
                                            <img class="align-self-start mr-3" src="{{$image}}">
                                        @else
                                            <img src="{{asset('public/images/User-Avatar.png')}}" class="align-self-start mr-3" alt="user avatar">
                                        @endif
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                                            <p class="user-subtitle">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="{{ url('/supplier/profile') }}">
                                    <i class="icon-user"></i> My Profile
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li> -->
                            {{-- <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power mr-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ url('/supplier/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li> --}}
                        </ul>
                    </li>

                </ul>
            </nav>
        </header>
    <!--End top-bar header-->
        <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="container">
                        <div class="text-center">
                            Nature Checkout &copy;2019-{{date('Y')}}. All Rights Reserved
                        </div>
                    </div>
                </footer>
        <!-- End container-fluid-->
            </div>
    </div>
    <!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javascript:void(0);" class="back-to-top">
        <i class="fa fa-angle-double-up"></i>
    </a>
    <!--End Back To Top Button-->
    <!--Start footer-->
    <!--End footer-->
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const backButton = document.getElementById("goBackButton");

    if (backButton) {
        backButton.addEventListener("click", function () {
            window.history.back();
        });
    }
});
</script>


</html>
