@extends('layouts.mainLayout')
@section('title')
	Social Network for Car Enthusiasts
@endsection
@section('content')

	<!-- Portfolio Filters -->
	<div class="page-action-overlay">
		<div class="outer">
			<div class="inner">
				<div class="close-page-action"></div>

				<ul id="filters" class="page-action-content">
					<li>
						<a id="all" class="active">
							<div class="form-group row">

								<div class="col-md-12">
									<h3 class="white">Filters</h3>
								</div>

							</div>
						</a>
					</li>
					<li>
						<a id="all" class="active">
							<div class="form-group row">

								<div class="col-md-12">
									<select id="make" type="text" class="form-control" name="make" required autofocus>
										<option  selected="selected" disabled="disabled">Make</option>
									</select>
								</div>

							</div>
						</a>
					</li>
					<li>
						<a >
							<div class="col-md-12">
								<select id="model" type="text" class="form-control" name="model" required autofocus>
									<option  selected="selected" disabled="disabled">Model</option>
								</select>
							</div>
						</a>
					</li>
					<li>
						<a >
							<div class="col-md-12">
								<select id="year" type="text" class="form-control" name="year" required autofocus>
									<option  selected="selected" disabled="disabled">Year</option>
								</select>
							</div>
						</a>
					</li>
					<li>
						<a >
							<h3 class="filterLoad">Load</h3>
						</a>
					</li>
				</ul>
			</div>

		</div>
	</div>
	<!--/Portfolio Filters -->


	<!-- Main -->
	<div id="main">

		<!-- Hero Section -->
		<div id="hero">
			<div id="hero-styles" class="opacity-onscroll">
				<div id="hero-caption">
					<div class="inner carOfDay">
						<a data-type="page-transition"  href="{{ route('car.profile', ['id'=>$carOfDay->carId]) }}">
							<img src="{{ $carOfDay->carImage }}" class="img-thumbnail postImage" alt="{{ $carOfDay->make }} {{ $carOfDay->model }}">

							<h1 class="hero-title">{{ $carOfDay->make }} {{ $carOfDay->model }} {{ $carOfDay->nickAuto }}</h1>
						</a>
						<p class="hero-subtitle">Car Of The Day
							<a class="ajax-link" data-type="page-transition" href="{{ route('vote') }}">Vote</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div id="hero-height" class="hidden"></div>
		<!--/Hero Section -->


		<!-- Main Content -->
		<div id="main-content">


			<!-- Portfolio Wrap -->
			<div id="portfolio-wrap" class="black-overlay">

				<!-- Portfolio Columns -->
				<div id="portfolio" data-col="3">
					@foreach ($posts as $post)
						<div class="item photo">
							<div class="item-content">
								<div class="item-shadow"></div>

									<div class="item-image img-thumbnail " data-src="{{ $post->main_img }}" alt="{{ $post->title }}"></div>
									<div class="item-gradient"></div>
								<a href="{{ route('post', ['id'=>$post->id]) }}"  data-type="page-transition">
								<div class="item-caption">

									<h2 class="item-title">{{ $post->title }} </h2>
									<h3 class="item-sub-mask">
										<span class="item-cat">{{ $post->category }} {{ $post->date }}</span>
										<span class="item-case">View Details</span>
									</h3>

									<div class="item-sub-mask ">
										<i class="item-cat fas fa-eye blogInfo">{{ $post->visits}}</i>
										<i class="item-cat fas fa-thumbs-up blogInfo">{{ $post->likes}}</i>
										<i class="item-cat fas fa-comments blogInfo">{{ $post->comments}}</i>
									</div>
								</div>
								</a>
								<div class="col-md-12 text-center voteCarDesc top100" >

									<p class="mainPostContent">{{ $post->content }}</p>

								</div>
							</div>

						</div>

					@endforeach
				</div>
				<!--/Portfolio -->
			</div>
			<!--/Portfolio Wrap -->


		</div>
		<!--/Main Content -->

	</div>
	<!--/Main-->

@endsection
