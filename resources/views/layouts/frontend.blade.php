<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		 <title>@yield('title')</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css')}}"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css')}}">

		{{-- <title>@yield('title')</title> --}}
		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{{ asset('front/css/style.css')}}"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>

		<!-- Header -->
		<header id="header" class="transparent-nav">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div class="navbar-brand">
						<a class="logo" href="#">
							{{-- <img src="front/img/blank.jpg" alt="logo"> --}}
							<h4 style="color:white;"><strong>Logo</strong> Here</h4>
						</a>
					</div>
					<!-- /Logo -->

					<!-- Mobile toggle -->
					<button class="navbar-toggle">
						<span></span>
					</button>
					<!-- /Mobile toggle -->
				</div>

				<!-- Navigation -->
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right">
						<li><a href="index.html">Home</a></li>
						{{-- <li><a href="#">Schedule</a></li>
						<li><a href="#">Calender</a></li>
						<li><a href="#">Search Certificate</a></li> --}}
						<li><a href="{{route('register')}}">Register</a></li>
						<li><a href="{{route('login')}}">Login</a></li>
					</ul>
				</nav>
				<!-- /Navigation -->

			</div>
		</header>
		<!-- /Header -->

		<!-- Home -->
		<div id="home" class="hero-area">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(front/img/blank.jpg)"></div>
			<!-- /Backgound Image -->

			<div class="home-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<h1 class="white-text">GLC Networks Courses</h1>
							<p class="lead white-text">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant, eu pro alii error homero.</p>
							<a class="main-button icon-button" href="#">Get Started!</a>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- /Home -->

		<!-- About -->
		<div id="about" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<div class="col-md-6">
						<div class="section-header">
							<h2>Welcome to GLC Networks</h2>
							<p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
						</div>

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-flask"></i>
							<div class="feature-content">
								<h4>Online Courses </h4>
								<p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
							</div>
						</div>
						<!-- /feature -->

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-users"></i>
							<div class="feature-content">
								<h4>Expert Teachers</h4>
								<p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
							</div>
						</div>
						<!-- /feature -->

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-comments"></i>
							<div class="feature-content">
								<h4>Community</h4>
								<p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
							</div>
						</div>
						<!-- /feature -->

					</div>

					<div class="col-md-6">
						<div class="about-img">
							<img src="front/img/blank.jpg" alt="">
						</div>
					</div>

				</div>
				<!-- row -->

			</div>
			<!-- container -->
		</div>
		<!-- /About -->

		<!-- Courses -->
		<div id="courses" class="section">

			<!-- container -->
			<div class="container">

				<div class="row">
					<div class="section-header text-center">
						<h2>Explore Courses</h2>
						<p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
					</div>
				</div>
				<!-- /row -->

				<!-- courses -->
				<div id="courses-wrapper">

					<!-- row -->
					<div class="row">

						<!-- single course -->
						@foreach($isi_aset as $isi)
						<div class="col-md-4 col-sm-6 col-xs-6">
							<div class="course">
								<a href="#" class="course-img">
									<img src="front/img/blank.jpg" alt="">
									<i class="course-link-icon fa fa-link"></i>
								</a>
								<a class="course-title" href="#">{{$isi->name}}</a>
								{{$isi->description}}
								<div class="course-details">
									{{-- <span class="course-category">Business</span> --}}
									<span class="course-price course-free">{{$isi->currency.' '.$isi->price}}</span>
								</div>
							</div>
						</div>
						@endforeach
				<!-- row -->
				
					</div>
	
					{{-- {{$isi_aset->links()}} --}}
				</div>

				
				{{-- {{ $item_event->links() }} --}}

				<!-- /courses -->

				{{-- <div class="row">
					<div class="center-btn">
						<a class="main-button icon-button" href="#">More Courses</a>
					</div>
				</div> --}}

			</div>
			<!-- container -->

		</div>

		
		<!-- /Courses -->

		<!-- Call To Action -->

		<!-- /Contact CTA -->

		<!-- Footer -->
	
		<!-- /Footer -->

		<!-- preloader -->
		<div id='preloader'><div class='preloader'></div></div>
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="{{ asset('front/js/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{ asset('front/js/bootstrap.min.js')}}"></script>
		<script type="text/javascript" src="{{ asset('front/js/main.js')}}"></script>

	</body>
</html>
