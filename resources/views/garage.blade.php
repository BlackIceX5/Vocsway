@extends('layouts.mainLayout')
@section('title')
	Garage
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
	@forelse ($cars as $car)
		<!-- Section Slide -->
			<div class="section light-content">
				
				<div class="img-mask">
					<a  data-type="page-transition"  href="{{ route('car.profile', ['id'=>$car->id]) }}">
						<div class="img-perspective">
							<div class="img-split">
								<div class="section-image" {!! $car->path !!}></div>
								<div class="section-image-mirror"></div>                        
							</div>
						</div>
					</a>
				</div>
										
				<div class="section-shadow"></div>
				
				<div class="section-caption-outer">
					<div class="section-caption-inner">
						<h2 class="section-title sa-one">{{ $car->make }} {{ $car->model }}</h2>
						<p class="section-subtitle sa-two">{{ $car->nickauto}}</p>
					</div>
				</div>
				
			</div>
		<!--/Section Slide -->		
	@empty	
		<!-- Section Slide -->
			<div class="section text-align-center">
				
				<p class="smaller sa-one">Empty</p>
				<h2 class="sa-two">You don't have register <br class="destroy">any car yet</h2>
				
				<hr>
				
				<div class="sa-three">
					<a href="{{ route('add.auto') }}"  class="clapat-button rounded outline ajax-link"  ><span>Register a Car</span></a>
				</div>    
				
			</div>
		<!--/Section Slide -->		
	@endforelse

    
</div>    			
</div>

@endsection

@section('page-nav')
	<section class="nav-item-footer">
		<div id="scroll_page" class="page-item-footer">
			
			<p class="page-item up" id="fp-viewing">----------</p>
			@php $i = 0 @endphp
			@forelse ($cars as $car)
				@if ($i == 0) 
					<p class="page-item active" id="fp-viewing-{{ $i+1 }}"> {{ $car->nickauto }} </p>
					@php $i++ @endphp
				@else
					<p class="page-item down" id="fp-viewing-{{ $i+1 }}"> {{ $car->nickauto }} </p>
					@php $i++ @endphp
				@endif
			@empty
				<p class="page-item up active" id="fp-viewing-1"> Empty </p>
			@endforelse
			<p class="page-item down" id="fp-viewing">----------</p>
			
		</div>
	</section>
	<div id="error_container " class="error_container">
	
	</div>

@endsection

@section('scripts')
@endsection		