<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>


<!-- Marketplace order completion to supplier starts -->
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
          <tr>
            <td colspan="2" style="color: #e96725">
              Dear, <span>Supplier</span>
            </td>
          </tr>
          <tr style="text-align: center;">
            <td><h2>You just received an order</h2></td>
          </tr>
          <tr style="">
            <td><p>We are writing this mail to you to confirm that you have received order on marketplace.</p></td>
          </tr>
          <tr style="background-color: #efefef">
            <td colspan="2">
              <div>
                <div>Order No: <b>{{ $details['order_no'] }}</b></div>
                {{-- <div>Seller Name: <b>{{ $details['order_no'] }}</b></div>
                <div>Seller Address: <b>{{ $details['order_no'] }}</b></div>
                <div>City: <b>{{ $details['order_no'] }}</b></div>
                <div>State: <b>{{ $details['order_no'] }}</b></div>
                <div>Zip Code: <b>{{ $details['order_no'] }}</b></div> --}}
              </div>
            </td>
          </tr>
          <tr>
            <td
              colspan="2"
              style="border-bottom: 1px solid black; padding: 20px 0;"
            >
              <div>
                We hope to see you sell again soon. <br />
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
<!-- Marketplace order completion to supplier ends -->


</html>
