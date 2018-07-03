@extends('layouts.mainLayout')
@section('title')
	Edit User Profile
@endsection
@section('content')
<!-- Hero Section -->
    <div id="hero">
        <div id="hero-styles" class="opacity-onscroll">
            <div id="hero-caption">
                <div class="inner">
                    <h2 class="hero-title">User Profile</h2>
					<p class="hero-title">Settings</p>
                                            
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
			<div class="vc_row small text-align-center row_padding_top row_padding_bottom has-animation"  data-delay="100">

				<div class="container">				
					<div class="form-group row" id="avatarContainer">
						
						<div class="col-md-12 text-center">
							@if(file_exists('images/users/' . Auth::user()->id  . '.jpg')) 
						
								@php ($avatar = asset('images/users/' . Auth::user()->id  . 'Full.jpg?nocache='.time()))
							
							@else
								
								@php ($avatar = asset('images/users/user-loged.png'))
								
							@endif
							
							<div class="avatar">
								<label class="cabinet center-block">
									<figure>
										<div class="progress" style="display: none;">
											<div id="progress-bar" class="progress-bar bg-info black-logo" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
												0%
											</div>
										</div>
										<div class="fa-3x hiddenLoad" style="display: none;">
											<i class="fas fa-cog fa-spin"></i>
										</div>
										<img src="{{ $avatar }}" class="gambar img-responsive img-thumbnail black-logo" id="item-img-output" />
										<input type="hidden" id="tempAvatarImage" value="">
									<figcaption style="padding-left: 47%;"><i class="fa fa-camera"></i></figcaption>
								</figure>
									<input type="file" class="item-img file center-block" name="file_photo"/>
								</label>
							</div>
							
		
						</div>
		
						<div class="col-md-12 text-center">
							<button type="button" id="saveAvatarImage" class="btn btn-primary">
								Save Avatar
							</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
		
					</div>



					<form  method="POST" id="userData">
						@csrf
						
		
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
		
							<div class="col-md-6">
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}"  required autofocus>
		
								@if ($errors->has('name'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>
		
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
		
							<div class="col-md-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required>
		
								@if ($errors->has('email'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						<div class="form-group row">
							<label for="location" class="col-md-4 col-form-label text-md-right"> Country <span class="label_description"></span></label>
					
							<div class="col-md-6">
								<select id="location" type="text" class="form-control" name="location" required autofocus>
									<option  value="{{ Auth::user()->location }}"  selected="selected"  >{{ Auth::user()->location }}</option>
								</select>
							</div>
							
						</div>
						
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
		
							<div class="col-md-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
		
								@if ($errors->has('password'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>
		
						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>
		
							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
							</div>
						</div>
						
						<div class="form-group row ">
							<div class="col-md-8 text-md-right" id="editUserError">
								
							</div>
							<div class="col-md-2 text-center">
								<button type="button" id="submitEditUser" class="btn btn-primary float-right" data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}">
									Save
								</button>
		
							</div>
						</div>
					</form>
			</div>		
		</div>
	</div> 
</div>  
 
<!-- Modal -->

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	  		 <div id="upload-demo" class="center-block fullWidth"></div>
	  	</div>
	  </div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
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
<script src="{{ asset('js/pageWithOverflow.js') }}"></script>
@endsection