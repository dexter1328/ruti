<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>

<!--  Review Product starts -->
 <body>
    <div
      style="
        width: 600px;
        background-color: #efefef;
        margin: auto;
        padding: 10px;
        line-height: 25px;
        font-size: 18px;
        margin-top: 20px;
      "
    >
      <table style="width: 90%; margin: auto; border-collapse: collapse">
        <thead>
          <tr style="border-bottom:2px solid #007bff; width: 100%;">
            <td>
              <img
                width=""
                height="100px"
                style="margin: auto;"
                src="https://naturecheckout.com/public/wb/img/logo/logo.png"
                alt="Nature Checkout"
              />
            </td>
        </tr>
        <tr style="width: 100%;">
            <td colspan="2" style="width: 100%; text-align: end; padding: 10px;">
                <h2>Your Opinion Matters</h2>
            </td>
        </tr>
          <tr>
            <td colspan="2" style="color: #e96725">
              Dear <span>Customer,</span>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="padding: 10px;">
                We hope you enjoyed your recent purchase. Your feedback helps us improve.
                We value your opinion. Please take a moment to share your feedback in a review. Your insights matter to us!.
            </td>
          </tr>

          <tr>
            <td
              colspan="2"
              style="color: #e96725; border-bottom: 1px solid black"
            >
              Order Details
            </td>
          </tr>
          <tr>
            <td colspan="2" style="">
              Order <span style="color: #007bff">#{{ $details['order_no'] }}</span>
            </td>
          </tr>
          <tr style="background-color: #efefef">
            <td colspan="2" style="padding: 10px;">
                <div>
                  <div>Name: <b>{{ $details['name'] }}</b></div>
                  <div>Product Name: <b>{{ $details['product_title'] }} </b></div>
                  <div>Total Price: <b>${{ $details['price'] }}</b></div>
                </div>
              </td>
          </tr>
          <tr>
            <td style="text-align: center;" colspan="2">
                <a href="https://naturecheckout.com/shop/product_detail/{{ $details['slug'] }}/{{ $details['product_sku'] }}#reviews" target="_blank"><button style="background-color: #e96725; border: none; color: #fff; padding: 12px; border-radius: 10px; " >Tap to write a review</button></a>
            </td>
          </tr>
          <tr>
            <td
              colspan="2"
              style="border-bottom: 1px solid black; padding: 10px 0;"
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
            <td  style="padding: 10px;"></td>
          </tr>
        </thead>
      </table>
    </div>
  </body>
<!--  Review Product ends -->
</html>

