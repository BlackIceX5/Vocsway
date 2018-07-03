@extends('layouts.mainLayout')
@section('title')
	{{ $car->make }}  {{ $car->model }}
@endsection
@section('content')

    <div id="main">

        <!-- Hero Section -->
        <div id="hero" class="has-image">
            <div id="hero-styles" class="opacity-onscroll parallax-onscroll">
                <div id="hero-caption">
                    <div class="inner">
                        <h1 class="hero-title">{{ $car->nickauto }}</h1>
                        <p class="hero-subtitle">{{ $car->make }}  {{ $car->model }}</p>                        
                    </div>
                </div>
                <div class="scroll-down-wrap no-border">
                    <a href="#" class="section-down-arrow ">
					<svg class="nectar-scroll-icon" viewBox="0 0 30 45" enable-background="new 0 0 30 45">
						<path class="nectar-scroll-icon-path" fill="none" stroke="#ffffff" stroke-width="2" stroke-miterlimit="10" d="M15,1.118c12.352,0,13.967,12.88,13.967,12.88v18.76  c0,0-1.514,11.204-13.967,11.204S0.931,32.966,0.931,32.966V14.05C0.931,14.05,2.648,1.118,15,1.118z">
						</path>
                    </svg>
                    </a>
                </div>
            </div>
        </div>
        <div id="hero-bg-wrapper">
			<div id="hero-bg-image" class="light-content" data-index="0"  {!! $imgString !!} ></div>
			</div> 
			<img class="none" id="none" src="">
        <div id="hero-height" class="hidden"></div>                
        
        
        <!--/Hero Section -->
        
        
        <!-- Main Content -->
        <div id="main-content">
        	<div id="main-page-content">               
            
				<!-- Row -->
				<div class="vc_row small row_padding_top row_padding_bottom data-delay="300"">
					
					<div class="container">
						<h4 class="title-has-line has-animation" data-delay="10">{!!$car->nickauto!!}</h4>  
						<div class="row text-left">
							
							<div class="col-7 col-md-9 text-right">
								<h5 class="has-animation" data-delay="10">{!!$car->make!!} {!!$car->model!!}</h5>                        
								<p class="has-animation" data-delay="40">Model year {!!$car->year!!} </p> 
								<p class="has-animation" data-delay="40">Engine {!!$car->engine!!} {!!$car->fuel!!}</p> 
								<p class="has-animation d-none d-sm-block" data-delay="40">On VocsWay {!!$car->date!!}</p>							
							</div>
							<div class="col-5 col-md-3">
								<img class="img-thumbnail has-animation shadow" alt="car logo" src="/images/cars-logo/{!!$car->make!!}.png">
							</div>
						</div>	
					</div>
					
				</div>
				<!--/Row -->
			
			
            
            <!-- Row -->
            <div id="blackSection" class="vc_row blackSection has-animation" data-delay="600">

					<div class="row text-left">
						<input type="hidden" id="subscribersCount" value="{{ count($car->subscribers)+1 }}">
						<div class="col-6 text-center zindex1 pointer">
							<canvas id ="subsribersGauge" data-type="radial-gauge" 
							data-width="300" 
							data-height="300" 
							data-units="Subscribers" 
							data-title="false" 
							data-min-value="0" 
							data-max-value="8000" 
							data-value="{{ count($car->subscribers)+1 }}" 
							data-value-dec="0"
							data-animate-on-init="true" 
							data-major-ticks="0,1000,2000,3000,4000,5000,6000,7000,8000" 
							data-minor-ticks="2" data-stroke-ticks="true" 
							data-highlights="[{&quot;from&quot;: 7000, &quot;to&quot;: 8000, &quot;color&quot;: &quot;rgba(200, 50, 50, .75)&quot;}]" 
							data-color-plate="#38383800" 
							data-color-major-ticks="#f5f5f5" 
							data-color-minor-ticks="#ddd" 
							data-color-title="#fff" 
							data-color-units="#ccc" 
							data-color-numbers="#eee" 
							data-color-needle-start="rgba(240, 128, 128, 1)" 
							data-color-needle-end="rgba(255, 160, 122, .9)" 
							data-value-box="true" 
							data-font-value="Repetition" 
							data-font-numbers="Repetition"
							data-animated-value="true" 
							data-borders="false" 
							data-border-shadow-width="0" 
							data-needle-type="arrow"
							data-needle-width="2" 
							data-needle-circle-size="7" 
							data-needle-circle-outer="true" 
							data-needle-circle-inner="false" 
							data-animation-duration="1000" 
							data-animation-rule="linear" 
							data-ticks-angle="250" 
							data-start-angle="55" 
							data-color-needle-shadow-down="#333" 
							data-value-box-width="45"
							width="300" 
							height="300" 
							style="width: 400px; height: 400px; visibility: visible;"
							data-toggle="dropdown"  aria-haspopup="false" aria-expanded="false">
							</canvas>
							<div class="dropdown-menu subscribersDropdown subscribersDropdownOwner" aria-labelledby="subsribersGauge">
								@forelse($car->subscribers as $subscribersItem)
									<a class="vocColor likeListItem capitalize " id="{{ $subscribersItem->user_id }}" href="{{ route('user-profile', ['id'=>$subscribersItem->user_id]) }}" data-type="page-transition"> {{ $subscribersItem->user_name}},  </a>
								@empty
									
								@endforelse
							</div>
						</div>	

						<div class="col-6 text-center zindex1">
							<canvas id ="scoreGauge" data-type="radial-gauge" 
							data-width="300" 
							data-height="300" 
							data-units="Score" 
							data-title="false" 
							data-min-value="0" 
							data-max-value="330" 
							data-value="{{ $car->score }}" 
							data-value-dec="0"
							data-animate-on-init="true" 
							data-major-ticks="0,30,60,90,120,150,180,210,240,270,300,330" 
							data-minor-ticks="2" data-stroke-ticks="true" 
							data-highlights="[{&quot;from&quot;: 270, &quot;to&quot;: 330, &quot;color&quot;: &quot;rgba(200, 50, 50, .75)&quot;}]" 
							data-color-plate="#38383800" 
							data-color-major-ticks="#f5f5f5" 
							data-color-minor-ticks="#ddd" 
							data-color-title="#fff" 
							data-color-units="#ccc" 
							data-color-numbers="#eee" 
							data-color-needle-start="rgba(240, 128, 128, 1)" 
							data-color-needle-end="rgba(255, 160, 122, .9)" 
							data-value-box="true" 
							data-font-value="Repetition" 
							data-font-numbers="Repetition"
							data-animated-value="true" 
							data-borders="false" 
							data-border-shadow-width="0" 
							data-needle-type="arrow"
							data-needle-width="2" 
							data-needle-circle-size="7" 
							data-needle-circle-outer="true" 
							data-needle-circle-inner="false" 
							data-animation-duration="1000" 
							data-animation-rule="linear" 
							data-ticks-angle="250" 
							data-start-angle="55" 
							data-color-needle-shadow-down="#333" 
							data-value-box-width="45"
							width="300" 
							height="300" 
							style="width: 400px; height: 400px; visibility: visible;">
							</canvas>
						</div>
					
						<img class="stripes" src="/images/stripes.png">
						
						@if ( $car->justLiked == 0 ) @php $liked = ''; @endphp
						@else @php $liked = 'justLikedCar'; @endphp
						@endif
						
						@if ( $car->justSubscribed == 0 ) @php $subscribed = ''; $buttonSubs = 'Follow'; @endphp
						@else @php $subscribed = 'justLikedCar'; $buttonSubs = 'UnFollow'; @endphp
						@endif
						
						<div class="postBox">
							<label class="postBoxLabel">Posts:</label>
							<p class="postBoxText">{{ count($posts) }}</p>
						</div>
						<div class="likeBox">
							<label class="likeBoxLabel">Likes:</label>
							<p class="likeBoxText" >{{ count($car->likes) }}</p>
						</div>
						
						<div class="dropleft">
							<a class="editCarBox {{ $subscribed }}"   id="subscribe" data-id="{{ $car->id }}" data-user_name="{{ Auth::user()->name }}" data-owner="{{ $car->user_id }}" data-user_id="{{ Auth::id() }}" data-count="{{ count($car->subscribers) }}">
								<div class="fa-2x pointer orange {{ $subscribed }}">
									<i class="fas fa-road"></i>
								</div>
								<p class="editCarText {{ $subscribed }}">{{ $buttonSubs }}</p>
							</a>
							
						</div>
						
						<div class="dropleft">
							<a class="newPostBox {{ $liked }}" id="addCarLike" data-toggle="dropdown"  aria-haspopup="false" aria-expanded="false" data-type="car" data-id="{{ $car->id }}" data-user_name="{{ Auth::user()->name }}" data-owner="{{ $car->user_id }}" data-count="{{ count($car->likes) }}">
								<div class="fa-2x pointer orange {{ $liked }}">
									<i class="fas fa-thumbs-up"></i>
								</div>
								<p class="newPostText {{ $liked }}">Like</p>
							</a>
							<div class="dropdown-menu likeDropdown" aria-labelledby="addCarLike">
								@forelse($car->likes as $likeItem)
									<a class="vocColor likeListItem capitalize " href="{{ route('user-profile', ['id'=>$likeItem->user_id]) }}" data-type="page-transition"> {{ $likeItem->user_name}},  </a>
								@empty
									
								@endforelse
							</div>
						</div>

					</div>

            </div>
            <!--/Row -->

            <!-- Row -->
            <div class="vc_row small row_padding_top  has-animation" data-delay="900">
                
                <div class="container">
                    
                    <h4 class="title-has-line" >Description</h4>                        
                    
                    <p >{!!nl2br($car->story) !!}</p>              
                    
                </div>
                
            </div>
            <!--/Row -->
            
            <!-- Row -->
            <div class="vc_row full row_padding_top has-animation carouselBox"  data-delay="1200">
                
                <div class="container light-content">
                   
                    <div class="carousel">
						@foreach ($carImages as $carImage)
							<div class="slide"><a href="{{ $carImage->full }}" class="image-link"><img src="{{ $carImage->path }}" alt="{{ $car->make }} {{ $car->model }} Images"></a></div>
                        @endforeach 
                    </div>
                    
                </div>
                
            </div>
            <!--/Row -->              

            
			
			<!-- Row -->
            <div class="vc_row  row_padding_top row_padding_bottom has-animation" data-delay="1500">
                
                <div class="blackContainer">
                    <h4 class="title-has-line" >
						Posts {{ $posts->count() }} 
						
					</h4>
                    @foreach ($posts as $post)
						
						<div class="row marginBottom3 align-item-center" id="post-{{ $post->id }}">	
							
							<div class="col-3 padingLR1 fullHeight">
								<a href="{{ route('post', ['id'=>$post->id]) }}" data-type="page-transition">
									<img class="img-thumbnail" src="{{ $post->main_img }}" >
								</a>
							</div>
							
							<div class="col-6 padingLR1 fullHeight">
								<h5 class="miniPostTitle capitalize">
									<a href="{{ route('post', ['id'=>$post->id]) }}" data-type="page-transition" class="cropText capitalize">{{ $post->title }}</a>
									<p class="miniPostPTitle">{{ $post->category }}</p>
								</h5>
								<p class="miniPostPTitle">
									<span class="postInfo"><i class="fas fa-eye"></i> {{ $post->visits}} </span>
									<span class="postInfo"><i class="fas fa-thumbs-up"></i> {{ $post->likes }} </span>
									<span class="postInfo"><i class="fas fa-comments"></i> {{ $post->comments }} </span>
								</p>
							</div>
							
							<div class="col-3 align-self-end padingLR1 text-right dropup fullHeight">
								<p class="miniPostP">
									{{ $post->date }} 
								</p>
								
							</div>
							
						</div>
					@endforeach         
                    
                </div>
                
            </div>
            <!--/Row -->
			
			
			        
            </div>
            <!--/Main Page Content -->     
        </div>
        <!--/Main Content --> 
		
		
			
    </div>
<!--/Main --> 	

		
<!-- Modal -->
<div class="modal fade" id="blackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="blackModalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  <div class="row">
	  	<div class="col-md-12 text-center">
	  		 <div id="blackModalBody" class="center-block fullWidth"></div>
	  	</div>
	  </div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="blackModalYes" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('page-nav')
	<section class="nav-item-footer">
		<div id="scroll_page" class="page-item-footer">
			
			<p class="page-item up" id="fp-viewing">----------</p>
			
					<p class="page-item active" id="fp-viewing-1"> sdf </p>
				
					<p class="page-item down" id="fp-viewing-2"> we </p>
				
			
		
			<p class="page-item down" id="fp-viewing">----------</p>
			
		</div>
	</section>
	<div id="error_container " class="error_container">
	
	</div>

@endsection

@section('scripts')

@endsection	