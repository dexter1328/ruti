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
		<meta property="og:title" content="{{ config('app.name', 'Nature Checkout') }}" />
		<meta property="og:description" content="We provide convenient and expeditious service to all users (merchants and consumers) in areas of consumer spending. Our service is to improve merchant - customer relations while offering positive contribution to the overall economy." />
		<meta property="og:image" content="{{ asset('images/logo-icon.png') }}" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="https://naturecheckout.com/" />
		<meta property="fb:app_id" content="482623692719207" />

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
