@php
	if(old('description')){
		$features = (object)old('description');
	}else if($membership->description!=''){
		$features = $membership->description;
	}
	$support = isset($features->support->value) ? $features->support->value : '';
	$customer_couponing = isset($features->customer_couponing->value) ? $features->customer_couponing->value : '';
	$customer_couponing_habit = isset($features->customer_couponing_habit->value) ? $features->customer_couponing_habit->value : '';
	$product_discount = isset($features->product_discount->value) ? $features->product_discount->value : '';
	$earn_reward_points = isset($features->earn_reward_points->value) ? $features->earn_reward_points->value : '';
	$wallet_transfer = isset($features->wallet_transfer->value) ? $features->wallet_transfer->value : '';
	$delivery_services = isset($features->delivery_services->value) ? $features->delivery_services->value : '';
	$transaction_report = isset($features->transaction_report->value) ? $features->transaction_report->value : '';
	$communication_grocery_stores = isset($features->communication_grocery_stores->value) ? $features->communication_grocery_stores->value : '';
	$access_updates = isset($features->access_updates->value) ? $features->access_updates->value : '';
@endphp
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Support</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[support][label]" value="Receive support">
		<select class="form-control" name="features[support][value]">
			<option value="">Select Support</option>
			<option value="(6AM - 6PM)" @if($support == '(6AM - 6PM)') selected="selected" @endif>(6AM - 6PM)</option>
			<option value="24 hours by 7 days a week" @if($support == '24 hours by 7 days a week') selected="selected" @endif>24 hours by 7 days a week</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Direct to customer couponing</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[customer_couponing][label]" value="Direct to customer couponing">
		<select class="form-control" name="features[customer_couponing][value]">
			<option value="">Select Direct to customer couponing</option>
			<option value="2 applicable/month" @if($customer_couponing == "2 applicable/month") selected="selected" @endif>2 applicable/month</option>
			<option value="10 applicable/month" @if($customer_couponing == "10 applicable/month") selected="selected" @endif>10 applicable/month</option>
			<option value="Unlimited" @if($customer_couponing == 'Unlimited') selected="selected" @endif>Unlimited</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Receive relevant customer couponing based on habits</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[customer_couponing_habit][label]" value="Receive relevant customer couponing based on habits">
		<select class="form-control" name="features[customer_couponing_habit][value]">
			<option value="">Select Receive relevant customer couponing based on habits</option>
			<option value="Included" @if($customer_couponing_habit == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Receive product discount</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[product_discount][label]" value="Receive product discount">
		<select class="form-control" name="features[product_discount][value]">
			<option value="">Select Receive product discount</option>
			<option value="Included" @if($product_discount == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Earn reward points</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[earn_reward_points][label]" value="Earn reward points">
		<select class="form-control" name="features[earn_reward_points][value]">
			<option value="">Select Earn reward points</option>
			<option value="Included" @if($earn_reward_points == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Wallet to wallet transfer</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[wallet_transfer][label]" value="Wallet to wallet transfer">
		<select class="form-control" name="features[wallet_transfer][value]">
			<option value="">Select Wallet to wallet transfer</option>
			<option value="2% transaction fee" @if($wallet_transfer == '2% transaction fee') selected="selected" @endif>2% transaction fee</option>
			<option value="1% transaction fee" @if($wallet_transfer == '1% transaction fee') selected="selected" @endif>1% transaction fee</option>
			<option value="Included" @if($wallet_transfer == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Delivery services</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[delivery_services][label]" value="Delivery services">
		<select class="form-control" name="features[delivery_services][value]">
			<option value="">Select Delivery services</option>
			<option value="Included" @if($delivery_services == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Transaction report</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[transaction_report][label]" value="Transaction report">
		<select class="form-control" name="features[transaction_report][value]">
			<option value="">Select Transaction report</option>
			<option value="Included" @if($transaction_report == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Direct communication to grocery stores</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[communication_grocery_stores][label]" value="Direct communication to grocery stores">
		<select class="form-control" name="features[communication_grocery_stores][value]">
			<option value="">Select Direct communication to grocery stores</option>
			<option value="Included" @if($communication_grocery_stores == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Automatic access to updates</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[access_updates][label]" value="Automatic access to updates">
		<select class="form-control" name="features[access_updates][value]">
			<option value="">Select Automatic access to updates</option>
			<option value="Included" @if($access_updates == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>