<center>
	<img src="{{asset('public/wb/img/logo/logo2.png')}}" style="width:250px; height: auto;border: none; display: block; -ms-interpolation-mode: bicubic;">
</center>

<p>Hi Admin,</p>

<p>Vendor {{$name}} Generate the coupon, please check and verify this coupon using below link</p>
<p>
<a href="{{ url('admin/vendor_coupons/unverified_edit') }}/{{$id}}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
	Verify Coupon
</a>
</p>
<p>Thanks! <br> Nature Checkout</p>

