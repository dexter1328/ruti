@extends('front_end.layout')
@section('content')


<!--breadcrumbs area start-->
<div class="mt-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                   <h3>My Account</h3>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
                {{-- <div class="search-container">
                    <input type="text" class='search_bar' placeholder="Search...">
                    <div class="dropdown">
                        <button class="dropbtn">Filter</button>
                        <div class="dropdown-content-new">
                            <label class='border-top border-bottom'>Filter by Order Type</label>
                            <label><input type="radio" name="filter-option" value="option2">Orders</label>
                            <label><input type="radio" name="filter-option" value="option1">Not Yet Shipped</label>
                            <label><input type="radio" name="filter-option" value="option3">Digital Orders</label>
                            <label><input type="radio" name="filter-option" value="option4">Local Orders</label>
                            <label><input type="radio" name="filter-option" value="option4">Cancelled Orders</label>
                            <label class='border-top border-bottom'>Filter by Order Date</label>
                            <label><input type="radio" name="filter-option" value="option2">Last 30 days</label>
                            <label><input type="radio" name="filter-option" value="option1">Last 3 months</label>
                            <label><input type="radio" name="filter-option" value="option3">2023</label>
                            <label><input type="radio" name="filter-option" value="option4">2022</label>
                            <label><input type="radio" name="filter-option" value="option4">2019</label>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--xyz-->


<!-- my account start  -->
<section class="main_content_area">
    <div class="container">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list" id="nav-tab2">
                            <li><a href="#dashboard" data-toggle="tab" class="nav-link ">Dashboard</a></li>
                            <li> <a href="#profile" data-toggle="tab" class="nav-link">Profile</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link active">Orders</a></li>
                            <li> <a href="#wallet" data-toggle="tab" class="nav-link">Wallet</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">


                            @include('front_end.user_dashboard')
                            @include('front_end.user-profile')
                            @include('front_end.user_orders')
                            @include('front_end.user_wallet')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->


@endsection

@section('scriptss')
    <script>
        $(function() {
        $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
    input.attr("type", "text");
} else {
    input.attr("type", "password");
}
});

$('#password, #password_confirmation').on('keyup', function () {
if ($('#password').val() == $('#password_confirmation').val()) {
    $('.confirm-check').removeClass('fa-close');
    $('.confirm-check').addClass('fa-check').css('color', 'green');
} else {
    $('.confirm-check').removeClass('fa-check');
    $('.confirm-check').addClass('fa-close').css('color', 'red');
}
});
});
    </script>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>
    <script>
        $(document).ready(function () {
            $('#nav-tab2 a[href="#reviews"]').tab('show')
        });
    </script>

<script type="text/javascript">

    $("document").ready(function(){
        setTimeout(function() {
        $('.alert-success').fadeOut('fast');
        }, 15000);

    });

</script>
<script>
    $(document).ready(function(){
      $("#orderInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".gboo").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script>

    <script>
        function orderFilter(filter) {
            console.log(filter)
            $.ajax({

           url: "{{ url('/user-account') }}/"+filter,

            }).done(function(res) {
            console.log(res)
            location.reload();
            });
            }

    </script>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

    $(function() {

        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                             'input[type=text]', 'input[type=file]',
                             'textarea'].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
            $errorMessage.addClass('d-none');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('d-none');
                e.preventDefault();
              }
            });

            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }

        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('d-none')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
    </script>
@endsection
