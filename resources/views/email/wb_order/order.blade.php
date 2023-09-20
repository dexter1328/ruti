<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>



<!-- Order Completion mail starts -->
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
            <td style="text-align: right; padding-right: 3%">
              <h2>Order Cofirmation</h2>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="color: #e96725">
              Hello, <span>{{ $details['name'] }}</span>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="">
              <h3>Your Order has been placed successfully!</h3>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="">
              Order <span style="color: #007bff">{{ $details['order_no'] }}</span>
            </td>
          </tr>
          <tr style="background-color: #efefef">
            <td colspan="2">
              <div>
                <div>Name: <b>{{ $details['name'] }}</b></div>
                <div>City: <b>{{ $details['city'] }}</b></div>
                <div>State: <b>{{ $details['state'] }}</b></div>
                <div>Zip Code: <b>{{ $details['zip_code'] }}</b></div>
                <div>Address: <b>{{ $details['address'] }}</b></div>
                <div>Total Price: <b>$ {{ $details['total_price'] }}</b></div>
              </div>
            </td>
          </tr>
          <tr>
            <td
              colspan="2"
              style="border-bottom: 1px solid black; padding: 10px 0"
            >
              <div>
                We hope to see you again soon. <br />
                <a
                  href="https://naturecheckout.com/"
                  style="color: black; text-decoration: none; font-weight: bold"
                  target="_blank"
                  >https://naturecheckout.com/</a
                >
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <br><br>Your order will be shipped shortly and you will receive a shipment
              confirmation email with the tracking information. If you have any
              questions about your order, please don't hesitate to contact us at
              <a href='#'>support@naturecheckout.com</a>. Thank you for choosing our store for
              your recent purchase. We hope that you will have a great shopping
              experience with us.<br><br> Best regards,<br> The <b>Nature Checkout</b> Team
            </td>
          </tr>
        </thead>
      </table>
    </div>
  </body>

<!-- Order Completion mail ends -->


</html>
