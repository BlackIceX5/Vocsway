@extends('layouts.mainLayout')
@section('title')
    Elections - Car Of The Day
@endsection
@section('content')
    <!-- Hero Section -->
    <div id="hero">
        <div id="hero-styles" class="opacity-onscroll">
            <div id="hero-caption">
                <div class="inner">
                    <h1 class="hero-title">Vote today</h1>
                    <h1 class="hero-title">For select Car of the Day</h1>
                    <p class="hero-title">Сar winner </p>
                    <p class="hero-title">Will be on the main page tomorrow</p>
                    <div class="scroll-down-wrap no-border blackMouseBottom">
                        <a href="#" class="section-down-arrow blackMouse">
                            <svg class="nectar-scroll-icon" viewBox="22 0 30 45" enable-background="new 22 0 30 45">

                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hero-height" class="hidden"></div>
    <!--/Hero Section -->

    <!-- Main Content -->
    <div id="main-content">
        <div id="main-page-content">

            <!-- Row -->
            <div class="vc_row text-align-center row_padding_top has-animation"  data-delay="100">

                <div class="container text-left ">

                    <h4 class="title-has-line capitalize">3 Cars generated in random mode</h4>
                </div>
                <div class="text-center">
                    @foreach($cars as $car)
                        <div class="col-md-12 voteContainer">
                         <div class="form-group row has-animation"  data-delay="0">
                            <div class="col-md-12">
                                <a data-type="page-transition"  href="{{ route('car.profile', ['id'=>$car->id]) }}">
                                    <img class="img-thumbnail postImage" style="margin-bottom: 0" src="{!! $car->path !!}"
                                    alt="{{ $car->make }} {{ $car->model }}">
                                </a>
                            </div>

                            <div class="col-md-12 text-center voteCarDesc" >
                                <a data-type="page-transition"  href="{{ route('car.profile', ['id'=>$car->id]) }}">
                                    <h3 class="voteCarDescText">{{ $car->nickauto }} {{ $car->make }} {!! $car->model !!}</h3>
                                </a>
                                <div class="voteButtonContainer">
                                    @if ( $vote->votedUser == 'yes' )
                                        <p class="vote"> You have voted today!</p>
                                    @else
                                        <button id="vote" class="btn btn-primary vote" data-carId="{{$car->id}}">Vote</button>
                                    @endif
                                </div>
                                 <p class=""><i id="carVotes" data-carvotes="{{ $car->vote }}">{{ $car->vote }}</i> from / <i id="carTotalVotes" class="carTotalVotes" data-totalvotes="{{  $vote->total }}">{{  $vote->total }}</i> total votes</p>

                            </div>
                         </div>
                        </div>
                    @endforeach
                </div>
                <div id="bottom-height" class="hidden"></div>
            </div>
            <!--/Row -->

        </div>

@endsection