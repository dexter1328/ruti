@php
	if(old('description')){
		$features = (object)old('description');
	}else if($membership->description!=''){
		$features = $membership->description;
	}
	$fund_transfer = isset($features->fund_transfer->value) ? $features->fund_transfer->value : '';
	$support = isset($features->support->value) ? $features->support->value : '';
	$customer_couponing = isset($features->customer_couponing->value) ? $features->customer_couponing->value : '';
	$license_administrator = isset($features->license->value->administrator->value) ? $features->license->value->administrator->value : '';
	$license_manager = isset($features->license->value->manager->value) ? $features->license->value->manager->value : '';
	$license_store_clerk = isset($features->license->value->store_clerk->value) ? $features->license->value->store_clerk->value : '';
	$license_security_clerk = isset($features->license->value->security_clerk->value) ? $features->license->value->security_clerk->value : '';
@endphp
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Daily Funds Transfer</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[fund_transfer][label]" value="Daily Funds Transfer">
		<select class="form-control" name="features[fund_transfer][value]">
			<option value="">Select Daily Funds Transfer</option>
			<option value="Included" @if($fund_transfer == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Support</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[support][label]" value="Support">
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
			<option value="20 posts per month" @if($customer_couponing == '20 posts per month') selected="selected" @endif>20 posts per month</option>
			<option value="30 posts per month" @if($customer_couponing == '30 posts per month') selected="selected" @endif>30 posts per month</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-12 col-form-label">Member license Permission to download App</label>
	<input type="hidden" name="features[license][label]" value="Member license Permission to download App">
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Administrator</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[license][value][administrator][label]" value="Administrator">
		<select class="form-control" name="features[license][value][administrator][value]">
			<option value="">Select Administrator</option>
			<option value="Included" @if($license_administrator == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Manager</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[license][value][manager][label]" value="Manager">
		<select class="form-control" name="features[license][value][manager][value]">
			<option value="">Select Manager</option>
			<option value="Included" @if($license_manager == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Store Clerk</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[license][value][store_clerk][label]" value="Store Clerk">
		<select class="form-control" name="features[license][value][store_clerk][value]">
			<option value="">Select Store Clerk</option>
			<option value="Included" @if($license_store_clerk == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label for="input-11" class="col-sm-2 col-form-label">Security Clerk</label>
	<div class="col-sm-10">
		<input type="hidden" name="features[license][value][security_clerk][label]" value="Security Clerk">
		<select class="form-control" name="features[license][value][security_clerk][value]">
			<option value="">Select Security Clerk</option>
			<option value="Included" @if($license_security_clerk == 'Included') selected="selected" @endif>Included</option>
		</select>
	</div>
</div>