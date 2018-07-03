@extends('layouts.mainLayout')
@section('content')

    <!-- Portfolio Filters -->
    <div class="page-action-overlay">
        <div class="outer">
            <div class="inner">
                <div class="close-page-action"></div>
                <p class="page-action-text">  Filters</p>
                <ul id="filters" class="page-action-content">
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
                    <img src="https://vocsway.com/images/postImages/152813951174Medium.jpg" class="img-thumbnail postImage">
                    <h1 class="hero-title">BMW SERIE 5 BlackShaphire</h1>
                    <p class="hero-subtitle">Car Of The Day</p>
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
                            <i class="fas fa-expand fa-2x expand"></i>
                            <div class="item-shadow"></div>
                            <a href="{{ route('post', ['id'=>$post->id]) }}" class="ajax-link" data-type="page-transition">
                                <div class="item-image" data-src="{{ $post->main_img }}" alt="{{ $post->title }}"></div>
                                <div class="item-gradient"></div>
                            </a>
                            <div class="item-caption">
                                <h2 class="item-title">{{ $post->title }}</h2>
                                <h3 class="item-sub-mask">
                                    <span class="item-cat">{{ $post->category }}</span>
                                    <span class="item-case">View Details</span>
                                </h3>
                                <div class="item-sub-mask ">
                                    <span class="item-cat">{{ $post->date }}</span>
                                </div>
                                <div class="item-sub-mask ">
                                    <i class="item-cat fas fa-eye blogInfo">{{ $post->visits}}</i>
                                    <i class="item-cat fas fa-thumbs-up blogInfo">{{ $post->likes}}</i>
                                    <i class="item-cat fas fa-comments blogInfo">{{ $post->comments}}</i>
                                </div>
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