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
              height="60px"
              style="margin-left: 5%"
              src="{{ asset('public/images/logo-icon.png') }}"
              alt="Nature Checkout"
            />
          </td>
        </tr>
        <tr style="text-align: center;">
          <td><h2>Order Received on Nature Checkout</h2></td>
        </tr>
        <tr>
          <td colspan="2" style="color: #e96725">
            Dear, <span>Admin</span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <h3>Order <span style="color: #007bff">#{{ $details['order_no'] }}</span> has been placed successfully on Nature Checkout</h3>
          </td>
        </tr>
        <tr style="background-color: #efefef">
          <td colspan="2">
            <div>
              <div>Customer Name: <b>{{ $details['name'] }}</b></div>
              <div>Total Price: <b>{{ $details['total_price'] }}</b></div>
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
<!-- Order Completion mail to admin ends -->


</html>

