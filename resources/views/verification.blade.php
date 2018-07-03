@extends('layouts.mainLayout')
@section('title')
    Verification
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
	<!-- Section Slide -->
    <div class="section text-align-center last-slide">
        
        <p class="smaller sa-one">Registration.</p>
        <h2 class="sa-two">You have successfully registered.  </h2>
		<h2 class="sa-two">An email is sent to you for verification. </h2>
        
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