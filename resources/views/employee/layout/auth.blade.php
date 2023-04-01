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
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Custom Style-->
    <link href="{{ asset('css/app-style.css') }}" rel="stylesheet"/>

    <!-- Styles -->
    <!--<link href="/css/app.css" rel="stylesheet">-->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
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

        <div class="loader-wrapper">
            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="card card-authentication1 mx-auto my-5">

            @yield('content')

        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- sidebar-menu js -->
    <script src="{{ asset('js/sidebar-menu.js') }}"></script>

    <!-- Custom scripts -->
    <script src="{{ asset('js/app-script.js') }}"></script>

    <!-- Scripts -->
    <!--<script src="/js/app.js"></script>-->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
    <script>
    $( document ).ready(function() {
        $("#resend_otp").click(function(){
            var email = $("#email").val();
            $.ajax({
                type: "post",
                data:{email:email},
                url: "{{ url('/employee/resend_otp_mail') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    $("#resend_success").html(data);
                    $(".error").html('');
                }
            });
        });
    });
    </script>
</body>
</html>
