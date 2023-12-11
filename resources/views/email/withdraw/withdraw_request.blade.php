<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>


<!-- Withdraw funds mail to seller starts -->
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
            <td><h2>Withdrawal of Money From Wallet</h2></td>
          </tr>
          <tr>
            <td colspan="2" style="color: #e96725">
              Dear, <span>Seller/Supplier</span>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <h3>We have received your request of money withdrawal. you will soon receive the money in your bank account</h3>
            </td>
          </tr>
          <tr style="background-color: #efefef">
            <td colspan="2">
              <div>
                <div>Account Title: <b>{{ $contact_data['account_title'] }}</b></div>
                <div>Bank Name: <b>{{ $contact_data['bank_name'] }}</b></div>
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
<!-- Withdraw funds mail to seller ends -->



</html>
