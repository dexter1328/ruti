<!--Download - https://github.com/lime7/responsive-html-template.git-->
<html lang="en">

	<head>
	  <meta charset="UTF-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	  <title>Nature Checkout</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  <style>
	  .ReadMsgBody {
	    width: 100%;
	    background-color: #ffffff;
	  }

	  .ExternalClass {
	    width: 100%;
	    background-color: #ffffff;
	  }
	  /* Windows Phone Viewport Fix */

	  @-ms-viewport {
	    width: device-width;
	  }
	  </style>
	</head>

	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background: #ffffff; width: 100%; height: 100%; margin: 0; padding: 0;">
	<center><h2>{{$newsletter->subject_name}}</h2></center>
	<p style="text-align:justify;">{!! $newsletter->description !!}</p>
	</body>

</html>

