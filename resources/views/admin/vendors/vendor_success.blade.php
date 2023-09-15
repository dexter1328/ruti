 <center>
      <img src="{{ asset('public/wb/img/logo/logo2.png') }}" style="width:250px; height: auto;border: none; display: block; -ms-interpolation-mode: bicubic;">
</center>
<h2>Thanks for Registering at Nature Checkout</h2>
<p>Hi {{$name}},</p>
<p>Thank you for creating your account at Nature Checkout. Your account details are as follows:</p>
<b>Email Address: </b>{{$email}}<br>
<b>Password: </b>Your chosen password
<br>
<p>To sign in to your account, please visit <a href="{{url('vendor/login')}}">
  {{url('vendor/login')}} </a> or <a href="{{url('vendor/login')}}">click here</a>.</p>
  <br>

<p>If you have any questions regarding your account, click 'Reply' in your email client and we'll be happy to help.</p>
<p>
Thanks!<br>
Nature Checkout Team
</p>
