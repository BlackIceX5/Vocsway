<!DOCTYPE html>
<html lang="en">
<head>

    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <meta name="description" content="New social network for car owners" />
    <meta name="author" content="BIC - BlackIceCompany"/>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta id="csrf-token" name="csrf-token" content="{!!csrf_token()!!}"/>
    <meta name="theme-color" content="#317EFB"/>
    <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    <link href="{{ asset('style.css') }}" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"/>
    <link href="{{ asset('css/croppie.css') }}" rel="stylesheet"/>
</head>

<body class="hidden">
	<main class="shadow">
    <div class="preloader-wrap">
    	<div class="outer">
        	<div class="inner">
      			<div class="percentage" id="precent"></div>
                <div class="preloader-text">Cars World <span>VOCSWAY</span></div>
      		</div>
      	</div>
    </div>
	<div class="cd-index cd-main-content">
	<!-- Page Content -->
		<div id="page-content" class="" data-bgcolor="#eee">
        <!-- Background Lines -->
        <div class="bg-lines hidden">
            <svg>
    			<line x1="20%" y1="100%" x2="80%" y2="0"></line>
				<line x1="80%" y1="100%" x2="20%" y2="0"></line>
    		</svg>
        </div>
        <!--/Background Lines -->
        <!-- Header -->
        <header class="scroll-hide shadow">
			<!-- CONTAINER FOR PUSH NOTIFICATION -->
			<div class="pushNotificationContainer">
			</div>
            <div id="header-container">
				<!-- Logo -->
				<div id="logo">
					<a >
						@guest

							@php ($avatar = asset('images/users/user.png'))

						@else
							@if(file_exists('images/users/' . Auth::user()->id  . '.jpg'))

								@php ($avatar = asset('images/users/' . Auth::user()->id  . '.jpg?nocache='.time()))

							@else

								@php ($avatar = asset('images/users/user-loged.png'))

							@endif

						@endguest

						<img  class="black-logo @guest active-item @endguest" src="{{ $avatar }}" alt="User Logo">
						<img  class="white-logo" src="{{ $avatar }}" alt="Vocsway Logo">
					</a>
				</div>
				<div class="logo_container">
					@guest
						<p>
							<a class="menu-link " data-type="page-transition"  href="{{ route('login') }}">Login </a>
						</p>
						<p>
							<a class="menu-link " data-type="page-transition"   href="{{ route('register') }}">Registration </a>
						</p>
					@else

						<p>
							<a class="menu-link " data-type="page-transition" href="{{ route('edit-user')}}"    title="Edit Your Profile">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>
						</p>

						<p>
							<a class="menu-link " data-type="page-transition"  href="{{ route('logout') }}"
							onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out"></i> Logout
							</a>
						</p>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>


					@endguest
				</div>
				<!-- Menu Burger -->
				<div id="burger-wrapper" >
					<div id="burger-circle" class=""></div>
					<div id="menu-burger">
						<span></span>
						<span></span>
					</div>
				</div>
				<!--/Menu Burger -->
			</div>
        </header>
        <!--/Header -->
        <!-- Menu Overlay -->
        <div id="menu-overlay">
            <div id="close-menu"></div>
            <div class="outer">
                <div class="inner">
                    <nav>
                        <ul class="main-menu">
                            <li class="mp active"><a class="ajax-link menu-link" data-type="page-transition" href=""><span></span>Home</a></li>
                            <li class="mp has-sub"><a href="#"><span></span>Garage</a>
                                <ul>
									@guest
										<li><a class="ajax-link" data-type="page-transition" href="{{ route('login') }}">Please login </a></li>
										<li><a class="ajax-link" data-type="page-transition" href="{{ route('register') }}"> or Register to have this futures</a></li>
									@else
										<li><a class="ajax-link" data-type="page-transition" href="{{ route('add.auto') }}">Register a Car</a></li>
										<li><a class="ajax-link" data-type="page-transition" href="{{ route('garage') }}">My Cars</a></li>
										@forelse ($userCars as $car)
											<li><a class="ajax-link menu-link" data-type="page-transition" href="{{ route('car.profile', ['id'=>$car->id]) }}">{{ $car->make }} - {{ $car->nickauto }}</a></li>
										@empty
										@endforelse
									@endguest
                                </ul>
                            </li>
                            <li class="mp"><a class="ajax-link menu-link" data-type="page-transition"  href="{{ route('people') }}"><span></span>Peoples</a></li>
                            <li class="mp"><a class="ajax-link menu-link" data-type="page-transition" href="{{ route('vote') }}"><span></span>Vote</a></li>
							<li class="mp">
								<a class="inLine" data-type="page-transition" href=""><i class="fas fa-bell @if(CLSWebSocket::getnotificationCount(Auth::id()) > 0) faa-ring animated @endif"  id="notificationIcon">  @if(CLSWebSocket::getnotificationCount(Auth::id()) > 0) {{ CLSWebSocket::getnotificationCount(Auth::id()) }} @endif  </i></a>
								<a class="inLine" data-type="page-transition" href=""><i class="fas fa-envelope" id="massageIcon">  </i></a>
								<input type="hidden" id="user_id" value="{{ Auth::id() }}">
							</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Menu Overlay -->


                @yield('content')


        <!-- Footer -->
        <footer class="hidden after-slider shadow">
            <div id="footer-container">

				@if (url()->current() == 'https://vocsway.com')
					<div  id="page-action-holder-left" data-tooltip="Filters" data-placement="top">
						<div id="open-filters">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="20px" y="20px" width="40px" height="40px" viewBox="0 0 80 80" xml:space="preserve">
								<circle class="circle-action is-inner" cx="40" cy="40" r="36" ></circle>
								<circle class="circle-action is-outer" cx="40" cy="40" r="36" ></circle>
                       		 </svg>
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
				@else
					<div  id="page-action-holder-left" data-tooltip="Prev" data-placement="right">
						<div id="prev-slide">
                        	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="20px" y="20px" width="40px" height="40px" viewBox="0 0 80 80" xml:space="preserve">
                        	    <circle class="circle-action is-inner" cx="40" cy="40" r="36" ></circle>
                        	    <circle class="circle-action is-outer" cx="40" cy="40" r="36" ></circle>
                        	</svg>
                        	<i class="fa fa-chevron-left" aria-hidden="true"></i>
				@endif
                        <div class="circle-line"></div>
                    </div>
                </div>

				@if (url()->current() == 'https://vocsway.com')
					<div id="page-action-holder-right" data-tooltip="Go Top" data-placement="top">
						<div id="scrolltotop">
							<i class="fas fa-cog fa-spin postLoad"></i>
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="10px" y="10px" width="40px" height="40px" viewBox="0 0 80 80" xml:space="preserve">
                            	<circle class="circle-action is-inner" cx="40" cy="40" r="36" ></circle>
								<circle class="circle-action is-outer" cx="40" cy="40" r="36" ></circle>
                       		 </svg>
							<i class="fa fa-chevron-up" aria-hidden="true"></i>
				@else
					<div id="page-action-holder-right" data-tooltip="Next" data-placement="left">
						<div id="next-slide">
                       	 	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="10px" y="10px" width="40px" height="40px" viewBox="0 0 80 80" xml:space="preserve">
                        	    <circle class="circle-action is-inner" cx="40" cy="40" r="36" ></circle>
                        	    <circle class="circle-action is-outer" cx="40" cy="40" r="36" ></circle>
                        	</svg>
                        	<i class="fa fa-chevron-right" aria-hidden="true"></i>
				@endif
                        <div class="circle-line"></div>
                    </div>
                </div>


	        	</div>

	        </footer>
			 @yield('page-nav')
	        <!--/Footer -->


		</div>
		<!--/Page Content -->

	    <div id="rotate-device"></div>


	    </div>
	</main>

	<div class="cd-cover-layer"></div>
	<p class="copyright">2018 © .
		<a data-type="page-transition"  href="{{ route('privacy.policy') }}">Privacy Policy. </a>
		Created by
		<a target="_blank" href="https://aronovych-vasyl.com"> BlackIce</a>.
	</p>
		<script>
			let meta=document.createElement('meta');
				meta.name='csrf-token';
				meta.setAttribute('content', '{!!csrf_token()!!}');
				document.getElementsByTagName('head')[0].appendChild(meta);
		</script>
	    <script src="{{ asset('js/app.js') }}"></script>
	    <script src="{{ asset('js/plugins.js') }}"></script>
	    <script src="{{ asset('js/scripts.js') }}"></script>
		<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
		<script src="{{ asset('js/core.js') }}"></script>
		<script src="{{ asset('js/croppie.min.js') }}"></script>


		 @yield('scripts')

	</body>

</html>