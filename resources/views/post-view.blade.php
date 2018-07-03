@extends('layouts.mainLayout')
@section('title')
	{{ $post->title }}
@endsection
@section('content')
<!-- Hero Section -->
    <div id="hero">
        <div id="hero-styles" class="opacity-onscroll">
            <div id="hero-caption">
                <div class="inner">
                    <h2 class="hero-title">{{ $post->make }} {{ $post->model }}</h2>
					<p class="hero-title">{{ $post->nickname}}</p>
                    <input type="hidden" id="post_id" value="{{ $post->id }}"> 
					<input type="hidden" id="user_id" value="{{ Auth::id() }}">     					
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
            
				<div class="container text-left">
                
					<h4 class="title-has-line capitalize">{!! $post->title !!}</h4>
					

					<div class="form-group row has-animation"  data-delay="0">
						
						{!! $post->content !!}
							
						@foreach($postImages as $postImage)
							<p><img class="img-thumbnail postImage" src="{{ $postImage->path }}" alt="{!! $post->make !!} {!! $post->model !!}"></p>
						@endforeach
						<div class="col-12 text-right" >
							<div class="">
								<i class="text-left">{!! $post->date !!}</i>	
							</div>
						</div>
					</div>
				</div>
            
			</div>
			<!--/Row -->
			
			<!-- Row -->
			<div class="vc_row has-animation"  data-delay="100">
            
				<div class="container text-left">

					<div class="form-group row endLine" >
						<div class="col-4 afterPostInfo text-left">
							<b class="noMobile">Category:</b>
							<i class="text-right">{!! $post->category !!}</i>
						</div>
						<div class="col-4 afterPostInfo text-center">
							@if($post->km != '')
							<b  class="noMobile">Mileage:</b>
							<i class="text-center">{!! $post->km !!}</i>
							@endif
						</div>
						<div class="col-4 afterPostInfo text-right">
							@if($post->price != '')
							<b  class="noMobile">Price:</b>
							<i class="text-left">{!! $post->price !!}</i>
							@endif
						</div>
					</div>
					
				</div>
            
			</div>
			<!--/Row -->
			
			<!-- Row -->
			<div class="vc_row has-animation zindex5"  data-delay="100">
				
				<div class="container">
					<div class="form-group row float-right">
						<div class="fa-2x pointer block text-right dropleft marginR1">
						
							<span id="showVisits" class="badge badge-info " data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-eye"></i>
								{{ count($visits) }}
							</span>
							
							<div class="dropdown-menu" aria-labelledby="showVisits">
								@forelse($visits as $visit)
									<a class="vocColor likeListItem capitalize " href="{{ route('user-profile', ['id'=>$visit->user_id]) }}" data-type="page-transition"> {{ $visit->user_name}},  </a>
								@empty
									
								@endforelse
							</div>
						</div>
						<div class="fa-2x pointer block text-right dropleft">
							@if ($like->owner == 1)
								@php $likeClass = 'justLiked'; @endphp
							@else
								@php $likeClass = ''; @endphp
							@endif
							<span id="addLike" class="badge badge-info {{ $likeClass }} addLike" data-toggle="dropdown"  aria-haspopup="false" aria-expanded="false" data-car_id="{{ $post->car_id }}" data-type="post" data-id="{{ $post->id }}" data-user_name="{{ Auth::user()->name }}" data-owner="{{ $post->user_id }}" data-count="{{ count($like) }}" >
								<i class="fas fa-thumbs-up"></i>
								{{ count($like) }}
							</span>
							
							<div class="dropdown-menu likeDropdown" aria-labelledby="addLike">
								@forelse($like as $likeItem)
									<a class="vocColor likeListItem capitalize " href="{{ route('user-profile', ['id'=>$likeItem->user_id]) }}" data-type="page-transition"> {{ $likeItem->user_name}},  </a>
								@empty
									
								@endforelse
							</div>
						</div>	
							
						</div>
					</div>
				</div>	

			</div>
			<!--/Row -->
			@if(file_exists('images/users/' . Auth::user()->id  . '.jpg')) 
				@php ($avatar = asset('images/users/' . Auth::user()->id  . 'Full.jpg?nocache='.time()))
			@else
				@php ($avatar = asset('images/users/user-loged.png'))
			@endif
			<!-- Row -->
			<div class="vc_row  has-animation"  data-delay="100">
				<div class="container">
					<h4 class="title-has-line capitalize">Comments</h4>
				</div>
				<div class="blackContainer mainCommentBox">	
					
					<div class="form-group row ">
						<div class="col-4 col-md-2 zindex1">
							<img class="img-thumbnail black-logo zindex1" src="{{ $avatar }}" alt="">
						</div>
						
						<div class="col-8 col-md-10">
							<div class="commentBorderR">
								<span class="badge badge-info saveComment pointer" id="saveComment" data-source="comment" data-child="0" data-car_id="{{ $post->car_id }}" data-post_id="{{ $post->id }}" data-post_owner_id="{{ $post->user_id }}" data-user_name="{{ Auth::user()->name }}" data-user_id="{{ Auth::id() }}">
									<i class="fas fa-angle-right verticalText"></i>
								</span>
								<textarea id="commentArea"  class="commentArea" placeholder="Leave your comment"></textarea>
							</div>
							
						</div>
					</div>
				</div>	
			</div>	
			<!-- Row -->
			<div class="vc_row row_padding_bottom has-animation"  data-delay="100">	
				<div class="container commentContainer">
					
					@foreach ($comments as $comment)
						@if(file_exists('images/users/' . $comment->user_id  . '.jpg')) 
							@php ($avatarCom = asset('images/users/' . $comment->user_id  . '.jpg?nocache='.time()))
						@else
							@php ($avatarCom = asset('images/users/user-loged.png'))
						@endif
						<!-- MAIN COMMENT --> 
						<div class="row commentBG comment{{ $comment->id }}">
						
							<!-- USER IMAGE AND NAME --> 
							<div class="col-2 col-md-1 padding0">
								<img class="card-img-top" src="{{ $avatarCom }}" alt="Card image cap">
								<p class="commentUserName">{{ $comment->user_name }}</p>
							</div>
							
							<!-- COMMENT TEXT --> 
							<div class="col-10 col-md-11 dropleft">
								
								<span class="commentText capitalize">{!! $comment->comment !!}</span>
								<p class="vocColor commentText fullWidth text-right paddingR1">{!! $comment->date !!}</p>
								<!-- DROPDOWN REPLY AND DELETE BUTTONS --> 
								<i class="far fa-caret-square-down commentMenu" id="{!! $comment->id !!}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
								<div class="dropdown-menu" aria-labelledby="{!! $comment->id !!}">
									<a class="vocColor dropdown-item replyButton" data-toggle="collapse" aria-expanded="false" >Reply</a>
									@if($post->user_id == Auth::id())
										<a id="deleteComment" data-comment_id="{{ $comment->id }}" class="vocColor dropdown-item" >Delete</a>
									@else
										@if( $comment->user_id == Auth::id())
											<a id="deleteComment" data-comment_id="{{ $comment->id }}" class="vocColor dropdown-item" >Delete</a>
										@endif
									@endif
								</div>
								
								<!-- REPLY COLAPSED --> 
								<div class="collapse" id="reply{!! $comment->id !!}">
									<div class="form-group row ">
										<div class="col-4 col-md-2 zindex1">
											<img class="img-thumbnail black-logo zindex1" src="{{ $avatar }}" alt="">
										</div>
										
										<div class="col-8 col-md-10">
											<div class="commentBorderR">
												<span class="badge badge-info saveComment pointer saveCommentReply" id="saveComment" data-source="child" data-child="{{ $comment->id }}" data-car_id="{{ $post->car_id }}"  data-post_id="{{ $post->id }}" data-post_owner_id="{{ $post->user_id }}" data-user_name="{{ Auth::user()->name }}" data-user_id="{{ Auth::id() }}">
													<i class="fas fa-angle-right verticalText"></i>
												</span>
												<textarea id="commentArea"  class="commentArea" placeholder="Leave your comment"></textarea>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-2 col-md-1 padding0">
							</div>
							<div class="col-10 col-md-11 reply replyCommentContainer">
								<!-- COMMENT CHILDS --> 
								@foreach ($comment->childs as $child)
									@if(file_exists('images/users/' . $child->user_id  . '.jpg')) 
										@php ($childAvatar = asset('images/users/' . $child->user_id  . '.jpg?nocache='.time()))
									@else
										@php ($childAvatar = asset('images/users/user-loged.png'))
									@endif
									
									<div class="row commentReplyBG dropleft">
						
										<!-- CHILD USER IMAGE AND NAME --> 
										<div class="col-2 col-md-1 padding0">
											<img class="card-img-top" src="{{ $childAvatar }}" alt="Card image cap">
											<p class="commentUserName">{{ $child->user_name }}</p>
										</div>

										<!-- CHILD COMMENT TEXT --> 
										<div class="col-10 col-md-11 reply">
											<span class="commentText capitalize">{!! $child->comment !!}</span>
											<p class="vocColor commentText fullWidth text-right paddingR1">{!! Carbon\Carbon::createFromTimeStamp(strtotime($child->date))->diffForHumans()  !!}</p>
											<!-- DROPDOWN FOR CHILD  DELETE BUTTON --> 

											@if($post->user_id == Auth::id())
												<i class="fas fa-trash commentMenu" id="removeChild" data-child_id="{{ $child->id }}"></i>
											@else
												@if( $child->user_id == Auth::id())
													<i class="fas fa-trash commentMenu" id="removeChild" data-child_id="{{ $child->id }}"></i>
												@endif
											@endif
											
										</div>
										
										
										
									</div>
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<!--/Row -->
		<!--/Main Page Content -->           
		</div>
    <!--/Main Content --> 
	</div>	
	
	@if(file_exists('images/users/' . Auth::user()->id  . '.jpg')) 
		@php ($avatarSample = asset('images/users/' . Auth::user()->id  . 'Full.jpg?nocache='.time()))
	@else
		@php ($avatarSample = asset('images/users/user-loged.png'))
	@endif
	
