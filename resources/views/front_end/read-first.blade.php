@extends('front_end.layout')
@section('content')
    <style type="text/css">

        /*@media (min-width: 767px){
            .navbar-nav.m-nav {
                top: -10;
            }
        }*/
        .fa{
            margin-top:10px;
        }
        .g-recaptcha{
            transform:scale(0.70);-webkit-transform:scale(0.70);transform-origin:0 0;-webkit-transform-origin:0 0;
        }
        #rc-anchor-alert, .rc-anchor-alert {
            visibility: hidden !important;
        }
        /*.rc-anchor-alert {
            display:none !important;
            color:white !impo;
        }*/
        .font-para.SignUPform label {
            font-size: 13px;
        }
        .font-para.SignUPform {
            border: 2px dotted #d2d2d2;
            padding: 30px 20px;
            margin: 20px 0;
            display: block;
            width: 90%;
            margin: 10px auto;
        }        
        .form-footer {
            margin: 30px 0 0px;
            display: block;
        }
        .form-footer button {            
            box-shadow: 0 5px 30px 0 rgba(81, 39, 159, .2);
        } 
        .form-footer button.btn.btn-success i {
            padding: 0 8px 0 0;
        }
        button:focus {
            outline: 0px dotted;
            outline: 0px auto -webkit-focus-ring-color;
        }
        .AcceptCheckbox input[type="checkbox"] + label:before {
            
            margin-top: 7px;
        }       

    </style>

    <div style="clear:both;"></div>

    <!-- terms-condition start -->
    <section id="inner-main-content">
        <h2 class="heading">Vendor Register</h2>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-10 col-offset-md-1">
                    <div class="font-para about-left">
                        <h4>Welcome to RUTI self checkout! A convenient self-serve mobile app for smart shopping and quick checkout.</h4>
                        <br>
                        <h5 style="text-align: center;">WHY DO BUSINESS WITH US</h5>
                        <br>
                        <ul>
                            <li>You will have same-day bank deposit of all revenue received from customers using their app.</li>
                            <li>This paperless application will reduce your cost of printing receipts and coupons.</li>
                            <li>Track customer-buying habits to create targeted marketing programs and special offers.</li>
                            <li>Utilize state-of-the-art self-service in-store grocery app ideal for post pandemic shoppers.</li>
                            <li>The app provides a well secure platform for the business owner to transact with customers.</li>
                            <li>Allows business owner to increase brand awareness by sending targeted digital couponing to customers daily.</li>
                        </ul>
                        <br>
                        <h5 style="text-align: center;">HOW THIS WILL IMPROVE CUSTOMER RELATIONS</h5>
                        <br>
                        <ul>
                            <li>Our scan, pay & go feature will increase product awareness and customer interaction.</li>
                            <li>Increase transactions per customer with our free tools and features that will strengthen loyalty amongst your customers.</li>
                            <li>Affordable innovative tool designed to simplify digital marketing for grocers.</li>
                        </ul>
                        <br>
                        <h5 style="text-align: center;">DID WE MENTION…</h5>
                        <br>
                        <ul>
                            <li>Service comes with unlimited updates.</li>
                            <li>24/7 client support service.</li>
                        </ul>
                        <br>
                        <h3 style="text-align: center; color: green">One-time fee of $399 gets you started today.</h3>
                        <br>
                        <h5 style="text-align: center;">Cost of service only $3.30 per day thereafter.</h5>
                        <p>Register or give us a call <a href="tell:1.888.802.6036">1.888.802.6036</p></p>
                        <p>Direct phone number: <a href="tell:1.209.340.9403">1.209.340.9403</p></p>
                        <p>
                            <a href="{{url('/vendor-signup')}}" class="btn btn-success">Register Now</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection