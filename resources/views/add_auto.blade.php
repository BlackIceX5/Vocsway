@extends('layouts.mainLayout')
@section('title')
	New Car
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<div class="section light-content ">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-default Ymiddle">
				<div class="card-mod card-body YmiddleChild">
						
					<div class="form-group row">
						<label for="make" class="col-md-4 col-form-label text-md-right"> Make <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="make" type="text" class="form-control" name="make" required autofocus>
								<option  selected="selected" disabled="disabled">Select</option>
							</select>
						</div>
						
					</div> 
					
					<div class="form-group row">
						<label for="model" class="col-md-4 col-form-label text-md-right"> Model <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="model" type="text" class="form-control" name="model" required autofocus>
								<option  selected="selected" disabled="disabled">Select</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="year" class="col-md-4 col-form-label text-md-right"> Year <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="year" type="text" class="form-control" name="year" required autofocus>
								<option  selected="selected" disabled="disabled">Select</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="engine" class="col-md-4 col-form-label text-md-right"> Engine <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="engine" type="text" class="form-control" name="engine" required autofocus>
								<option  selected="selected" disabled="disabled">Select</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group row">
						<label for="fuel" class="col-md-4 col-form-label text-md-right"> Fuel Type <span class="label_description"></span></label>
				
						<div class="col-md-6">
							<select id="fuel" type="text" class="form-control" name="fuel" required autofocus>
								<option  selected="selected" disabled="disabled">Select</option>
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
					<label id="newCarAddFotoPreview" class="col-md-12 col-form-label text-center"> Upload images of your Car <span class="label_description">Ratio 16:9 full HD</span>
						<figcaption class="black">
							<div class="fa-2x">
								<i  class="fas fa-plus"></i>
							</div>	
						</figcaption>
					</label>
					
					<ul id="imageCont" class="row marginY">

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
								<input id="nickauto" type="text" class="form-control" name="nickauto" placeholder="BlackSaphire"  required autofocus>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="story" class="col-md-4 col-form-label text-md-right"> Description <span class="label_description">story of your car</span></label>
				
							<div class="col-md-6">
								<textarea id="story" type="text" rows="7" class="form-control" name="story" placeholder="Min 100 letters"  required autofocus></textarea>
							</div>
						</div>
	
						<div class="form-group row ">
							<div class="col-md-10 text-md-right" id="editUserError">
					
								<button type="button" id="submitAddAuto" class="btn btn-primary float-right upload-result" data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}">
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
<div class="modal fade" id="newCarCropImagePop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	  		 <div id="newCarUpload-demo" class="center-block fullWidth"></div>
	  	</div>
	  </div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" id="newCarCropImageBtn" class="btn btn-primary">Crop</button>
      </div>
    </div>
  </div>
</div>

<div id="tempCont">
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