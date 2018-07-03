@extends('layouts.mainLayout')
@section('title')
	Edit {{ $post->title }}
@endsection
@section('content')
<!-- Hero Section -->
    <div id="hero">
        <div id="hero-styles" class="opacity-onscroll">
            <div id="hero-caption">
                <div class="inner">
                    <h2 class="hero-title">{{ $car->nickauto }}</h2>
					<p class="hero-title">{{ $car->make }} {{ $car->model }}</p>
                                            
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
			<div class="vc_row small text-align-center row_padding_top has-animation"  data-delay="100">
            
				<div class="container">
                
					<h4>Post Edit</h4>
					<p>Your location set to {{ Auth::user()->location }}.
					For change this go to  
						<a class="menu-link" href="https://vocsway.com/user">
							User Profile
						</a>
					</p>
               
                
					<!-- FORM -->
					
					<div class="form-group row has-animation"  data-delay="0">
						<label for="category" class="col-md-4 col-form-label text-left text-md-right">Category<span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="category" type="text" class="form-control" name="category" required autofocus>
								<option  value="{{ $post->category }}"  selected="selected"  >{{ $post->category }}</option>
								<option  value="Accessories">Accessories</option>
								<option  value="Tax">Tax</option>
								<option  value="Suspension">Suspension</option>
								<option  value="Wheels & Tires">Wheels & Tires</option>
								<option  value="Trips">Trips</option>
								<option  value="Foto">Foto</option>
								<option  value="Service">Service</option>
								<option  value="Tuning">Tuning</option>
								<option  value="CarAudio">CarAudio</option>
								<option  value="Styling">Styling</option>
								<option  value="Remarks">Remarks</option>
								<option  value="Crash">Crash</option>
								<option  value="Parts">Parts</option>
								<option  value="Body">Body</option>
								<option  value="Washing">Washing</option>
								<option  value="Adjusted by Me">Adjusted by Me</option>
								<option  value="Meetings">Meetings</option>
								<option  value="Events">Events</option>
								<option  value="Other">Other</option>
							</select>
						</div>
					</div>	
					
					<div class="form-group row has-animation"  data-delay="300">
						<label for="title" class="col-md-4 col-form-label text-left text-md-right">Title</label>
		
						<div class="col-md-6">
							<input id="title" type="text" class="form-control" name="title" placeholder="New Springs" value="{{ $post->title }}">
						</div>
					</div>
						
					<div class="form-group row has-animation"  data-delay="600">
						<label for="km" class="col-md-4 col-form-label text-left text-md-right">Mileage</label>
		
						<div class="col-md-4">
							<input id="km" type="text" class="form-control" name="km" placeholder="133000" value="{{ $post->km }}">
						</div>
						<div class="col-md-2">
							<select id="km_type" type="text" class="form-control" name="km_type" required autofocus>
								<option  value="{{ $post->km_type }}" selected="selected">{{ $post->km_type }}</option>
								<option  value="mi" >mi</option>
								<option  value="km">km</option>
							</select>
						</div>
					</div>

					<div class="form-group row has-animation"  data-delay="900">
						<label for="price" class="col-md-4 col-form-label text-left text-md-right">Price <span class="label_description"> if exist </span></label>
		
						<div class="col-md-4">
							<input id="price" type="text" class="form-control" name="price" placeholder="270" value="{{ $post->price }}">
						</div>
						<div class="col-md-2">
							<select id="price_type" type="text" class="form-control" name="price_type" required autofocus>
								<option  value="{{ $post->price_type }}" selected="selected">{{ $post->price_type }}</option>
								<option  value="$">$</option>
								<option  value="&euro;">&euro;</option>
								<option  value="£">£</option>
							</select>
						</div>
					</div>					
						
					<div class="form-group row has-animation"  data-delay="1200">
						<label for="content" class="col-md-12 col-form-label text-center"> Content <span class="label_description">for insert image to your post: click + on bottom of the page and then click button insert in text</span></label>
						<div class="col-md-12 text-center">
							<div class="fa-2x dropup">
								<i id="link" class="fas fa-link margin1 pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
								<i id="editPostVideo" class="fas fa-video margin1 pointer" data-toggle="tooltip" data-placement="top" title="VIDEO"></i>
								<i id="editPostBold" class="fas fa-bold margin1 pointer" data-toggle="tooltip" data-placement="top" title="Bold Text"></i>
								<i id="editPostItalic" class="fas fa-italic margin1 pointer" data-toggle="tooltip" data-placement="top" title="Italic Text"></i>
								<i id="editPostStrike" class="fas fa-strikethrough margin1 pointer" data-toggle="tooltip" data-placement="top" title="StrikeOut Text"></i>
								
								<div class="dropdown-menu" >
									<a  id="editPostAdd_car_link" class="vocColor dropdown-item pointer" >
										Car Link
										<i class="fas fa-car editPost pointer"></i>
									</a>
									<a id="editPostAdd_post_link" class="vocColor dropdown-item pointer ">
										Post Link
										<i class="far fa-file-alt  pointer" ></i>
									</a>
									<a  id="editPostAdd_user_link" class="vocColor dropdown-item pointer ">
										User Link
										<i class="fas fa-user  pointer" ></i>
									</a>
								</div>
								
							</div>
						</div>
						<div class="col-md-12">
							<textarea id="content" type="text" rows="13" class="form-control" name="content" placeholder="Your post here.... "  required autofocus>
								{!! $post->content !!}
							</textarea>
						</div>
					</div>
					
					<div class="form-group row has-animation"  data-delay="1500">
						<label id="editPostAddFotoPreview" class="col-md-12 col-form-label text-center"> Upload images for your Post <span class="label_description">Ratio 16:9 full HD and then click Isert in Text</span>
							<figcaption class="black">
								<div class="fa-2x">
									<i  class="fas fa-plus"></i>
								</div>	
							</figcaption>
						</label>
						
						<ul id="imageCont" class="row marginY full-width">
							@foreach ($postImages as $postImage)
								<li class="col-4 col-sm-3 previewHtml">
									<label class="cabinet center-block">
										<figure>
											<div class="progress">
												<div id="progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
											<div class="fa-3x hiddenLoad">
												<i class="fas fa-cog fa-spin"></i>
											</div>
											<img src="{{ $postImage->pathS }}" class="gambar img-responsive img-thumbnail" id="editPostItem-img-output" />
											<figcaption>
												<i class="fa fa-camera"></i>
											</figcaption>
										</figure>
									<input type="file" class="editPostItem-img file center-block" name="file_photo"/>
									<button type="button" class="btn btn-primary insertImage" data-src="{{ $postImage->path }}" >Insert</button>
									<button type="button"  class="btn btn-danger editPostDeleteImage deleteImage">Delete</button>
								</li>
							@endforeach
						</ul>	
					</div>
					
					<div class="form-group row has-animation"  data-delay="1800">
						<div class="col-md-10 text-md-right" >
				
							<button type="button" id="submitEditPost" class="btn btn-primary float-right upload-result" data-post_id="{{ $post->id }}" data-make="{{ $car->make }}" data-model="{{  $car->model }}" data-year="{{  $car->year }}" data-location="{{  Auth::user()->location }}" data-car_id="{{  $car->id }}">
								Save
							</button>
			
						</div>
					</div>
					<!--/FORM -->
                
					<hr><hr>
                
				</div>
            
			</div>
			<!--/Row -->
         
        </div>
        <!--/Main Page Content -->           
    </div>
    <!--/Main Content --> 

