/*========================================================================

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Template Name: Napp-app landing template
Author: ingenious_team
Primary use:    App landing. 
Version: 1.00
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

========================================================================*/
$(function () {
    "use strict";

    // for navbar background color when scrolling
    $(window).scroll(function () {
        var $scrolling = $(this).scrollTop();
        var bc2top = $("#back-top-btn");
        var stickytop = $(".sticky-top");
        if ($scrolling >= 10) {
            stickytop.addClass('navcss');
        } else {
            stickytop.removeClass('navcss');
        }

        if ($scrolling > 150) {
            bc2top.fadeIn(1000);
        } else {
            bc2top.fadeOut(1000);
        }
    });


    //animation scroll js
    var nav = $('nav'),
        navOffset = nav.offset().top,
        $window = $(window);
    /* navOffset ends */
    //animation scroll js
    var html_body = $('html, body');
    $('nav a').on('click', function () {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                html_body.animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
                return false;
            }
        }
    });

    // this is for back to top and sticky menu js
    var bc2top = $('.back-top-btn');
    bc2top.on('click', function () {
        html_body.animate({
            scrollTop: 0
        }, 1000);
    });

    // Closes responsive menu when a scroll link is clicked
    $('.nav-link').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });


    // youtube video js start here

    jQuery("a.bla-1").YouTubePopUp({
        autoplay: 0
    }); // Disable autoplay

    // pop-slick js start here
    $('.sign-slick').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: "0px",
        autoplay: true,
        arrows: false,
        dots: false,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    infinite: true

                }
    },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
    },
            {
                breakpoint: 767,
                settings: {
                    horizontal: true,
                    slidesToShow: 3,
                    slidesToScroll: 1

                }
    }
  ]
    });


    $('.features-left-slick').slick({
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        slidesToScroll: 1,
        arrows: false,
        cssEase: "ease",
        fade: true,
        asNavFor: '.features-slick',
        autoplaySpeed: 10000,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
			},
            {
                breakpoint: 767,
                settings: {
                    vertical: false,
                    arrows: false,
                    horizontal: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
			}
		  ]
    });


    $('.features-slick').slick({
        autoplay: true,
        arrows: true,
        asNavFor: '.features-left-slick',
        dots: false,
        infinite: true,
        autoPlay: true,
        slidesToShow: 3,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: "0px",
        prevArrow: '<i class="fa fa fa-play slidNext"></i>',
        nextArrow: '<i class="fa fa fa-play slidprev"></i>',
        vertical: true,
        autoplaySpeed: 10000,
        useTransform: true,
        adaptiveHeight: true,
        slidesToScroll: 1,
    });

    $('.feedback-slick').slick({
        autoplay: true,
        arrows: false,
        dots: true,
        infinite: true,
        autoPlay: true,
        slidesToShow: 3,
        autoplaySpeed: 10000,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
    },
            {
                breakpoint: 910,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
    },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
    }
  ]
    });

    $('.faq-slick').slick({
        autoplay: true,
        arrows: true,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: "0px",
        infinite: true,
        autoPlay: true,
        slidesToShow: 3,
        prevArrow: '<i class="fa fa-angle-right faqNext"></i>',
        nextArrow: '<i class="fa fa-angle-left faqprev"></i>',
        autoplaySpeed: 3000,
        useTransform: true,
        adaptiveHeight: true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
    },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
    },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
    }
  ]
    });
	
	$('.vendors-slick').slick({
        autoplay: true,
        arrows: true,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: "0px",
        infinite: true,
        autoPlay: true,
        slidesToShow: 3,
        prevArrow: '<i class="fa fa-angle-right vendorsNext"></i>',
        nextArrow: '<i class="fa fa-angle-left vendorsprev"></i>',
        autoplaySpeed: 3000,
        useTransform: true,
        adaptiveHeight: true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
    },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
    },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
    }
  ]
    });

    // switchButton js
    var switchButton = document.querySelector('.switch-button');
    var switchBtnRight = document.querySelector('.switch-button-case.right');
    var switchBtnLeft = document.querySelector('.switch-button-case.left');
    var activeSwitch = document.querySelector('.btn-active');

    function switchLeft() {
        switchBtnRight.classList.remove('active-case');
        switchBtnLeft.classList.add('active-case');
        activeSwitch.style.left = '0%';
    }

    function switchRight() {
        switchBtnRight.classList.add('active-case');
        switchBtnLeft.classList.remove('active-case');
        activeSwitch.style.left = '50%';
    }

    switchBtnLeft.addEventListener('click', function () {
        switchLeft();
    }, false);

    switchBtnRight.addEventListener('click', function () {
        switchRight();
    }, false);


});
