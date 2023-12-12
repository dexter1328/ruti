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

<p>Vendor {{$name}} Generate the coupon, please check and verify this coupon using below link</p>
<p>
<a href="{{ url('admin/vendor_coupons/unverified_edit') }}/{{$id}}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
	Verify Coupon
</a>
</p>
<p>Thanks! <br> Nature Checkout</p>

