<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ClarkBook</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <!-- Place favicon.ico  the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fontello.css') }}">
        <link href="{{ asset('assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fonts/icon-7-stroke/css/helper.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}"> 
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/icheck.min_all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/price-range.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">  
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.transitions.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/jquery.slitslider.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <noscript>
        <link rel="stylesheet" type="text/css') }}" href="{{ asset('assets/css/styleNoJS.css') }}" />
        </noscript>
    </head>
    <body>

        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        

        <div class="slide-2">
            <div id="slider" class="sl-slider-wrapper">
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                        <div class="sl-slide-inner ">

                            <div class="bg-img bg-img-1" style="background-image: url({{ asset('assets/img/slide2/1.jpg') }}"></div>                             
                            <blockquote><cite><a href="property.html">J.K. Rowling</a></cite>
                                <p>“Working hard is important. But there is something that matters even more. Believing in yourself.”
                                </p>
                                <span class="pull-left">
                                    <a class="navbar-btn nav-button wow bounceInRight login" href="{{ route('login') }}">ClarkBook Login</a>
                                </span>
                            </blockquote>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
          
        <script src="{{ asset('assets/js/modernizr-2.6.2.min.js') }}"></script>

        <script src="{{ asset('assets/js/jquery-1.10.2.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-hover-dropdown.js') }}"></script>

        <script src="{{ asset('assets/js/easypiechart.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>

        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>        

        <script src="{{ asset('assets/js/wow.js') }}"></script>

        <script src="{{ asset('assets/js/icheck.min.js') }}"></script>
        <script src="{{ asset('assets/js/price-range.js') }}"></script>


        <script src="{{ asset('assets/js/jquery.ba-cond.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slitslider.js') }}"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script type="text/javascript">
                            $(function () {

                                var Page = (function () {

                                    var $nav = $('#nav-dots > span'),
                                            slitslider = $('#slider').slitslider({
                                        onBeforeChange: function (slide, pos) {

                                            $nav.removeClass('nav-dot-current');
                                            $nav.eq(pos).addClass('nav-dot-current');

                                        }
                                    }),
                                            init = function () {

                                                initEvents();

                                            },
                                            initEvents = function () {

                                                $nav.each(function (i) {

                                                    $(this).on('click', function (event) {

                                                        var $dot = $(this);

                                                        if (!slitslider.isActive()) {

                                                            $nav.removeClass('nav-dot-current');
                                                            $dot.addClass('nav-dot-current');

                                                        }

                                                        slitslider.jump(i + 1);
                                                        return false;

                                                    });

                                                });

                                            };

                                    return {init: init};

                                })();

                                Page.init();

                                /**
                                 * Notes: 
                                 * 
                                 * example how to add items:
                                 */

                                /*
                                 
                                 var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');
                                 
                                 // call the plugin's add method
                                 ss.add($items);
                                 
                                 */

                            });
        </script>
    </body>


</body>
</html>