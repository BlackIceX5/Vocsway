@extends('layouts.mainLayout')
@section('title')
    Please Login
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
	<!-- Section Slide -->
    <div class="section text-align-center last-slide">
        
        <p class="smaller sa-one">Error</p>
        <h2 class="sa-two">{{ $error }}</h2>
		<h2 class="sa-two">{{ $error1 }}</h2>
        
        <hr>
        
        <div class="sa-three">
            <a href=""{{url('')}}"" class="clapat-button rounded outline ajax-link" data-type="page-transition" ><span>Home</span></a>
        </div>    
        
    </div>
    <!--/Section Slide -->	   
        
        <div class="section-caption-outer">
            <div class="section-caption-inner">
                <h2 class="section-title sa-one"></h2>
                <p class="section-subtitle sa-two"></p>
            </div>
        </div>
        
    </div>
    <!--/Section Slide -->	

            </div>
        </div>    




@endsection