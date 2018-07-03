@extends('layouts.mainLayout')
@section('title')
	Edit {{ $car->nickauto }}
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<div class="section light-content ">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default Ymiddle">
				<div class="card-mod card-body YmiddleChild" >
						
					<div class="form-group row">
						<label for="editMake" class="col-md-4 col-form-label text-md-right"> Make <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="editMake" type="text" class="form-control" name="editMake" required autofocus>
								<option  value="{{ $car->make }}"  selected="selected"  >{{ $car->make }}</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="editModel" class="col-md-4 col-form-label text-md-right"> Model <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="editModel" type="text" class="form-control" name="editModel" required autofocus>
								<option  value="{{ $car->model }}"  selected="selected"  >{{ $car->model }}</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="editYear" class="col-md-4 col-form-label text-md-right"> Year <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="editYear" type="text" class="form-control" name="editYear" required autofocus>
								<option  value="{{ $car->year }}"  selected="selected"  >{{ $car->year }}</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="editEngine" class="col-md-4 col-form-label text-md-right"> Engine <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="editEngine" type="text" class="form-control" name="editEngine" required autofocus>
								<option  value="{{ $car->engine }}"  selected="selected"  >{{ $car->engine }}</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="editFuel" class="col-md-4 col-form-label text-md-right"> Fuel Type <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="editFuel" type="text" class="form-control" name="editFuel" required autofocus>
								<option  value="{{ $car->fuel }}"  selected="selected"  >{{ $car->fuel }}</option>
								<option value="Diesel">Diesel</option>
								<option value="Petrol">Petrol</option>
								<option value="Hybrid">Hybrid</option>
								<option value="Electric ">Electric </option>
							</select>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>	

<div class="section light-content  ">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default">
				<div  class="card-mod card-body">
					<label id="editCarAddFotoPreview" class="col-md-12 col-form-label text-center"> Upload images of your Car <span class="label_description">Ratio 16:9 full HD</span>
						<figcaption class="black">
							<div class="fa-2x">
								<i  class="fas fa-plus"></i>
							</div>	
						</figcaption>
					</label>
					
					<ul id="editCarimageCont" class="row marginY">
					
						@foreach ($carImages as $image)
							<li class="col-4 col-sm-3 previewHtml" draggable="true">
								<label class="cabinet center-block" id="{{ $image->name }}">
									<figure>
										<div class="progress" style="display: none;">
											<div id="progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
												0%
											</div>
										</div>
										<div class="fa-3x hiddenLoad" style="display: none;">
											<i class="fas fa-cog fa-spin"></i>
										</div>
										<img src="{{ $image->path }}" class="gambar img-responsive img-thumbnail" id="editCarItem-img-output">
										<figcaption>
											<i class="fa fa-camera"></i>
										</figcaption>
									</figure>
										<input type="file" class="editCarItem-img file center-block" name="file_photo" disabled="">
										<span class="btn btn-primary deleteImage editCarDeleteImage">Delete</span>
								</label>
							</li>
						@endforeach

					</ul>	
				</div>	
			</div>		
		</div>
	</div>
</div>
	
<div class="section light-content ">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default Ymiddle">
				<div class="card-mod card-body YmiddleChild">

					<div class="form-group row">
						<label for="nickauto" class="col-md-4 col-form-label text-md-right"> Nickname <span class="label_description">of your car</span></label>
			
						<div class="col-md-6">
							<input id="nickauto" type="text" class="form-control" name="nickauto" placeholder="BlackSaphire"  value="{{ $car->nickauto }}">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="story" class="col-md-4 col-form-label text-md-right"> Description <span class="label_description">story of your car</span></label>
			
						<div class="col-md-6">
							<textarea id="story" type="text" rows="7" class="form-control" name="story" placeholder="Min 100 letters"  required autofocus>{{ $car->story }}</textarea>
						</div>
					</div>

					<div class="form-group row ">
						<div class="col-md-10 text-md-right" id="editUserError">
				
							<button type="button" id="submitEditAuto" class="btn btn-primary float-right upload-result" data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}">
								Save
							</button>
			
						</div>
					</div>

				</div>	
			</div>	
		</div>	
	</div>	
</div>
  
            </div>
        </div>    

<!-- Modal -->
<div class="modal fade" id="editCarCropImagePop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	  		 <div id="editCarupload-demo" class="center-block fullWidth"></div>
	  	</div>
	  </div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="editCarCropImageBtn" class="btn btn-primary">Crop</button>
      </div>
    </div>
  </div>
</div>

<div id="car_id" data-car_id="{{ $car->id }}">
</div>

@endsection

@section('page-nav')
	<section class="nav-item-footer">
		<div id="scroll_page" class="page-item-footer">
			
			<p class="page-item up" id="fp-viewing">----------</p>
			<p class="page-item " id="fp-viewing-1">Car Info</p>
			<p class="page-item down" id="fp-viewing-2">Car Images</p>
			<p class="page-item down" id="fp-viewing-3">User Data</p>
			<p class="page-item down" id="fp-viewing">----------</p>
			
		</div>
	</section>
	<div id="error_container " class="error_container">
	
	</div>

@endsection

@section('scripts')







@endsection