<!-- Modal -->
<div class="modal fade" id="editPostCropImagePop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropModalTitle">Crop Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  <div class="row">
	  	<div class="col-md-12 text-center">
	  		 <div id="editPostUpload-demo" class="center-block fullWidth"></div>
	  	</div>
	  </div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="editPostCropImageBtn" class="btn btn-primary">Crop</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal LINK -->
<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropModalTitle">Insert Link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		</div>
		<div class="modal-body">
				
			<div class="form-group row"  data-delay="300">
				<label for="linkNameModal" id="labelNameModal" class="col-md-4 col-form-label text-left text-md-right">Link name (visible in your future post)</label>
			
				<div class="col-md-6">
					<input id="linkNameModal" type="text" class="form-control" name="title" value="">
				</div>
			</div>
			
			<div class="form-group row"  data-delay="300">
				<label for="linkIdModal" id="labelIdModal" class="col-md-4 col-form-label text-left text-md-right"></label>
			
				<div class="col-md-6">
					<input id="linkIdModal" type="text" class="form-control" name="title" value="">
				</div>
			</div>
			<input type="hidden" id="hiddenLinkdModal" value="">
			
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="editPostInsertModalLink" data-dismiss="modal" class="btn btn-primary">Insert</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal VIDEO-->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalTitle">Insert Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		</div>
		<div class="modal-body">
				
			<div class="form-group row has-animation"  data-delay="0">
				<label for="videoType" class="col-md-12 col-form-label text-left ">Embed video from:<span class="label_description"></span></label>
			
				<div class="col-md-12">
					<select id="videoType" type="text" class="form-control" name="videoType" required autofocus>
						<option  value="youtube"  selected="selected">Youtube</option>
						<option  value="vimeo"   >Vimeo</option>
					</select>
				</div>
			</div>	
			
			<div class="form-group row"  data-delay="300">
				<label for="videoIdModal" id="labelVideoIdModal" class="col-md-12 col-form-label text-left ">Insert video * ID only<p >Example: youtube.com/watch?v=************  Or Vimeo vimeo.com/********** </p></label>
			
				<div class="col-md-12">
					<input id="videoIdModal" type="text" class="form-control" name="title" value="" placeholder="pGqPjYALB50">
				</div>
			</div>
			<input type="hidden" id="hiddenVideoModal" value="">
			
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="editPostInsertModalVideo" data-dismiss="modal" class="btn btn-primary">Insert</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-nav')

	<div id="error_container " class="error_container">
	
	</div>

@endsection

@section('scripts')

@endsection