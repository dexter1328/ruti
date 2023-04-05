<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="{{ config('app.name', 'RUTI Self Checkout') }}" />
        <meta property="og:description" content="We provide convenient and expeditious service to all users (merchants and consumers) in areas of consumer spending. Our service is to improve merchant - customer relations while offering positive contribution to the overall economy." />
        <meta property="og:image" content="{{ asset('images/logo-icon.png') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://rutiselfcheckout.com/" />
        <meta property="fb:app_id" content="482623692719207" />

        <title>{{ config('app.name', 'RUTI Self Checkout') }}</title>
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
        });
        </script>
        <!-- Index js -->
        <!--<script src="{{ asset('js/index.js') }}"></script>-->

        <!-- Scripts -->
        <!--<script src="/js/app.js"></script>-->
        <!--<script src="{{ asset('js/app.js') }}"></script>-->
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
				<a href="{{url('employee/home')}}">
					<img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
					<span class="logo-mini"><img src="{{ asset('images/ez-icon-white.png') }}" class="logo-icon" alt="logo icon"></span>
				</a>
			</div>
            <ul class="sidebar-menu do-nicescrol">
                <li>
                    <a href="{{url('employee/home')}}" class="waves-effect">
                        <i class="fa fa-home"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/header')) ? 'active' : '' }}">
                    <a href="{{ url('employee/header') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Header</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/about')) ? 'active' : '' }}">
                    <a href="{{ url('employee/about') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage About US</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/vendors')) ? 'active' : '' }}">
                    <a href="{{ url('employee/vendors') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Vendors</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/features')) ? 'active' : '' }}">
                    <a href="{{ url('employee/features') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Features</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/faq')) ? 'active' : '' }}">
                    <a href="{{ url('employee/faq') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage FAQ's</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/download')) ? 'active' : '' }}">
                    <a href="{{ url('employee/downloads') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Download</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/client-feedback')) ? 'active' : '' }}">
                    <a href="{{ url('employee/client-feedback') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Client Feedback</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/dmca')) ? 'active' : '' }}">
                    <a href="{{ url('employee/dmca') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage DMCA</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/terms-conditions')) ? 'active' : '' }}">
                    <a href="{{ url('employee/terms-conditions') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Terms & Conditions</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/privacy-policy')) ? 'active' : '' }}">
                    <a href="{{ url('employee/privacy-policy') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Privacy Policy</span>
                    </a>
                </li>
                <li class="{{ (request()->is('employee/footer')) ? 'active' : '' }}">
                    <a href="{{ url('employee/footer') }}" class="waves-effect">
                        <i class="fa fa-file-code-o"></i><span>Manage Footer</span>
                    </a>
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
                     <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#" style="font-size: 14px;font-weight: 500;">
                            <span class="user-profile">
                            @if(Auth::user()->image)
                                @php $image = asset('images/employees/'.Auth::user()->image); @endphp
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
                                            @php $image = asset('images/employees/'.Auth::user()->image); @endphp
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
                                <a href="{{ url('/employee/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power mr-2"></i> Logout</li></a>
                                    <form id="logout-form" action="{{ url('/employee/logout') }}" method="POST" style="display: none;">
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
                            RUTI Self Checkout &copy; 2019-2024. All Rights Reserved
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
