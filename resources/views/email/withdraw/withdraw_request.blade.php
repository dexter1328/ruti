<!DOCTYPE html>
<html>
<head>
    <title>Nature Checkout</title>
</head>
<body>

<p>a customer requested to withdraw funds. please check and release funds</p>

<table id="contact">
    <tr>
        <th>Account title</th>
        <td>{{ $contact_data['fullname'] }}</td>
    </tr>
    <tr>
        <th>Account No</th>
        <td>{{ $contact_data['account_no'] }}</td>
    </tr>
    <tr>
        <th>Amount</th>
        <td>{{ $contact_data['amount'] }}</td>
    </tr>

</table>
<p>Nature Checkout</p>

</body>
</html>
