<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>

 <body>
  <div
    style="
      width: 600px;
      background-color: #efefef;
      margin: auto;
      padding: 10px;
      line-height: 25px;
      font-size: 18px;
    "
  >
    <table style="width: 90%; margin: auto; border-collapse: collapse">
      <thead>
        <tr>
          <td style="text-align: center;">
            <img
                width="50%"
                height="250px"
                style="margin-left: 5%"
                {{-- src="{{ asset('public/wb/img/new_homepage/logo/logo.png') }}" --}}
                src="https://naturecheckout.com/public/wb/img/new_homepage/logo/logo.png"
                alt="Nature Checkout"
              />
          </td>
        </tr>
        <tr style="text-align: center;">
          <td><h2>Welcome to Nature Checkout</h2></td>
        </tr>
        <tr>
          <td colspan="2" style="color: #e96725">
            Dear, <span>{{ $details['name'] }}</span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <h3>We welcome you to our platform. Use this coupon code to get 10% discount.</h3>
          </td>
        </tr>
        <tr style="background-color: #efefef">
          <td colspan="2">
            <div>
              <div>Coupon Code: <b>{{ $details['coupon'] }}</b></div>
            </div>
          </td>
        </tr>
        <tr>
          <td
            colspan="2"
            style="border-bottom: 1px solid black; padding: 20px 0;"
          >
            <div>

              <a
                href="https://naturecheckout.com/"
                style="color: black; text-decoration: none; font-weight: bold"
                target="_blank"
                >https://naturecheckout.com/</a>
            </div>
          </td>
        </tr>
      </thead>
    </table>
  </div>
</body>

</html>
