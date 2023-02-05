<!DOCTYPE html>
<html lang="en">
<head>
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EZShop') }}</title>
    <!-- custome_css -->
    <link href="{{ asset('public/css/custom_style.css') }}" rel="stylesheet"/>
    <!--favicon-->
    <link rel="icon" href="{{ asset('public/images/favicon.ico') }}" type="image/x-icon">
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
    <link rel="stylesheet" href="{{asset('public/plugins/summernote/dist/summernote-bs4.css')}}"/>
    <link href="{{asset('public/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <!-- Styles -->
    <!--<link href="/css/app.css" rel="stylesheet">-->
    <!-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> -->
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
    
    <!-- Scripts -->
    <!--<script src="/js/app.js"></script>-->
    <!-- <script src="{{ asset('public/js/app.js') }}"></script>  -->
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
                    <img src="{{ asset('public/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    <!-- <h5 class="logo-text">EZShop Admin</h5> -->
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol">
                <li>
                    <a href="{{url('vendor/home')}}" class="waves-effect">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/create') or request()->is('admin/admin_roles') or request()->is('admin/admin_roles/create')) ? 'active menu-open' : '' }}">
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="fa fa-user-circle"></i>
                        <span>Manage Vendors</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li class="{{ (request()->is('vendor/vendors') or request()->is('vendor/vendors/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/vendors')}}">
                                <i class="fa fa-user"></i> All Vendors
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/vendor_roles') or request()->is('vendor/vendor_roles/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/vendor_roles')}}" class="waves-effect">
                                <i class="fa fa-edit"></i>Manage Roles
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->is('vendor/vendor/create') or request()->is('vendor/stores/create') or request()->is('vendor/vendor_configuration/create') or request()->is('vendor/vendor_coupons/create') or request()->is('vendor/vendor_coupons_used/create')) ? 'active menu-open' : '' }}">
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="fa fa-users"></i>
                        <span>Manage Vendors Details</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li class="{{ (request()->is('vendor/stores') or request()->is('vendor/stores/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/stores')}}" class="waves-effect">
                                <i class="fa fa-shopping-bag" style="font-size: 12px;"></i>
                                <span>Manage Store</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/vendor_configuration') or request()->is('vendor/vendor_configuration/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/vendor_configuration')}}" class="waves-effect">
                                <i class="fa fa-cog"></i>
                                <span>Manage Configuration</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/vendor_coupons') or request()->is('vendor/vendor_coupons/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/vendor_coupons')}}" class="waves-effect">
                                <i class="fa fa-file"></i>
                                <span>Manage Coupons</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/vendor_coupons_used') or request()->is('vendor/vendor_coupons_used/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/vendor_coupons_used')}}" class="waves-effect">
                                <i class="fa fa-file"></i>
                                <span>Manage UsedCoupons</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->is('vendor/brand/create') or request()->is('vendor/products/create') or request()->is('vendor/vendors_category/create') or request()->is('vendor/attributes/*')) ? 'active menu-open' : '' }}">
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="fa fa-product-hunt"></i>
                        <span>Manage Product Details</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li class="{{ (request()->is('vendor/products') or request()->is('vendor/products/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/products')}}" class="waves-effect">
                                <i class="fa fa-product-hunt"></i>
                                <span>Manage Products</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/products/inventory')) ? 'active' : '' }}">
                            <a href="{{url('vendor/products/inventory')}}" class="waves-effect">
                                <i class="fa fa-product-hunt"></i>
                                <span>Manage Products Inventory</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/product_reviews') or request()->is('vendor/product_reviews/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/product_reviews')}}" class="waves-effect">
                                <i class="fa fa-star"></i>
                                <span>Manage Reviews</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/categories') or request()->is('vendor/categories/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/categories')}}" class="waves-effect">
                                <i class="fa fa-minus-square"></i>
                                <span>Manage Category</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('vendor/attributes/*') ? 'active' : '' }}">
                            <a href="{{url('vendor/attributes')}}" class="waves-effect">
                                <i class="fa fa-list"></i>
                                <span>Manage Attributes</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/brand') or request()->is('vendor/brand/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/brand')}}" class="waves-effect">
                                <i class="fa fa-glide-g"></i>
                                <span>Manage Brands</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/discount_offers') or request()->is('vendor/discount_offers/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/discount_offers')}}" class="waves-effect">
                                <i class="fa fa-glide-g"></i>
                                <span>Manage Discount Offers</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->is('vendor/customer/create') or request()->is('vendor/customer_feedback/create') or request()->is('vendor/customer_reviews/create') or request()->is('vendor/customer_reward_point/create')) ? 'active menu-open' : '' }}">
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="fa fa-user-o"></i>
                        <span>Manage Customers Details</span>
                          <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li class="{{ (request()->is('vendor/customer') or request()->is('vendor/customer/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/customer')}}" class="waves-effect">
                                <i class="fa fa-user"></i>
                                <span>Manage Customers</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/customer_feedback') or request()->is('vendor/customer_feedback/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/customer_feedback')}}" class="waves-effect">
                                <i class="fa fa-building-o"></i>
                                <span>Manage Feedback</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/customer_reviews') or request()->is('vendor/customer_reviews/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/customer_reviews')}}" class="waves-effect">
                                <i class="fa fa-building-o"></i>
                                <span>Manage Reviews</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/customer_reward_point') or request()->is('vendor/customer_reward_point/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/customer_reward_point')}}" class="waves-effect">
                                <i class="fa fa-inr"></i>
                                <span>Manage Reward Points</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->is('vendor/orders/create') or request()->is('vendor/order_items/create') or request()->is('vendor/order_return/create') or request()->is('vendor/cancelled_orders/create')) ? 'active menu-open' : '' }}">
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Manage Orders Details</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li class="{{ (request()->is('vendor/orders') or request()->is('vendor/orders/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/orders')}}" class="waves-effect">
                                <i class="fa fa-shopping-bag"></i>
                                <span>Manage Orders</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/order_return') or request()->is('vendor/order_return/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/order_return')}}" class="waves-effect">
                                <i class="fa fa-file-text-o"></i>
                                <span>Manage Orders Return</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('vendor/cancelled_orders') or request()->is('vendor/cancelled_orders/create')) ? 'active' : '' }}">
                            <a href="{{url('vendor/cancelled_orders')}}" class="waves-effect">
                                <i class="fa fa-file-text-o"></i>
                                <span>Manage Cancel Orders</span>
                            </a>
                        </li>
                    </ul>
                </li>
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
                </ul>
                <ul class="navbar-nav align-items-center right-nav-link">
                   <!--  <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-envelope-open-o"></i>
                            <span class="badge badge-light badge-up">12</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 12 new messages
                                    <span class="badge badge-light">12</span>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar">
                                                <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Jhon Deo</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>Today, 4:10 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar">
                                                <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Sara Jen</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>Yesterday, 8:30 AM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar">
                                                <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Dannish Josh</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>5/11/2018, 2:50 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar">
                                                <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet.</p>
                                                <small>1/11/2018, 2:50 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item text-center">
                                    <a href="javaScript:void();">See All Messages</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge badge-info badge-up">14</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 14 Notifications
                                    <span class="badge badge-info">14</span>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Registered Users</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-coffee fa-2x mr-3 text-warning"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Received Orders</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-notifications-active fa-2x mr-3 text-danger"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Updates</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item text-center">
                                    <a href="javaScript:void();">See All Notifications</a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                     <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
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
                            Copyright © 2019 EZSiop 
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
<script src="{{ asset('public/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}">
</script>
<script src="{{asset('public/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Sparkline JS -->
<script src="{{ asset('public/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
<!-- Vector map JavaScript -->
<script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('public/plugins/vectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<!-- nested menu css and js -->
<script src=" {{ asset('public/js/jquery.nestable.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/css/nestable.css') }}">
    <script src="{{ asset('public/plugins/select2/js/select2.min.js') }}"></script>
<script>
   $('#summernoteEditor').summernote({
    height: 400,
    tabsize: 2
});
   $('.autoclose-datepicker').datepicker({
  autoclose: true,
  todayHighlight: true
});

   $('.autoclose-datepicker1').datepicker({
  autoclose: true,
  todayHighlight: true
});
</script>
</body>
</html>
