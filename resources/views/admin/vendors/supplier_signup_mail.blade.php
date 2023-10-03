 <center>
      <img src="{{asset('public/wb/img/logo/logo2.png')}}" style="width:250px; height: auto;border: none; display: block; -ms-interpolation-mode: bicubic;">
</center>

<p>Hi Admin,</p>

<p>New Supplier Signup in Nature Checkout</p>
<a href="{{ route('supplier.edit', $id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Supplier">
  To view supplier refer this link
</a>
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

