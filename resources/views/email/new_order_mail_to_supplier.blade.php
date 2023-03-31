<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>RUTI Self Checkout</title>
</head>
<body>
<table width="70%" align="center" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td style="text-align: center; background-color: #003366; padding: 1.5em;">
            <img src="{{ asset('public/images/logo-icon.png') }}" alt="logo icon" height="70" width="150">
        </td>
    </tr>
    <tr>
        <td>
            <div style="margin:30px+20px">
                {{$body}}
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; background-color: #cf5e2c; padding: 2.5em;">
            &copy; RUTI Self Checkout © 2019-2024. All Rights Reserved
        </td>
    </tr>
</table>
</body>
</html>
