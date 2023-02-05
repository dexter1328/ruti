<style>
    .stay-open {display:block !important;}


    div#social-links {
                max-width: 400px;
            }
            div#social-links ul li {
                display: inline-block;
            }
            div#social-links ul li a {
                padding: 5px;
                border: 1px solid #ccc;
                margin: 1px;
                font-size: 30px;
                color: #222;
                background-color: #ccc;
            }

            
/** rating **/
div.star {
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 20px;
  color:
#444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  font-family: FontAwesome;
  color:
#e74c3c;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color:
#e74c3c;
  text-shadow: 0 0 5px
#7f8c8d;
}

input.star-1:checked ~ label.star:before { color:
#F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}


.horline > li:not(:last-child):after {
    content: " |";
}
.horline > li {
  font-weight: bold;
  color:
#ff7e1a;

}

.checked-star {
    color: orange;
}
/** end rating **/
</style>







{{-- <style>
    .banneer-icon li {
	/* float: left; */
	position: relative;
	padding: 0;
	display: inline-block;
	font-size: 30px;
	vertical-align: top;
	text-align: center;
	line-height: 58px;
	color: #222;
	background: #fff;
	border-radius: 100%;
	width: 100px;
	height: 60px;
	-webkit-transition: ease all .5s;
	-moz-transition: ease all .5s;
	-o-transition: ease all .5s;
	transition: ease all .5s;
	box-shadow: 0px 2px 10px 4px rgba(255, 255, 255, .2);
}
.banneer-icon li i {
	color: #222;
	-webkit-transition: ease all .5s;
	-moz-transition: ease all .5s;
	-o-transition: ease all .5s;
	transition: ease all .5s;
}
.banneer-icon li:hover {
	/* background: #ec6724; */
	-webkit-box-shadow: 0px 0px 5px 0px rgba(105, 90, 166, 0.5);
	-moz-box-shadow: 0px 0px 5px 0px rgba(105, 90, 166, 0.5);
	box-shadow: 0px 0px 5px 0px rgba(105, 90, 166, 0.5);
}

.banneer-icon li:hover i {
	color: #fff;
}
.banneer-icon li:first-child {
	margin-right: 60px;
}
.banneer-icon .apple {
	position: relative;
}
.banneer-icon .apple:after {
	width: 1px;
	height: 60px;
	background: #fff;
	opacity: 0.2;
	left: 90px;
	top: 0px;
	position: absolute;
	content: '';
}
.banneer-icon li p {
	color: #fff;
	font-size: 15px;
	font-weight: 400;
	font-family: 'Open Sans', Arial, sans-serif;
	padding-top: 6px;
	text-align: center;
}
.banneer-img li {
	float: left;
}
.banneer-img {
	position: relative;
}
.banneer-img::after {
	background: url(../image/banneer-mobile-image.png);
	background-repeat: repeat;
	height: 573px;
	z-index: 99;
	width: 50%;
	right: -240px;
	top: -73px;
	position: absolute;
	background-repeat: no-repeat;
	content: '';
	animation: movebounce 3.9s linear infinite;
}
.banneer-icon-new li
{
	background: none;
	box-shadow: none;
}
.banneer-icon-new li:hover
{
	background: none;
	box-shadow: none;
}

.fa-plane, .fa-life-ring, .fa-undo, .fa-credit-card {
    color: #BC5C31;
}





/** rating **/
div.star {
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 20px;
  color:
#444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  font-family: FontAwesome;
  color:
#e74c3c;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color:
#e74c3c;
  text-shadow: 0 0 5px
#7f8c8d;
}

input.star-1:checked ~ label.star:before { color:
#F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}


.horline > li:not(:last-child):after {
    content: " |";
}
.horline > li {
  font-weight: bold;
  color:
#ff7e1a;

}

.checked-star {
    color: orange;
}
/** end rating **/
.bni1 .apple:after {
	width: 1px;
	height: 60px;
	background: rgb(0, 0, 0);
	opacity: 0.2;
	left: 90px;
	top: 0px;
	position: absolute;
	content: '';
}
.bni2 .apple:after {
	width: 1px;
	height: 60px;
	background: rgb(0, 0, 0);
	opacity: 0.2;
	left: 90px;
	top: 0px;
	position: absolute;
	content: '';
}
</style> 

--}}

