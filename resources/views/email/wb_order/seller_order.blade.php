<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>



<!-- Order Completion mail to seller starts -->
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
            <td><h2>Order Received</h2></td>
          </tr>
          <tr>
            <td colspan="2" style="color: #e96725">
              Dear, <span>Supplier/Seller</span>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <h3>You Have Received an Order!</h3>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              Order <span style="color: #007bff">#{{ $details['order_no'] }}</span>
            </td>
          </tr>
          <tr style="background-color: #efefef">
            <td colspan="2">
              <div>
                <div>Customer Name: <b>{{ $details['name'] }}</b></div>
                <div>City: <b>{{ $details['city'] }}</b></div>
                <div>State: <b>{{ $details['state'] }}</b></div>
                <div>Zip Code: <b>{{ $details['zip_code'] }}</b></div>
                <div>Address: <b>{{ $details['address'] }}</b></div>
              </div>
            </td>
          </tr>
          <tr>
            <td
              colspan="2"
              style="border-bottom: 1px solid black; padding: 10px 0"
            >
              <div>
                We hope to see you sell again soon. <br />
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
              <br><br> If you have any
              questions about your order, please don't hesitate to contact us at
              <a href='#'>support@naturecheckout.com</a>. Thank you for choosing our store for
              your selling. We hope that you will have a great selling
              experience with us.<br><br> Best regards,<br> The <b>Nature Checkout</b> Team
            </td>
          </tr>
        </thead>
      </table>
    </div>
  </body>
<!-- Order Completion mail to seller ends -->



</html>
