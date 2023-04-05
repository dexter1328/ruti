<style type="text/css">
	#cardListContent .font-weight-bold {font-size: 13px;}
	.more-toggle::after{display: none;}
	.more-menu.show{transform: translate3d(-140px, 20px, 0px) !important;}
	.card .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{border-bottom: 2px solid #000;}
	.card-badge-default {font-size: 10px; padding: 3px; background: #003366;color: #fff; font-weight: 500; border-radius: 5px;}
	.card-badge-expired {font-size: 10px; padding: 3px; background: #f5365c;color: #fff; font-weight: 500; border-radius: 5px;}
	.card-action {position: absolute; right: 7px; bottom: 4px;}
	.card-action .action-list {border: 2px solid #b5b5b5;border-radius: 5px; padding: 0px 0px 0px 5px;}
	.card-action .action-item {list-style-type: none; display: inline-block;border-right: 2px solid #b5b5b5; padding: 3px 0px 0px 3px;}
	.card-action .action-item-last {list-style-type: none; display: inline-block;padding: 3px 0px 0px 3px;}
	.action-item-last .dropdown-item { padding-bottom: 0px; }
	.action-item-last .dropdown-menu {transform: translate3d(-141px, 20px, 0px) !important;}
</style>

<div class="card card-small">
	<div class="card-header">
		<h5 class="m-0">Manage Cards</h5>
		<ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#cardList" role="tab" aria-controls="cardList" aria-selected="true">Card List</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  href="#addCard" role="tab" aria-controls="addCard" aria-selected="false">Add Card</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div id="error" class="text-danger"></div>
		<div id="success" class="text-success"></div>
		<div class="tab-content">
			<div class="tab-pane active" id="cardList" role="tabpanel"></div>
			<div class="tab-pane" id="addCard" role="tabpanel" aria-labelledby="addCard-tab">
				<form method="post" id="addCardForm">
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

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

$(function() {

	$('#bologna-list a').on('click', function (e) {
		e.preventDefault();
		$(this).tab('show');
		getCard();
	});
});

//Manage Credit/Debit Card Script Start

function getCard() {

	$.ajax({
		type: "POST",
		url: "{{url('/supplier/get-supplier-card')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		dataType: "json",
		success: function(result){

			$("#cardList").html(result.data.cardlist);
		}
	});
}

function addCard(e) {

	e.preventDefault();
	$("#error").html("");
	$("#success").html("");
	var valid = cardValidation();

	if(valid == true) {
		$("#addCardBtn").hide();
		$( "#processing" ).css("display", "inline-block");
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

	if(valid == false) {
		$("#error").html("All Fields are required");
	}

	return valid;
}

//set your publishable key
Stripe.setPublishableKey("{{Config::get('services.stripe.key')}}");

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
	if (response.error) {
		//enable the submit button
		$("#addCardBtn").show();
		$( "#processing" ).css("display", "none");
		//display the errors on the form
		$("#error").html(response.error.message).show();
	} else {

		//get token id
		var token = response['id'];
		saveCard(token);
	}
}

function saveCard(token){

	$.ajax({
		type: "POST",
		url: "{{url('/supplier/save-supplier-card')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			stripeToken: token
		},
		dataType: "json",
		success: function(result){
			// console.log(result);
			$("#addCardBtn").show();
			$("#processing").css("display", "none");
			if(result.status == 'error'){
				$("#error").html(result.message);
			}else{
				var card = result.data;
				var exp_month = ('0' + card.exp_month).slice(-2);
				var str = '';
				str += '<li class="list-group-item d-flex justify-content-between align-items-center">';
					str += card.brand + ' &#8226;&#8226;&#8226;&#8226; ' + card.last4;
					str += '<br>';
					str += 'Expiry: ' + exp_month + '/' + card.exp_year;
				str += '</li>';
				$('#success').html(result.message);
				if($('#card_count').val() > 0){
					$('#cardListContent').append(str);
				}else{
					$('#cardListContent').html(str);
				}

				$('#addCardForm')[0].reset();
				getCard();
				activaTab('cardList');
			}
		}
	});
}

function editCard(cid) {

	/*$.ajax({
		type: "POST",
		url: "{{url('/supplier/save-supplier-card')}}/",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			stripeToken: token
		},
		dataType: "json",
		success: function(result){

		}
	});*/
}

function deleteCard(cid) {


}

function activaTab(tab){
	$('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
// End
</script>
