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
        <meta property="og:image" content="{{ asset('images/logo-icon.png') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://naturecheckout.com/" />
        <meta property="fb:app_id" content="482623692719207" />

        <title>{{ config('app.name', 'Nature Checkout') }}</title>
        <!--favicon-->
        <link rel="icon" href="{{ asset('images/logo-icon-xx.png') }}" type="image/x-icon">
        <!-- Vector CSS -->
        <link href="{{ asset('plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
        <!-- simplebar CSS-->
        <link href="{{ asset('plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
        <!-- Bootstrap core CSS-->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
        <!--Data Tables -->
        <link href="{{ asset('plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <!-- animate CSS-->
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Icons CSS-->
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Sidebar CSS-->
        <link href="{{ asset('css/sidebar-menu.css') }}" rel="stylesheet"/>
        <!-- Custom Style-->
        <link href="{{ asset('css/app-style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
        <link rel="stylesheet" href="{{asset('plugins/summernote/dist/summernote-bs4.css')}}"/>
        <!-- multi select -->
        <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
        <!-- nestable css -->
        <link rel="stylesheet" href="{{asset('css/nestable.css')}}">
        <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <!-- custome_css -->
        <link href="{{ asset('css/custom_style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/wickedpicker.min.css') }}" rel="stylesheet"/>
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
        </style>

        <!-- Styles -->
        <!--<link href="/css/app.css" rel="stylesheet">-->
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
        <!-- Scripts -->
        <script>
        window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]); ?>
        </script>
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- simplebar js -->
        <script src="{{ asset('plugins/simplebar/js/simplebar.js') }}"></script>
        <!-- sidebar-menu js -->
        <script src="{{ asset('js/sidebar-menu.js') }}"></script>
        <!-- loader scripts -->
        <!--   <script src="{{ asset('js/jquery.loading-indicator.js') }}"></script> -->
        <!-- Custom scripts -->
        <script src="{{ asset('js/app-script.js') }}"></script>

        <script src="{{ asset('plugins/Chart.js/Chart.min.js') }}"></script>

        <!-- nestable js -->
        <script src="{{ asset('js/jquery.nestable.js') }}"></script>

        <!--Data Tables js-->
        <script src="{{ asset('plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ asset('plugins/jquery-knob/excanvas.js') }}"></script>
        <script src="{{ asset('plugins/jquery-knob/jquery.knob.js') }}"></script>

        <!-- Easy Pie Chart JS -->
        <script src="{{ asset('plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
        <script src="{{asset('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
        <!-- Sparkline JS -->
        <script src="{{ asset('plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
        <!-- Vector map JavaScript -->
        <script src="{{ asset('plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ asset('plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('plugins/vectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
        <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/jquery.prettyPhoto.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('js/wickedpicker.min.js') }}" type="text/javascript" charset="utf-8"></script>
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
                url: "{{ url('/vendor/vendors/inventory_update_reminder_check/'.Auth::user()->id) }}",
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
        <!--<script src="{{ asset('js/index.js') }}"></script>-->

        <!-- Scripts -->
        <!--<script src="/js/app.js"></script>-->
        <!--<script src="{{ asset('js/app.js') }}"></script>-->

        <script type="text/javascript">
        window.Trengo = window.Trengo || {};
        window.Trengo.key = 'oxmtCRRS03uVdb6mASWz';
        (function(d, script, t) {
        script = d.createElement('script');
        script.type = 'text/javascript';
        script.async = true;
        script.src = 'https://static.widget.trengo.eu/embed.js';
        d.getElementsByTagName('head')[0].appendChild(script);
        }(document));
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
				<a href="{{url('vendor/home')}}">
					<img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
					<span class="logo-mini"><img src="{{ asset('images/ez-icon-white.png') }}" class="logo-icon" alt="logo icon"></span>
				</a>
			</div>
            <ul class="sidebar-menu do-nicescrol">
                @if($data['percentage'] < 100)
                <li style="margin: 15px;">
                    <div class="list-group">
                        <a href="{{url('vendor/profile')}}" class="list-group-item" style="background-color: #fff; border-color: #fff;">
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
                @endif
                <li>
                    <a href="{{url('vendor/home')}}" class="waves-effect">
                        <i class="fa fa-home"></i><span>Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->parent_id == 0)
                    <li class="{{ (request()->is('vendor/choose-plan') or request()->is('vendor/active-plans')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-book"></i><span>Manage Plans</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="{{ request()->is('vendor/choose-plan') ? 'active' : '' }}">
                                <a href="{{url('vendor/choose-plan')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Choose Plan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('vendor/active-plans') ? 'active' : '' }}">
                                <a href="{{url('vendor/active-plans')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Active Plan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('vendor/profile#manage-card') ? 'active' : '' }}">
                                <a href="{{url('vendor/profile#manage-card')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i><span>Manage Cards</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'vendors','read') || vendor_has_permission(Auth::user()->role_id,'vendor_roles','read') || vendor_has_permission(Auth::user()->role_id,'stores','read') || vendor_has_permission(Auth::user()->role_id,'vendor_coupons','read') )
                    <li class="{{ (request()->is('vendor/vendors') or request()->is('vendor/vendors/*') or request()->is('vendor/vendor_roles') or request()->is('vendor/vendor_roles/*') or request()->is('vendor/stores/*') or request()->is('vendor/vendor_configuration/*') or request()->is('vendor/vendor_coupons/*') or request()->is('vendor/vendor_coupons_used/*')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-user-circle"></i><span>Manage Vendor Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'stores','read'))
                            <li class="{{ (request()->is('vendor/stores') or request()->is('vendor/stores/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/stores')}}" class="waves-effect">
                                    <i class="fa fa-shopping-bag" style="font-size: 12px;"></i>Manage Store
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'vendor_roles','read'))
                                <li class="{{ (request()->is('vendor/vendor_roles') or request()->is('vendor/vendor_roles/*')) ? 'active' : '' }}">
                                    <a href="{{url('vendor/vendor_roles')}}" class="waves-effect">
                                        <i class="fa fa-edit"></i>Manage Role
                                    </a>
                                </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'vendors','read'))
                                <li class="{{ (request()->is('vendor/vendors') or request()->is('vendor/vendors/*')) ? 'active' : '' }}">
                                    <a href="{{url('vendor/vendors')}}">
                                        <i class="fa fa-user"></i>Manage Employee
                                    </a>
                                </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'vendor_coupons','read'))
                                <li class="{{ (request()->is('vendor/vendor_coupons') or request()->is('vendor/vendor_coupons/*')) ? 'active' : '' }}">
                                    <a href="{{url('vendor/vendor_coupons')}}" class="waves-effect">
                                        <i class="fa fa-tags"></i>Manage Coupon
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'products','read') || vendor_has_permission(Auth::user()->role_id,'product_reviews','read') || vendor_has_permission(Auth::user()->role_id,'categories','read') || vendor_has_permission(Auth::user()->role_id,'attributes','read') || vendor_has_permission(Auth::user()->role_id,'brand','read'))
                    <li class="{{ (request()->is('vendor/products/*') or request()->is('vendor/product_reviews/*') or request()->is('vendor/categories/*') or request()->is('vendor/attributes/*') or request()->is('vendor/brand/*') or request()->is('vendor/discount_offers/*')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-list"></i><span>Manage Product Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'categories','read'))
                            <li class="{{ (request()->is('vendor/categories') or request()->is('vendor/categories/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/categories')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Category
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'attributes','read'))
                            <li class="{{ (request()->is('vendor/attributes') or request()->is('vendor/attributes/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/attributes')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Attribute
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'brand','read'))
                            <li class="{{ (request()->is('vendor/brand') or request()->is('vendor/brand/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/brand')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Brand
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'products','read'))
                            <li class="{{ (request()->is('vendor/products') or (request()->is('vendor/products/*') && !request()->is('vendor/products/inventory'))) ? 'active' : '' }}">
                                <a href="{{url('vendor/products')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product
                                </a>
                            </li>
                            <li class="{{ (request()->is('vendor/products/inventory')) ? 'active' : '' }}">
                                <a href="{{url('vendor/products/inventory')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Stock
                                </a>
                            </li>
                            <li class="{{ (request()->is('vendor/products/generate-barcodes')) ? 'active' : '' }}">
                                <a href="{{url('vendor/products/generate-barcodes')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Barcode
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'product_reviews','read'))
                            <li class="{{ (request()->is('vendor/product_reviews') or request()->is('vendor/product_reviews/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/product_reviews')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Review
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'orders','read') || vendor_has_permission(Auth::user()->role_id,'order_return','read') || vendor_has_permission(Auth::user()->role_id,'cancelled_orders','read'))
                    <li class="{{ (request()->is('vendor/orders/*') or request()->is('vendor/order_return/*') or request()->is('vendor/cancelled_orders/*') or request()->is('vendor/orders/inshop_order') or request()->is('vendor/orders/pickup_order')
                         or request()->is('vendor/orders/return/request')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-shopping-cart"></i><span>Manage Orders Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'orders','read'))
                            <li class="{{ (request()->is('vendor/orders') or request()->is('vendor/orders/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/orders')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
                                </a>
                            </li>
                            <li class="{{ (request()->is('vendor/orders/inshop_order')) ? 'active' : '' }}">
                                <a href="{{url('vendor/orders/inshop_order')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage In Store Order
                                </a>
                            </li>
                            <li class="{{ (request()->is('vendor/orders/pickup_order')) ? 'active' : '' }}">
                                <a href="{{url('vendor/orders/pickup_order')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Pickup Order
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'order_return','read'))
                            <li class="{{ (request()->is('vendor/orders/return/request')) ? 'active' : '' }}">
                                <a href="{{url('vendor/orders/return/request')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Request Orders
                                </a>
                            </li>
                            <li class="{{ (request()->is('vendor/order_return') or request()->is('vendor/order_return/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/order_return')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders Return
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'cancelled_orders','read'))
                            <li class="{{ (request()->is('vendor/cancelled_orders') or request()->is('vendor/cancelled_orders/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/cancelled_orders')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Cancel Orders
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'customer','read') || vendor_has_permission(Auth::user()->role_id,'customer_transaction','read'))
                    <li class="{{ (request()->is('vendor/customer/*') or request()->is('vendor/customer_feedback/*') or request()->is('vendor/customer_reviews/*') or request()->is('vendor/customer_reward_points/*') or request()->is('vendor/customer_used_reward_points/*') or request()->is('vendor/customer_transaction') or request()->is('vendor/customer_transaction/*')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-user-circle"></i><span>Manage Customer Details</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'customer','read'))
                            <li class="{{ (request()->is('vendor/customer') or request()->is('vendor/customer/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/customer')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Manage Customer
                                </a>
                            </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'customer_transaction','read'))
                            <li class="{{ (request()->is('vendor/customer_transaction') or request()->is('vendor/customer_transaction/*')) ? 'active' : '' }}">
                                <a href="{{url('vendor/customer_transaction')}}" class="waves-effect">
                                    <i class="zmdi zmdi-dot-circle-alt"></i>Customer Transaction
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'newsletters','read') || vendor_has_permission(Auth::user()->role_id,'push_notifications','read') )
                    <li class="{{ (request()->is('vendor/newsletters/*') or request()->is('vendor/push_notifications/*')) ? 'active menu-open' : '' }}">
                        <a href="javaScript:void();" class="waves-effect">
                            <i class="fa fa-globe"></i><span>Manage Front Website</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @if(vendor_has_permission(Auth::user()->role_id,'newsletters','read'))
                                <li class="{{ (request()->is('vendor/newsletters') or request()->is('vendor/newsletters/*')) ? 'active' : '' }}">
                                    <a href="{{url('vendor/newsletters')}}" class="waves-effect">
                                        <i class="fa fa-newspaper-o"></i>Manage Newsletters
                                    </a>
                                </li>
                            @endif
                            @if(vendor_has_permission(Auth::user()->role_id,'push_notifications','read'))
                                <li class="{{ (request()->is('vendor/push_notifications') or request()->is('vendor/push_notifications/*')) ? 'active' : '' }}">
                                    <a href="{{url('vendor/push_notifications')}}" class="waves-effect">
                                        <i class="fa fa-bell"></i>Manage Push Notification
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(vendor_has_permission(Auth::user()->role_id,'setting','read') )
                    <li class="{{ (request()->is('vendor/settings') or request()->is('vendor/settings/*')) ? 'active' : '' }}">
                        <a href="{{url('vendor/settings')}}" class="waves-effect">
                            <i class="fa fa-cog"></i><span>Manage Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
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
                </ul>
                <ul class="navbar-nav align-items-center right-nav-link">
                     <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#" style="font-size: 14px;font-weight: 500;">
                            <span class="user-profile">
                             @if(Auth::user()->image)
                                @php $image = asset('images/vendors/'.Auth::user()->image); @endphp
                                <img class="align-self-start mr-3" src="{{$image}}">
                            @else
                                <img src="{{asset('images/User-Avatar.png')}}" class="align-self-start mr-3" alt="user avatar">
                            @endif
                            </span>
                            {{Auth::user()->name}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar">
                                        @if(Auth::user()->image)
                                            @php $image = asset('images/vendors/'.Auth::user()->image); @endphp
                                            <img class="align-self-start mr-3" src="{{$image}}">
                                        @else
                                            <img src="{{asset('images/User-Avatar.png')}}" class="align-self-start mr-3" alt="user avatar">
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
                                <a href="{{ url('/vendor/profile') }}">
                                    <i class="icon-user"></i> My Profile
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li> -->
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power mr-2"></i> Logout</li></a>
                                    <form id="logout-form" action="{{ url('/vendor/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </header>
    <!--End topbar header-->
        <div class="clearfix"></div>
            <div class="content-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="container">
                        <div class="text-center">
                            Nature Checkout &copy; 2019-2024. All Rights Reserved
                        </div>
                    </div>
                </footer>
        <!-- End container-fluid-->
            </div>
    </div>
    <!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
    <!--Start footer-->
    <!--End footer-->
</body>
</html>
