<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="{{ asset('template/fonts/icomoon/style.css')}}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('template/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('template/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.theme.default.min.css')}}">


    <link rel="stylesheet" href="{{ asset('template/css/aos.css')}}">

    <link rel="stylesheet" href="{{ asset('template/css/style.css')}}">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            {{-- <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="" class="site-block-top-search">
                <span class="icon icon-search2"></span>
                <input type="text" class="form-control border-0" placeholder="Search">
              </form>
            </div> --}}

            {{-- <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-right"> --}}
			<div class="col-6 col-md-12 order-2 order-md-1 text-center">
              <div class="site-logo">
                <a href="index.html" class="js-logo-clone">Your Logo Here</a>
              </div>
            </div>

            {{-- <div class="col-6 col-md-4 order-3 order-md-3 text-right"> --}}
				{{-- <div class="col-6 col-md-4 order-2 order-md-1 text-right">
              <div class="site-top-icons">
                <ul>
                  <li><a href="#"><span class="icon icon-person"></span></a></li> --}}
                  {{-- <li><a href="#"><span class="icon icon-heart-o"></span></a></li> --}}
                  {{-- <li>
                    <a href="cart.html" class="site-cart">
                      <span class="icon icon-shopping_cart"></span> --}}
                      {{-- <span class="count">2</span> --}}
                    {{-- </a>
                  </li> 
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                </ul>
              </div> 
            </div> --}}

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
		        <li><a href="{{route ('home')}}">Home</a></li>
            <li><a href="{{url ('/store')}}">Shop</a></li>
            <li><a href="{{url ('/certificate')}}">Certificate</a></li>
			      <li><a href="{{route ('login')}}">Login</a></li>
			      <li><a href="{{route ('register')}}">Register</a></li>
          </ul>
        </div>
      </nav>
    </header>

    @yield('content')

    <div class="site-section site-blocks-2">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
            <a class="block-2-item" href="#">
              <figure class="image">
                <img src="template/images/blank.jpg" alt="" class="img-fluid">
              </figure>
              <div class="text">
                <span class="text-uppercase">Collections</span>
                <h3>Course</h3>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
            <a class="block-2-item" href="#">
              <figure class="image">
                <img src="template/images/blank.jpg" alt="" class="img-fluid">
              </figure>
              <div class="text">
                <span class="text-uppercase">Collections</span>
                <h3>Book</h3>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
            <a class="block-2-item" href="#">
              <figure class="image">
                <img src="template/images/blank.jpg" alt="" class="img-fluid">
              </figure>
              <div class="text">
                <span class="text-uppercase">Collections</span>
                <h3>Certification</h3>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- <footer class="site-footer border-top"> --}}
      <div class="container">
        {{-- <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row"> --}}
              {{-- <div class="col-md-12">
                <h3 class="footer-heading mb-4">Navigations</h3>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Sell online</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Shopping cart</a></li>
                  <li><a href="#">Store builder</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Mobile commerce</a></li>
                  <li><a href="#">Dropshipping</a></li>
                  <li><a href="#">Website development</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Point of sale</a></li>
                  <li><a href="#">Hardware</a></li>
                  <li><a href="#">Software</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Contact Info</h3>
              <ul class="list-unstyled">
                <li class="address">203 Fake St. Mountain View, San Francisco, California, USA</li>
                <li class="phone"><a href="tel://23923929210">+2 392 3929 210</a></li>
                <li class="email">emailaddress@domain.com</li>
              </ul>
            </div>

            
       
          
        </div>
	  </div> --}}
	  <div class="row pt-5 mt-5 text-center">
		<div class="col-md-12">
		  <p>
		  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		  Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" class="text-primary">Colorlib</a>
		  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		  </p>
		</div>
    {{-- </footer> --}}
  {{-- </div> --}}

  <script src="{{ asset('template/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{ asset('template/js/jquery-ui.js')}}"></script>
  <script src="{{ asset('template/js/popper.min.js')}}"></script>
  <script src="{{ asset('template/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('template/js/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('template/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{ asset('template/js/aos.js')}}"></script>

  <script src="{{ asset('template/js/main.js')}}"></script>
    
  </body>
</html>