<div id="commentSemple" class="hiddenComment">
							
		<!-- USER IMAGE AND NAME --> 
		<div class="col-2 col-md-1 padding0">
			<img class="card-img-top" src="" alt="Card image cap">
			<p class="commentUserName"></p>
		</div>
		
		
		
		<!-- COMMENT TEX --> 
		<div class="col-10 col-md-11 dropleft">
			<span class="commentText capitalize"></span>
			<p class="vocColor  fullWidth text-right paddingR1 commentDate"></p>
			<!-- DROPDOWN REPLY AND DELETE BUTTONS --> 
			<i  class="far fa-caret-square-down commentMenu sampleDropdownIcon" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
			<div class="dropdown-menu" aria-labelledby="">
				<a class="vocColor dropdown-item replyIcon replyButton" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="">Reply</a>
				<a id="deleteComment" data-comment_id="" class="vocColor dropdown-item" >Delete</a>
			</div>
			
			<!-- REPLY COLAPSED --> 
			<div class="collapse" id="">
				<div class="form-group row ">
					<div class="col-4 col-md-2 zindex1">
						<img class="img-thumbnail black-logo zindex1" src="{{ $avatarSample }}" alt="">
					</div>
					
					<div class="col-8 col-md-10">
						<div class="commentBorderR">
							<span class="badge badge-info saveComment pointer saveCommentReply" id="saveComment" data-source="" data-child="" data-car_id="{{ $post->car_id }}"  data-post_id="" data-post_owner_id="" data-user_name="" data-user_id="">
								<i class="fas fa-angle-right verticalText"></i>
							</span>
							<textarea id="commentArea"  class="commentArea" placeholder="Leave your comment"></textarea>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-2 col-md-1 padding0">
		</div>
		<div class="col-10 col-md-11 reply replyCommentContainer">
		</div>
</div>

@endsection