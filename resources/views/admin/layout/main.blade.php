<!DOCTYPE html>
<html lang="en">
	<head>
		<style type="text/css">
			.modal-dialog{
			    overflow-y: initial !important
			}

			div#myModal {
			    width: 50%;
			    margin: auto;
			}
		</style>
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
		<link href="{{ asset('public/css/wickedpicker.min.css') }}" rel="stylesheet"/>
		<style type="text/css">
			.fa.fa-angle-down{
			float: right;
			}

			.fa.fa-angle-up{
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
        window.laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
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
		<!--<script src="{{ asset('js/index.js') }}"></script>-->

		<!-- Scripts -->
		<!--<script src="/js/app.js"></script>-->
		<!--<script src="{{ asset('js/app.js') }}"></script>-->
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
						<img src="{{ asset('public/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
						<span class="logo-mini"><img src="{{ asset('public/images/ez-icon-white.png') }}" class="logo-icon" alt="logo icon"></span>
					</a>
				</div>
				<ul class="sidebar-menu do-nicescrol">
					<li>
						<a href="{{url('admin/home')}}" class="waves-effect">
							<i class="icon-home icons"></i><span>Dashboard</span>
						</a>
					</li>
					 @if(has_permission(Auth::user()->role_id,'admins','read') || has_permission(Auth::user()->role_id,'admin_roles','read') )
					<li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*') or request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-user icons"></i><span>Manage Admins</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'admins','read'))
							<li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*')) ? 'active' : '' }}">
								<a href="{{url('admin/admins')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>All Admins
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'admin_roles','read'))
							<li class="{{ (request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active' : '' }}">
								<a href="{{url('admin/admin_roles')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Roles
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
					 @if(has_permission(Auth::user()->role_id,'pages','read') || has_permission(Auth::user()->role_id,'menus','read') || has_permission(Auth::user()->role_id,'banners','read') || has_permission(Auth::user()->role_id,'galleries','read') || has_permission(Auth::user()->role_id,'newsletters','read') || has_permission(Auth::user()->role_id,'push_notifications','read') || has_permission(Auth::user()->role_id,'user_notification','read') )
					<li class="{{ (request()->is('admin/pages/*') or request()->is('admin/menus/*') or request()->is('admin/banners/*') or request()->is('admin/galleries/*') or request()->is('admin/newsletters/*') or request()->is('admin/push_notifications/*') or request()->is('admin/user_notification')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-globe icons"></i><span>Manage Front Website</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'menus','read'))
							<li class="{{ (request()->is('admin/menus') or request()->is('admin/menus/*')) ? 'active' : '' }}">
								<a href="{{url('admin/menus')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Menus
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'pages','read'))
							<li class="{{ (request()->is('admin/pages') or request()->is('admin/pages/*')) ? 'active' : '' }}">
								<a href="{{url('admin/pages')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Pages
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'banners','read'))
							<li class="{{ (request()->is('admin/banners') or request()->is('admin/banners/*')) ? 'active' : '' }}">
								<a href="{{url('admin/banners')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Banners
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'galleries','read'))
							<li class="{{ (request()->is('admin/galleries') or request()->is('admin/galleries/*')) ? 'active' : '' }}">
								<a href="{{url('admin/galleries')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Galleries
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'newsletters','read'))
							<li class="{{ (request()->is('admin/newsletters') or request()->is('admin/newsletters/*')) ? 'active' : '' }}">
								<a href="{{url('admin/newsletters')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Newsletters
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'push_notifications','read'))
							<li class="{{ (request()->is('admin/push_notifications') or request()->is('admin/push_notifications/*')) ? 'active' : '' }}">
								<a href="{{url('admin/push_notifications')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Push Notifications
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'user_notification','read'))
							<li class="{{ (request()->is('admin/user_notification') or request()->is('admin/user_notification/*')) ? 'active' : '' }}">
								<a href="{{url('admin/user_notification')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage User Notification
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif

					@if(has_permission(Auth::user()->role_id,'reward_points','read'))
					<li class="{{ (request()->is('admin/reward_points') or request()->is('admin/reward_points/*')) ? 'active' : '' }}">
						<a href="{{url('admin/reward_points')}}" class="waves-effect">
							<i class="icon-badge icons"></i><span>Manage Reward Points</span>
						</a>
					</li>
					@endif

					@if(has_permission(Auth::user()->role_id,'membership','read'))
					<li class="{{ (request()->is('admin/membership') or request()->is('admin/membership/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-user-follow icons"></i><span>Manage Memberships</span><i class="fa fa-angle-down"></i>
						</a>
						<ul  class="sidebar-submenu">
							<li class="{{ (request()->is('admin/membership/list/customer')) ? 'active' : '' }}">
								<a href="{{url('admin/membership/list/customer')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Customer Membership
								</a>
							</li>
							<li class="{{ (request()->is('admin/membership/list/vendor')) ? 'active' : '' }}">
								<a href="{{url('admin/membership/list/vendor')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Vendor Membership
								</a>
							</li>
							<li class="{{ (request()->is('admin/membership/list/supplier')) ? 'active' : '' }}">
								<a href="{{url('admin/membership/list/supplier')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Supplier Membership
								</a>
							</li>
							<li class="{{ (request()->is('admin/membership/list/supplier_ruti_fullfill')) ? 'active' : '' }}">
								<a href="{{url('admin/membership/list/supplier_ruti_fullfill')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Supplier Ruti_fullfill Membership
								</a>
							</li>
							<li class="{{ (request()->is('admin/membership-coupons')) ? 'active' : '' }}">
								<a href="{{url('admin/membership-coupons')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Membership Coupons
								</a>
							</li>
						</ul>
					</li>
					@endif

					@if(has_permission(Auth::user()->role_id,'checklist','read'))
					<li class="{{ (request()->is('admin/checklist') or request()->is('admin/checklist/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-list icons"></i><span>Manage Checklist</span><i class="fa fa-angle-down"></i>
						</a>
						<ul  class="sidebar-submenu">
							<li class="{{ (request()->is('admin/checklist/customer')) ? 'active' : '' }}">
								<a href="{{url('admin/checklist/customer')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Customer Checklist
								</a>
							</li>
							<li class="{{ (request()->is('admin/checklist/vendor')) ? 'active' : '' }}">
								<a href="{{url('admin/checklist/vendor')}}">
									<i class="zmdi zmdi-dot-circle-alt"></i>Vendor Checklist
								</a>
							</li>
						</ul>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'vendor','read') || has_permission(Auth::user()->role_id,'vendor_store','read') || has_permission(Auth::user()->role_id,'vendor_configuration','read') || has_permission(Auth::user()->role_id,'vendor_coupons','read') || has_permission(Auth::user()->role_id,'vendor_coupons_used','read') )
					<li class="{{ (request()->is('admin/vendor/*') or request()->is('admin/vendor_store/*') or request()->is('admin/vendor_configuration/*') or request()->is('admin/vendor_coupons/*') or request()->is('admin/vendor_coupons_used/*') or request()->is('admin/vendor_unverified_coupons/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-people icons"></i><span>Manage Vendors Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'vendor','read'))
							<li class="{{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Vendors
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'vendor_store','read'))
							<li class="{{ (request()->is('admin/vendor_store') or request()->is('admin/vendor_store/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_store')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Vendor Stores
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
							<li class="{{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_coupons')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Verified Coupons
								</a>
							</li>
							<li class="{{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_coupons/unverified')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Unverified Coupons
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
					</li>
					@endif
                    {{-- supplier --}}
                    @if(has_permission(Auth::user()->role_id,'vendor','read') || has_permission(Auth::user()->role_id,'vendor_store','read') || has_permission(Auth::user()->role_id,'vendor_configuration','read') || has_permission(Auth::user()->role_id,'vendor_coupons','read') || has_permission(Auth::user()->role_id,'vendor_coupons_used','read') )
                        <li class="{{ (request()->is('admin/supplier/*') or request()->is('admin/supplier_store/*') or request()->is('admin/supplier_configuration/*') or request()->is('admin/supplier_coupons/*') or request()->is('admin/supplier_coupons_used/*') or request()->is('admin/supplier_unverified_coupons/*')) ? 'active menu-open' : '' }}">
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="icon-people icons"></i><span>Manage Suppliers Details</span><i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                @if(has_permission(Auth::user()->role_id,'vendor','read'))
                                    <li class="{{ (request()->is('admin/supplier') or request()->is('admin/supplier/*')) ? 'active' : '' }}">
                                        <a href="{{url('admin/supplier')}}" class="waves-effect">
                                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Suppliers
                                        </a>
                                    </li>
                                @endif
                                @if(has_permission(Auth::user()->role_id,'vendor','read'))
                                    <li class="{{ (request()->is('admin/supplier_category') or request()->is('admin/supplier_category/*')) ? 'active' : '' }}">
                                        <a href="{{url('admin/supplier_category')}}" class="waves-effect">
                                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Categories
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
					@if(has_permission(Auth::user()->role_id,'products','read') || has_permission(Auth::user()->role_id,'brand','read') || has_permission(Auth::user()->role_id,'categories','read') || has_permission(Auth::user()->role_id,'attributes','read') || has_permission(Auth::user()->role_id,'discount_offers','read')|| has_permission(Auth::user()->role_id,'product_reviews','read') )
					<li class="{{ (request()->is('admin/products/*') or request()->is('admin/brand/*') or request()->is('admin/categories/*') or request()->is('admin/attributes/*') or request()->is('admin/discount_offers/*') or request()->is('admin/product_reviews/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-present icons"></i><span>Manage Product Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'products','read'))
							<li class="{{ (request()->is('admin/products') or (request()->is('admin/products/*') && !request()->is('admin/products/inventory') && !request()->is('admin/products/generate-barcodes'))) ? 'active' : '' }}">
								<a href="{{url('admin/products')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Products
								</a>
							</li>

							<li class="{{ (request()->is('admin/products/inventory')) ? 'active' : '' }}">
								<a href="{{url('admin/products/inventory')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Inventory
								</a>
							</li>
							<li class="{{ (request()->is('admin/products/generate-barcodes')) ? 'active' : '' }}">
								<a href="{{url('admin/products/generate-barcodes')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Barcodes
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'product_reviews','read'))
							<li class="{{ (request()->is('admin/product_reviews') or request()->is('admin/product_reviews/*')) ? 'active' : '' }}">
								<a href="{{url('admin/product_reviews')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Reviews
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'categories','read'))
							<li class="{{ request()->is('admin/categories/*') ? 'active' : '' }}">
								<a href="{{url('admin/categories')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Categories
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'attributes','read'))
							<li class="{{ request()->is('admin/attributes/*') ? 'active' : '' }}">
								<a href="{{url('admin/attributes')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Attributes
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'brand','read'))
							<li class="{{ (request()->is('admin/brand') or request()->is('admin/brand/*')) ? 'active' : '' }}">
								<a href="{{url('admin/brand')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Brands
								</a>
							</li>
							@endif
							<!-- <li class="{{ (request()->is('admin/discount_offers') or request()->is('admin/discount_offers/*')) ? 'active' : '' }}">
								<a href="{{url('admin/discount_offers')}}" class="waves-effect">
									<i class="fa fa-percent"></i>Manage Discount Offers
								</a>
							</li> -->
						</ul>
					</li>
					@endif
                    @if(has_permission(Auth::user()->role_id,'products','read') || has_permission(Auth::user()->role_id,'brand','read') || has_permission(Auth::user()->role_id,'categories','read') || has_permission(Auth::user()->role_id,'attributes','read') || has_permission(Auth::user()->role_id,'discount_offers','read')|| has_permission(Auth::user()->role_id,'product_reviews','read') )
					<li class="{{ (request()->is('admin/w2b_products/*')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-present icons"></i><span>Wholesale2b</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'products','read'))
							<li class="{{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
								<a href="{{url('admin/w2b_products')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Products List
								</a>
							</li>



							@endif
                            @if(has_permission(Auth::user()->role_id,'products','read'))
							<li class="{{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
								<a href="{{url('admin/w2b_products/orders')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
								</a>
							</li>
							@endif

						</ul>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'customer_incentive','read'))
					<li class="{{ request()->is('admin/customer_incentive/*') ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-people icons"></i><span>Manage Incentives</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							<li class="{{ request()->is('admin/customer_incentive/qualifiers') ? 'active' : '' }}">
								<a href="{{url('admin/customer_incentive/qualifiers')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Qualifiers
								</a>
							</li>
							<li class="{{ request()->is('admin/customer_incentive/winners') ? 'active' : '' }}">
								<a href="{{url('admin/customer_incentive/winners')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Winners
								</a>
							</li>
						</ul>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'customer','read') || has_permission(Auth::user()->role_id,'suggested-place','read') )
					<li class="{{ request()->is('admin/customer') || request()->is('admin/customer/*') || request()->is('admin/customer_feedback') || request()->is('admin/customer_feedback/*') || request()->is('admin/customer_reviews') || request()->is('admin/customer_reviews/*') || request()->is('admin/customer_reward_points') || request()->is('admin/customer_reward_points/*') || request()->is('admin/customer_used_reward_points') || request()->is('admin/customer_used_reward_points/*') || request()->is('admin/suggested-place') || request()->is('admin/suggested-place/*')? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-people icons"></i><span>Manage Customers Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'customer','read'))
							<li class="{{ (request()->is('admin/customer') or request()->is('admin/customer/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Customers
								</a>
							</li>
							@endif

							@if(has_permission(Auth::user()->role_id,'suggested-place','read'))
							<li class="{{ (request()->is('admin/suggested-place') or request()->is('admin/suggested-place/*')) ? 'active' : '' }}">
								<a href="{{url('admin/suggested-place')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Suggested Place
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'orders','read') || has_permission(Auth::user()->role_id,'order_return','read') || has_permission(Auth::user()->role_id,'cancelled_orders','read') || has_permission(Auth::user()->role_id,'order_reason','read') )
					<li class="{{ (request()->is('admin/orders/*') or request()->is('admin/order_return/*') or request()->is('admin/cancelled_orders/*') or request()->is('admin/order_reason/*') or request()->is('admin/order/return/request') or request()->is('admin/order/inshop_order') or request()->is('admin/order/pickup_order')) ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-basket-loaded icons"></i><span>Manage Orders Details</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'orders','read'))
							<li class="{{ (request()->is('admin/orders') or request()->is('admin/orders/*')) ? 'active' : '' }}">
								<a href="{{url('admin/orders')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
								</a>
							</li>
							<li class="{{ (request()->is('admin/order/inshop_order')) ? 'active' : '' }}">
								<a href="{{url('admin/order/inshop_order')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage In Store Order
								</a>
							</li>
							<li class="{{ (request()->is('admin/order/pickup_order')) ? 'active' : '' }}">
								<a href="{{url('admin/order/pickup_order')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Pickup Order
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'order_return','read'))
							<li class="{{ (request()->is('admin/order/return/request')) ? 'active' : '' }}">
								<a href="{{url('admin/order/return/request')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Request Orders
								</a>
							</li>
							<li class="{{ (request()->is('admin/order_return') or request()->is('admin/order_return/*')) ? 'active' : '' }}">
								<a href="{{url('admin/order_return')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Orders
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'cancelled_orders','read'))
							<li class="{{ (request()->is('admin/cancelled_orders') or request()->is('admin/cancelled_orders/*')) ? 'active' : '' }}">
								<a href="{{url('admin/cancelled_orders')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Cancel Orders
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'order_reason','read'))
							<li class="{{ (request()->is('admin/order_reason') or request()->is('admin/order_reason/*')) ? 'active' : '' }}">
								<a href="{{url('admin/order_reason')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Order Reasons
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif

					@if(has_permission(Auth::user()->role_id,'support_ticket','read'))
					<li class="{{ (request()->is('admin/support_ticket') or request()->is('admin/support_ticket/*')) ? 'active' : '' }}">
						<a href="{{url('admin/support_ticket')}}" class="waves-effect">
							<i class="icon-support icons"></i><span>Manage Ticket Issues</span>
						</a>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'settings','read'))
					<li class="{{ (request()->is('admin/settings')) ? 'active' : '' }}">
						<a href="{{url('admin/settings/')}}" class="waves-effect">
							<i class="icon-settings icons"></i><span>Manage Settings</span>
						</a>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'login_history','read'))
					<li class="{{ (request()->is('admin/login_history')) ? 'active' : '' }}">
						<a href="{{ url('admin/login_history') }}" class="waves-effect">
							<i class="icon-clock icons"></i><span>Manage Login Activities</span>
						</a>
					</li>
					<li class="{{ (request()->is('admin/import_export_logs')) ? 'active' : '' }}">
						<a href="{{ url('admin/import_export_logs') }}" class="waves-effect">
							<i class="icon-clock icons"></i><span>Manage Import/Export Logs</span>
						</a>
					</li>
					@endif
					@if(has_permission(Auth::user()->role_id,'customer_transaction','read') || has_permission(Auth::user()->role_id,'vendor_transaction','read') )
					<li class="{{ request()->is('admin/customer_transaction') || request()->is('admin/vendor_transaction') ? 'active menu-open' : '' }}">
						<a href="javaScript:void();" class="waves-effect">
							<i class="icon-people icons"></i><span>Manage Transactions</span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="sidebar-submenu">
							@if(has_permission(Auth::user()->role_id,'customer_transaction','read'))
							<li class="{{ (request()->is('admin/customer_transaction') or request()->is('admin/customer_transaction/*')) ? 'active' : '' }}">
								<a href="{{url('admin/customer_transaction')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Customer Transactions
								</a>
							</li>
							@endif
							@if(has_permission(Auth::user()->role_id,'vendor_transaction','read'))
							<li class="{{ (request()->is('admin/vendor_transaction') or request()->is('admin/vendor_transaction/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_transaction')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Vendor Transactions
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
                    @if(has_permission(Auth::user()->role_id,'email_template','read'))
                        <li class="{{ (request()->is('admin/email_template')) ? 'active' : '' }}">
                            <a href="{{url('admin/email_template/')}}" class="waves-effect">
                                <i class="zmdi zmdi-email"></i> <span>Manage Email Templates</span>
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
					</ul>
					<ul class="navbar-nav align-items-center right-nav-link">
						<li class="nav-item">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#" style="font-size: 14px;font-weight: 500;">
								<span class="user-profile">
									@if(Auth::user()->image)
										@php $image = asset('public/images/'.Auth::user()->image); @endphp
										<img class="img-circle" src="{{$image}}">
									@else
										<img src="{{asset('public/images/User-Avatar.png')}}" class="img-circle" alt="user avatar">
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
													@php $image = asset('images/'.Auth::user()->image); @endphp
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
							RUTI Self Checkout &copy; 2019-2024. All Rights Reserved
						</div>
					</div>
				</footer>
			<!-- End container-fluid-->
			</div>
		</div>
		<!--End content-wrapper-->
		<div class="modal fade" id="inActivityModal" role="dialog">
		    <div class="modal-dialog">
		        <!-- Modal content-->
		        <div class="modal-content schedule-booking" style="width: 56%;margin-left: 303px;">
		            <div class="modal-header" style="margin-left:15px;">
		                <div class="row">
		                    <div class="col-sm-6"><h5 class="modal-title">Orders</h5></div>
		                    <div class="col-sm-6"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
		                </div>
		            </div>
		            <div class="modal-body" id="assign-modal">
		              	<h5>Session has been expired due to inactivity</h5>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		            </div>
		        </div>
		    </div>
		</div>
		<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		<script type="text/javascript">

			/*var inactivityCountdown = "{{config('session.lifetime')}}";
			console.log(inactivityCountdown);*/
			/*var inactivityCountdown = 1;

			intervalid = window.setInterval(function Redirect()
			{
				inactivityCountdown--;
				if (inactivityCountdown<1) {
					$.ajax({
						url: "{{ route('session-check') }}",
						type: "GET",
						headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						dataType: "json",
						success: function(data) {
							console.log(data);
							if(data.logout == 'yes'){
								$("#inActivityModal").modal('show');

							}
						}
					});
				}
			});


			// end
			$("#inActivityModal").on('hidden.bs.modal', function(){
			    //window.location = "{{url('admin/login')}}";
			    $("#logout-form").submit();
			});*/
		</script>
        @yield('scripts1')
	</body>
</html>
