@extends('supplier.layout.main')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->get('error'))
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-message">
			<span><strong>Error!</strong> {{ session()->get('error') }}</span>
		</div>
	</div>
@endif
@if(session()->get('success'))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success') }}</span>
		</div>
	</div>
@endif
<div class="card">
    <div class="card-body">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">You are purchasing <span class="text-danger">{{$plan->name}}</span>  plan</h5><br>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error" class="text-danger"></div>
                    <div id="success" class="text-success"></div>
                    <input type="radio" name="cardSelection" value="cardList" checked="checked"> Card List
                    <input type="radio" name="cardSelection" value="addCard"> Add New Card
                    <div id="cardListDiv">
                        <input type="hidden" id="card_count" name="card_count" value="{{ count($cards) }}">
                        <form action="{{route('supplier.create-subscription')}}" method="post">
                            @csrf

                            <input type="hidden" name="membership_id" value="{{$plan->id}}">
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Defualt</th>
                                    <th>Card Detail</th>
                                    <th>Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody id="cardListBody">
                                @if (!empty($cards))
                                    @foreach ($cards as $card)
                                        <tr>
                                            <td align="center">
                                                <input type="radio" name="stripe_card_id" value="{{ $card['id'] }}" required>
                                            </td>
                                            <td>
                                                {{ $card['brand'] }} ending in {{ $card['last4'] }}
                                            </td>
                                            <td align="right">
                                                {{ sprintf('%02d', $card['exp_month']) }}/{{ $card['exp_year'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No Cards Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <input type="radio"  name="stripe_price_id" value="{{$plan->monthMembershipItem->stripe_price_id}}" checked> : ${{$plan->monthMembershipItem->price}} / month <br>
                            <input type="radio"  name="stripe_price_id" value="{{$plan->yearMembershipItem->stripe_price_id}}"> : ${{$plan->yearMembershipItem->price}} / year
                        </div>
                            <button type="submit" class="btn btn-primary mt-2 px-5" >Subscribe</button>
                        </form>

                        <span id="in_progress" style="display: none;">
                            Processing...
                            <br>Please do not close or refresh the tab.
                        </span>
                    </div>
                    <div id="addCardDiv" style="display: none;">
                        <form method="post">
                            <div class="form-group">
                                <label for="card-number">Card Number<span class="text-danger">*</span></label>
                                <input type="text" id="card-number" name="card-number" class="form-control" required>
                            </div>
                            <div class="form-row">
                                <div class="col-md-9 mb-3">
                                    <label>Expiry Month / Year<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="month" id="month" class="form-control" required>
                                            <option value=""> --Select--</option>
                                            <?php for ($i=1; $i<=12; $i++) {
                                                $month = str_pad($i, 2, "0", STR_PAD_LEFT);?>
                                                <option value="<?php echo $month; ?>"><?php echo $month ?></option>
                                            <?php } ?>
                                        </select>
                                        <select name="year" id="year" class="form-control" required>
                                            <option value=""> --Select--</option>
                                            <?php $start_year = date('Y'); $end_year = date('Y') + 20;
                                            for ($i=$start_year; $i<=$end_year; $i++) { ?>
                                                <option value="<?php echo substr($i, 2); ?>"><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cvc">CVC<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cvc" name="cvc" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary px-5" id="addCardBtn" onClick="addCard(event);">Add Card</button>
                                <span id="processing" style="display: none;">Processing...</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
</div>
<div class="modal fade" id="thnksModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 id="thnksMsg" class="text-success" style="margin: 25px;"></h3>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    var setup_fee_required = '';
    var activeFrmID = '';
    var coupon_id = '';
    var calculate_discount = false;
    var subscriptionData = [];
    var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    function selectPlan(code) {
        var store = $("#store").val();
        if (store == '') {
            $("#store").focus();
        } else {
            activeFrmID = code + '_form';
            $("#" + activeFrmID).append("<input type='hidden' name='store_id' value='" + store + "' />");
            $('#cardModal').modal('show');
        }
    }

    function cardValidation() {

        var valid = true;
        var cardNumber = $('#card-number').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var cvc = $('#cvc').val();

        if (cardNumber.trim() == "") {
            valid = false;
        }

        if (month.trim() == "") {
            valid = false;
        }
        if (year.trim() == "") {
            valid = false;
        }
        if (cvc.trim() == "") {
            valid = false;
        }

        if (valid == false) {
            $("#error").html("All Fields are required");
        }

        return valid;
    }

    //set your publishable key
    Stripe.setPublishableKey("{{ config('stripe.publishable_key') }}");

    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //enable the submit button
            $("#addCardBtn").show();
            $("#processing").css("display", "none");
            //display the errors on the form
            $("#error").html(response.error.message).show();
        } else {

            //get token id
            var token = response['id'];
            /*//insert the token into the form
            $("#"+activeFrmID).append("<input type='hidden' name='stripe_card_token' value='" + token + "' />");
            //submit form to the server
            $("#"+activeFrmID).submit();*/

            saveCard(token);
        }
    }

    function addCard(e) {

        e.preventDefault();
        $("#error").html("");
        $("#success").html("");
        var valid = cardValidation();

        if (valid == true) {
            $("#addCardBtn").hide();
            $("#processing").css("display", "inline-block");
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('#cvc').val(),
                exp_month: $('#month').val(),
                exp_year: $('#year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        }
    }

    function saveCard(token) {

        $.ajax({
            type: "POST",
            url: "{{ url('/supplier/save-supplier-card') }}/",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                stripeToken: token
            },
            dataType: "json",
            success: function(result) {
                // console.log(result);
                $("#addCardBtn").show();
                $("#processing").css("display", "none");
                if (result.status == 'error') {
                    $("#error").html(result.message);
                } else {
                    var card = result.data;
                    var exp_month = ('0' + card.exp_month).slice(-2);
                    $('input[type=radio][name=card]').prop('checked', false);
                    var card_is_check = '';
                    if ($('#card_count').val() == 0) {
                        card_is_check == 'checked';
                    }

                    var str = '';
                    str += '<tr>';
                    str += '<td align="center">';
                    str += '<input type="radio" name="card" value="' + card.id + '" ' + card_is_check + '>';
                    str += '</td>';
                    str += '<td>';
                    str += card.brand + ' ending in ' + card.last4;
                    str += '</td>';
                    str += '<td align="right">';
                    str += exp_month + '/' + card.exp_year;
                    str += '</td>';
                    str += '</tr>';
                    $('#success').html(result.message);
                    if ($('#card_count').val() > 0) {
                        $('#cardListBody').append(str);
                    } else {
                        $('#cardListBody').html(str);
                    }
                    $('input[type=radio][name=cardSelection][value=cardList]').prop('checked', true);
                    $('#cardListDiv').show();
                    $('#addCardDiv').hide();
                }
            }
        });
    }

    $(document).ready(function() {

        $('input[type=radio][name=options]').change(function() {

            getPlanByIntervalLicense();
        });

        $('input[type=radio][name=cardSelection]').change(function() {
            if (this.value == 'addCard') {
                $('#addCardDiv').show();
                $('#cardListDiv').hide();
            } else if (this.value == 'cardList') {
                $('#addCardDiv').hide();
                $('#cardListDiv').show();
            }
        });

        $('#subscriptionBtn').click(function() {

            var card_id = $("input[name='card']:checked").val();

            $('#subscriptionBtn').hide();
            $("#in_progress").show();

            if (setup_fee_required == 'no') {


                $("#" + activeFrmID).append("<input type='hidden' name='stripe_card_id' value='" +
                    card_id + "' />");

                // create subscription
                $.ajax({
                    type: "POST",
                    url: "{{ route('supplier.create-subscription') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $("#" + activeFrmID).serialize(),
                    dataType: "json",
                    success: function(result) {
                        // console.log(result);
                        $("#in_progress").hide();
                        $('#subscriptionBtn').show();
                        if (result.status == 'error') {
                            $("#error").html(result.message);
                        } else {
                            $("#error").html('');
                            $("#thnksMsg").html(result.message);
                            $("#cardModal").modal("hide");
                            $("#thnksModal").modal("show");
                        }
                    }
                });
            } else {

                var store_id = $("#store").val();
                if (store_id != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ url('supplier/one-time-setup-fee') }}/" + store_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            card_id: card_id
                        },
                        dataType: "json",
                        success: function(result) {
                            // console.log(result);
                            $("#in_progress").hide();
                            $('#subscriptionBtn').show();
                            if (result.status == 'error') {
                                $("#error").html(result.message);
                            } else {
                                $("#error").html('');
                                $("#thnksMsg").html(result.message);
                                $("#cardModal").modal("hide");
                                $("#thnksModal").modal("show");
                            }
                        }
                    });
                } else {
                    alert('Please select store.');
                }
            }
        });

        $('#extra_license').change(function() {
            getPlanByIntervalLicense();
        });

        $('#thnksModal').on('hidden.bs.modal', function() {
            //location.reload();
            window.location.href = "{{ url('/supplier/choose-plan') }}";
        })

        $('#store').change(function() {
            // var store_id = $(this).val();
            // checkSetUpFee(store_id);
            getSubscription();
        });

        $('#apply_promo_btn').click(function() {
            coupon_id = $('#promo_code_id').val();
            var promo_name = $('#promo_code_name').val();
            $('#promo_code').html('Coupon <label id="promo_code_lbl">"' + promo_name +
                '"</label> applied!');
            $('#apply_promo_btn').hide();
            $('#remove_promo_btn').show();
            addCouponDiscount();
        });

        $('#remove_promo_btn').click(function() {
            coupon_id = '';
            var promo_name = $('#promo_code_name').val();
            $('#promo_code').html('Coupon <label id="promo_code_lbl">"' + promo_name + '"</label>');
            $('#apply_promo_btn').show();
            $('#remove_promo_btn').hide();
            removeCouponDiscount();
        });
    });

    function getSubscription() {
        $("#error-text").html('');
        $("#error-row").hide();
        var store_id = $('#store').val();
        if (store_id != '') {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/supplier/get-subscription') }}/" + store_id,
                dataType: "json",
                success: function(result) {

                    setup_fee_required = result.is_setup_required;
                    if (result.is_setup_required == 'no') {

                        $("#btn-row").show();
                        $('#subscriptionBtn').html('Subscribe');
                        var current_subscription = result.current_subscription;
                        var pending_subscription = result.pending_subscription;


                        if ($.isEmptyObject(current_subscription)) {
                            $('#currentPlanAlert').hide();
                            $('#currentPlanMsg').html('');
                        } else {
                            var cancel_str = '';
                            if (current_subscription.is_cancelled == 'yes') {
                                cancel_str = 'Your plan is valid till ' + current_subscription.end_date;
                            }
                            var license_str = '';
                            if (current_subscription.extra_license != null) {
                                number_str = '';
                                if (current_subscription.extra_license == 1) {
                                    number_str = 'one';
                                } else if (current_subscription.extra_license == 2) {
                                    number_str = 'two';
                                }
                                license_str = ' with ' + number_str + ' extra license';
                            }
                            var str = "<strong>Current Plan: " + current_subscription.name + " ($" +
                                current_subscription.price + "/" + current_subscription.billing_period +
                                ")" + license_str + ". " + cancel_str + "</strong>";
                            $('#currentPlanAlert').show();
                            $('#currentPlanMsg').html(str);
                        }
                        if (!$.isEmptyObject(current_subscription) && current_subscription.is_cancelled ==
                            'yes') {

                            $("#error-text").html('You cancelled subscription plan for this store. ' +
                                cancel_str);
                            $("#error-row").show();
                            $("#btn-row").hide();
                        } else {

                            if ($.isEmptyObject(pending_subscription)) {

                                $('.btnSbscrtnFrm').each(function() {
                                    var membership_code = $(this).val();
                                    if ($.isEmptyObject(current_subscription)) {
                                        $(this).text('Choose Plan');
                                        $(this).attr('onclick', 'selectPlan("' + membership_code +
                                            '")');
                                    } else {
                                        $(this).text('Switch Plan');
                                        // var current_plan_price = 155.53;
                                        // var current_plan_license = 2;
                                        // var current_membership_code = 'sprout';
                                        var current_plan_price = current_subscription.price;
                                        var current_plan_license = current_subscription
                                            .extra_license;
                                        var current_membership_code = current_subscription
                                            .membership_code;
                                        var extra_license = $('#extra_license').val();
                                        var plan_price = $('#membership_actual_price_' +
                                            membership_code).val();
                                        // console.log('current_subscription_membership_code: '+current_membership_code);
                                        // console.log('membership_code: '+membership_code);
                                        // console.log('current_plan_license: '+current_plan_license);
                                        // console.log('extra_license: '+extra_license);
                                        if (current_plan_price > plan_price) {
                                            // console.log('if');
                                            $(this).attr('onclick', 'alert("You can cancel your plan but can\'t downgrade.")');
                                        } else if (current_membership_code == 'blossom' && membership_code == 'sprout') {
                                            $(this).attr('onclick', 'alert("You can cancel your plan but can\'t downgrade.")');
                                        } else if (current_plan_license > extra_license) {
                                            $(this).attr('onclick',
                                                'alert("You can cancel your plan but can\'t downgrade.")'
                                                );
                                        } else {
                                            // console.log('else');
                                            $(this).attr('onclick', 'changePlan("' +
                                                membership_code + '")');
                                            var item_id = $('#item_id_' + current_subscription
                                                .membership_code).val();
                                            if (item_id == current_subscription
                                                .membership_item_id) {
                                                $('#sub_btn_' + current_subscription
                                                    .membership_code).text('Your Plan');
                                                $('#sub_btn_' + current_subscription
                                                    .membership_code).attr('onclick', '');
                                            }
                                        }
                                    }
                                });
                            } else {

                                $("#error-text").html('This store subscription plan is in progress.');
                                $("#error-row").show();
                                $("#btn-row").hide();
                            }
                        }
                    } else {

                        $('#subscriptionBtn').html('Pay $399 for One Time Setup Fee');
                        $('#cardModal').modal('show');
                    }
                }
            });
        }
    }

    function changePlan(code) {
        activeFrmID = code + '_form';
        var r = confirm("Are you sure to switch the plan?");
        if (r == true) {
            var store = $("#store").val();
            $("#" + activeFrmID).append("<input type='hidden' name='store_id' value='" + store + "' />");
            var extra_license = $('#extra_license').val();
            if (extra_license != '') {
                $("#" + activeFrmID).append("<input type='hidden' name='extra_license' value='" + extra_license +
                    "' />");
            }
            var card_id = $("input[name='card']:checked").val();
            /*if (coupon_id != '') {
                var membership_coupon_id = $('#membership_coupon_id').val();
                $("#"+activeFrmID).append("<input type='hidden' name='membership_coupon_id' value='" + membership_coupon_id + "' />");
            }
            $("#"+activeFrmID).append("<input type='hidden' name='stripe_coupon_id' value='" + coupon_id + "' />");*/
            // $("#"+activeFrmID).append("<input type='hidden' name='stripe_card_id' value='" + card_id + "' />");
            $("#error-row").hide();
            $("#error-text").html('');
            $("#btn-row").hide();
            $("#processing-row").show();
            $.ajax({
                type: "POST",
                url: "{{ route('supplier.change-subscription') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#" + activeFrmID).serialize(),
                dataType: "json",
                success: function(result) {
                    if (result.status == 'error') {
                        $("#btn-row").show();
                        $("#processing-row").hide();
                        $("#error-text").html(result.message);
                        $("#error-row").show();
                    } else {
                        $("#thnksMsg").html(result.message);
                        $("#thnksModal").modal("show");
                    }
                }
            });
        }
    }

</script>
@endsection
