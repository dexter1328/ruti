<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Nature Checkout') }}</title>
		<!--favicon-->
		<link rel="icon" href="{{asset('public/wb/img/logo/logo2.png')}}" type="image/x-icon">
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
		<script>
		$( document ).ready(function() {
			$('#summernoteEditor').summernote({
				height: 400,
				tabsize: 2
			});
			$('#autoclose-datepicker').datepicker({
				autoclose: true,
				todayHighlight: true
			});
			$('#autoclose-datepicker1').datepicker({
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
		<!--<script src="{{ asset('public/js/index.js') }}"></script>-->

		<!-- Scripts -->
		<!--<script src="/js/app.js"></script>-->
		<!--<script src="{{ asset('public/js/app.js') }}"></script>-->
	</head>
	<body>
		<!-- start loader -->
		<!-- <div id="pageloader-overlay" class="visible incoming">
			<div class="loader-wrapper-outer">
				<div class="loader-wrapper-inner" >
					<div class="loader"></div>
				</div>
			</div>
		</div> -->
		<!-- end loader -->
		<!-- Start wrapper-->
		<div id="wrapper">
			<!--Start sidebar-wrapper-->
			<div id="sidebar-wrapper" class="bg-theme bg-theme2" data-simplebar="" data-simplebar-auto-hide="true">
				<div class="brand-logo">
					<a href="{{url('admin/home')}}">
						<img src="{{ asset('public/wb/img/new_homepage/logo/logo.png') }}" class="logo-icon" alt="logo icon">
						<span class="logo-mini"><img src="{{ asset('public/images/ez-icon-white.png') }}" class="logo-icon" alt="logo icon"></span>
					</a>
				</div>
				<ul class="sidebar-menu do-nicescrol">
					<li>
						<a href="{{url('admin/home')}}" class="waves-effect">
							<i class="fa fa-home"></i><span>Dashboard</span>
						</a>
					</li>
					<li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*') or request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-user-circle"></i><span>Manage Admins</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*')) ? 'active' : '' }}">
								<a href="{{url('admin/admins')}}">
									<i class="fa fa-user"></i>All Admins
								</a>
							</li>
							<li class="{{ (request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active' : '' }}">
								<a href="{{url('admin/admin_roles')}}" class="waves-effect">
									<i class="fa fa-edit"></i>Manage Roles
								</a>
							</li>
						</ul>
					</li>
					<li class="{{ (request()->is('admin/pages/*') or request()->is('admin/menus/*') or request()->is('admin/banners/*') or request()->is('admin/galleries/*') or request()->is('admin/newsletters/*') or request()->is('admin/push_notifications/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-globe"></i><span>Manage Front Website</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/menus') or request()->is('admin/menus/*')) ? 'active' : '' }}">
								<a href="{{url('admin/menus')}}" class="waves-effect">
									<i class="fa fa-bars"></i>Manage Menus
								</a>
							</li>
							<li class="{{ (request()->is('admin/pages') or request()->is('admin/pages/*')) ? 'active' : '' }}">
								<a href="{{url('admin/pages')}}" class="waves-effect">
									<i class="fa fa-file"></i>Manage Pages
								</a>
							</li>
							<li class="{{ (request()->is('admin/banners') or request()->is('admin/banners/*')) ? 'active' : '' }}">
								<a href="{{url('admin/banners')}}" class="waves-effect">
									<i class="fa fa-picture-o"></i>Manage Banners
								</a>
							</li>
							<li class="{{ (request()->is('admin/galleries') or request()->is('admin/galleries/*')) ? 'active' : '' }}">
								<a href="{{url('admin/galleries')}}" class="waves-effect">
									<i class="fa fa-picture-o"></i>Manage Galleries
								</a>
							</li>
							<li class="{{ (request()->is('admin/newsletters') or request()->is('admin/newsletters/*')) ? 'active' : '' }}">
								<a href="{{url('admin/newsletters')}}" class="waves-effect">
									<i class="fa fa-newspaper-o"></i>Manage Newsletters
								</a>
							</li>
							<li class="{{ (request()->is('admin/push_notifications') or request()->is('admin/push_notifications/*')) ? 'active' : '' }}">
								<a href="{{url('admin/push_notifications')}}" class="waves-effect">
									<i class="fa fa-bell"></i>Manage Push Notifications
								</a>
							</li>
						</ul>
					</li>
					<li class="{{ (request()->is('admin/reward_points') or request()->is('admin/reward_points/*')) ? 'active' : '' }}">
						<a href="{{url('admin/reward_points')}}" class="waves-effect">
							<i class="fa fa-trophy"></i><span>Manage Reward Points</span>
						</a>
					</li>
					<li class="{{ (request()->is('admin/membership') or request()->is('admin/membership/*')) ? 'active' : '' }}">
						<a href="{{url('admin/membership')}}" class="waves-effect">
							<i class="fa fa-users"></i><span>Manage Memberships</span>
						</a>
					</li>
					<li class="{{ (request()->is('admin/vendor/*') or request()->is('admin/vendor_store/*') or request()->is('admin/vendor_configuration/*') or request()->is('admin/vendor_coupons/*') or request()->is('admin/vendor_coupons_used/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-users"></i><span>Manage Vendors Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor')}}" class="waves-effect">
									<i class="fa fa-users"></i>Manage Vendors
								</a>
							</li>
							<li class="{{ (request()->is('admin/vendor_store') or request()->is('admin/vendor_store/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_store')}}" class="waves-effect">
									<i class="fa fa-shopping-bag"></i>Manage Vendor Stores
								</a>
							</li>
							@php /* @endphp
							<li class="{{ (request()->is('admin/vendor_configuration') or request()->is('admin/vendor_configuration/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_configuration')}}" class="waves-effect">
									<i class="fa fa-cog"></i>Manage Configurations
								</a>
							</li>
							@php */ @endphp
							<li class="{{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_coupons')}}" class="waves-effect">
									<i class="fa fa-tags"></i>Manage Coupons
								</a>
							</li>
							<li class="{{ (request()->is('admin/vendor_coupons_used') or request()->is('admin/vendor_coupons_used/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_coupons_used')}}" class="waves-effect">
									<i class="fa fa-tags"></i>Manage Used Coupons
								</a>
							</li>
							<li class="{{ (request()->is('admin/vendor_payment') or request()->is('admin/vendor_payment/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_payment')}}" class="waves-effect">
									<i class="fa fa-usd"></i>Manage Accounting
								</a>
							</li>
						</ul>
					</li>
					<li class="{{ (request()->is('admin/products/*') or request()->is('admin/brand/*') or request()->is('admin/categories/*') or request()->is('admin/attributes/*') or request()->is('admin/discount_offers/*') or request()->is('admin/product_reviews/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-product-hunt"></i><span>Manage Product Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/products') or (request()->is('admin/products/*') && !request()->is('admin/products/inventory') && !request()->is('admin/products/generate-barcodes'))) ? 'active' : '' }}">
								<a href="{{url('admin/products')}}" class="waves-effect">
									<i class="fa fa-product-hunt"></i>Manage Products
								</a>
							</li>
							<li class="{{ (request()->is('admin/products/inventory')) ? 'active' : '' }}">
								<a href="{{url('admin/products/inventory')}}" class="waves-effect">
									<i class="fa fa-list-alt"></i>Manage Product Inventory
								</a>
							</li>
							<li class="{{ (request()->is('admin/products/generate-barcodes')) ? 'active' : '' }}">
								<a href="{{url('admin/products/generate-barcodes')}}" class="waves-effect">
									<i class="fa fa-barcode"></i>Manage Product Barcodes
								</a>
							</li>
							<li class="{{ (request()->is('admin/product_reviews') or request()->is('admin/product_reviews/*')) ? 'active' : '' }}">
								<a href="{{url('admin/product_reviews')}}" class="waves-effect">
									<i class="fa fa-star"></i>Manage Reviews
								</a>
							</li>
							<li class="{{ request()->is('admin/categories/*') ? 'active' : '' }}">
								<a href="{{url('admin/categories')}}" class="waves-effect">
									<i class="fa fa-list"></i>Manage Categories
								</a>
							</li>
							<li class="{{ request()->is('admin/attributes/*') ? 'active' : '' }}">
								<a href="{{url('admin/attributes')}}" class="waves-effect">
									<i class="fa fa-list"></i>Manage Attributes
								</a>
							</li>
							<li class="{{ (request()->is('admin/brand') or request()->is('admin/brand/*')) ? 'active' : '' }}">
								<a href="{{url('admin/brand')}}" class="waves-effect">
									<i class="fa fa-tags"></i>Manage Brands
								</a>
							</li>
							<!-- <li class="{{ (request()->is('admin/discount_offers') or request()->is('admin/discount_offers/*')) ? 'active' : '' }}">
								<a href="{{url('admin/discount_offers')}}" class="waves-effect">
									<i class="fa fa-percent"></i>Manage Discount Offers
								</a>
							</li> -->
						</ul>
					</li>
					<li class="{{ request()->is('admin/customer') || request()->is('admin/customer/*') || request()->is('admin/customer_feedback') || request()->is('admin/customer_feedback/*') || request()->is('admin/customer_reviews') || request()->is('admin/customer_reviews/*') || request()->is('admin/customer_reward_points') || request()->is('admin/customer_reward_points/*') || request()->is('admin/customer_used_reward_points') || request()->is('admin/customer_used_reward_points/*') || request()->is('admin/suggested-place') || request()->is('admin/suggested-place/*')? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-users"></i><span>Manage Customers Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/customer') or request()->is('admin/customer/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer')}}" class="waves-effect">
									<i class="fa fa-users"></i>Manage Customers
								</a>
							</li>
							<li class="{{ (request()->is('admin/customer_feedback') or request()->is('admin/customer_feedback/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer_feedback')}}" class="waves-effect">
									<i class="fa fa-comments-o"></i>Manage Feedbacks
								</a>
							</li>
							<li class="{{ (request()->is('admin/customer_reviews') or request()->is('admin/customer_reviews/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer_reviews')}}" class="waves-effect">
									<i class="fa fa-star"></i>Manage Reviews
								</a>
							</li>
							<li class="{{ (request()->is('admin/customer_reward_points') or request()->is('admin/customer_reward_points/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer_reward_points')}}" class="waves-effect">
									<i class="fa fa-trophy"></i>Manage Reward Points
								</a>
							</li>
							<li class="{{ (request()->is('admin/customer_used_reward_points') or request()->is('admin/customer_used_reward_points/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer_used_reward_points')}}" class="waves-effect">
									<i class="fa fa-trophy"></i>Manage Used Reward Points
								</a>
							</li>
							<li class="{{ (request()->is('admin/suggested-place') or request()->is('admin/suggested-place/*')) ? 'active' : '' }}">
								<a href="{{url('admin/suggested-place')}}" class="waves-effect">
									<i class="fa fa-lightbulb-o"></i>Manage Suggested Place
								</a>
							</li>
						</ul>
					</li>
					<li class="{{ (request()->is('admin/orders/*') or request()->is('admin/order_return/*') or request()->is('admin/cancelled_orders/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-shopping-cart"></i><span>Manage Orders Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/orders') or request()->is('admin/orders/*')) ? 'active' : '' }}">
								<a href="{{url('admin/orders')}}" class="waves-effect">
									<i class="fa fa-shopping-cart"></i>Manage Orders
								</a>
							</li>
							<li class="{{ (request()->is('admin/order_return') or request()->is('admin/order_return/*')) ? 'active' : '' }}">
								<a href="{{url('admin/order_return')}}" class="waves-effect">
									<i class="fa fa-shopping-cart"></i>Manage Return Orders
								</a>
							</li>
							<li class="{{ (request()->is('admin/cancelled_orders') or request()->is('admin/cancelled_orders/*')) ? 'active' : '' }}">
								<a href="{{url('admin/cancelled_orders')}}" class="waves-effect">
									<i class="fa fa-shopping-cart"></i>Manage Cancel Orders
								</a>
							</li>
						</ul>
					</li>
					<!-- <li class="{{ (request()->is('admin/notifications') or request()->is('admin/notifications/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="fa fa-bell"></i><span>Manage Notifications</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ (request()->is('admin/notifications')) ? 'active' : '' }}">
								<a href="{{url('admin/notifications')}}" class="waves-effect">
									<i class="fa fa-bell-o"></i>Notification List
								</a>
							</li>
							<li class="{{ (request()->is('admin/notifications/*')) ? 'active' : '' }}">
								<a href="{{url('admin/notifications/create')}}" class="waves-effect">
									<i class="fa fa-bell-o"></i>Send Notification
								</a>
							</li>
						</ul>
					</li> -->
					<li class="{{ (request()->is('admin/support_ticket') or request()->is('admin/support_ticket/*')) ? 'active' : '' }}">
						<a href="{{url('admin/support_ticket')}}" class="waves-effect">
							<i class="fa fa-ticket"></i><span>Manage Ticket Issues</span>
						</a>
					</li>
					<li class="{{ (request()->is('admin/settings')) ? 'active' : '' }}">
						<a href="{{url('admin/settings/')}}" class="waves-effect">
							<i class="fa fa-cog"></i><span>Manage Settings</span>
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
										@php $image = asset('public/images/'.Auth::user()->image); @endphp
										<img class="img-circle" src="{{$image}}">
									@else
										<img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar">
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
													@php $image = asset('public/images/'.Auth::user()->image); @endphp
													<img class="align-self-start mr-3" src="{{$image}}">
												@else
													<img src="https://via.placeholder.com/110x110" class="align-self-start mr-3" alt="user avatar">
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
									<a href="{{ url('/admin/profile') }}">
										<i class="icon-user"></i> My Profile
									</a>
								</li>
								<!--<li class="dropdown-divider"></li>
								<li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li> -->
								<li class="dropdown-divider"></li>
								<li class="dropdown-item">
									<a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<i class="icon-power"></i> Logout
									</a>
									<form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
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
							&copy; 2023 Nature Checkout
						</div>
					</div>
				</footer>
			<!-- End container-fluid-->
			</div>
		</div>
		<!--End content-wrapper-->
		<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	</body>
</html>
