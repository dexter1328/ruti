 <center>
    <img
    width="50%"
    height="250px"
    style="margin-left: 5%"
    {{-- src="{{ asset('public/wb/img/new_homepage/logo/logo.png') }}" --}}
    src="https://naturecheckout.com/public/wb/img/new_homepage/logo/logo.png"
    alt="Nature Checkout"
  />
</center>

<p>Hi Admin,</p>

<p>New Vendor Signup in Nature Checkout</p>
{{-- <a href="{{ route('vendor.edit', $id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
  To view vendor refer this link
</a> --}}
<br>
<table class="table table-bordered" style="margin-top:20px;" cellpadding="2" cellspacing="5">
    <tbody>
      	<tr>
	        <td><b>Name</b></td>
	        <td>{{$name}}</td>
      	</tr>
      	<tr>
	        <td><b>Email</b></td>
	        <td>{{$email}}</td>
      	</tr>
      	@if(!empty($mobile_number))
      	<tr>
	        <td><b>Mobile No</b></td>
	        <td>{{$mobile_number}}</td>
      	</tr>
      	@endif
      	@if(!empty($phone_number))
      	<tr>
	        <td><b>Phone Number</b></td>
	        <td>{{$phone_number}}</td>
      	</tr>
      	@endif
      	@if(!empty($address))
      	<tr>
	        <td><b>Address</b></td>
	        <td>{{$address}}</td>
      	</tr>
      	@endif
      	@if($country != NULL)
      	<tr>
	        <td><b>Country</b></td>
	        <td>{{$country}}</td>
      	</tr>
      	@endif
      	@if($state != NULL)
      	<tr>
	        <td><b>State</b></td>
	        <td>{{$state}}</td>
      	</tr>
      	@endif
      	@if($city != NULL)
      	<tr>
	        <td><b>City</b></td>
	        <td>{{$city}}</td>
      	</tr>
      	@endif
      	@if(!empty($pincode))
      	<tr>
	        <td><b>Zip Code</b></td>
	        <td>{{$pincode}}</td>
      	</tr>
      	@endif

    </tbody>
  </table>
  <br><br>
Regards,<br>
Nature Checkout Team

