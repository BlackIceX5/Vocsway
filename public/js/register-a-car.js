$(document).ready(function() {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	///// LOAD CARS MAKE
	var selector = $('#make');
	selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');
	
	$.ajax({
		
		url: '/loadCarsMake',
		type:'POST',
		dataType : 'json',
		data: {},
		success: function(data) {
			selector.append('<option  selected="selected" disabled="disabled">Select</option>')
			$.each( data.make, function( makes, values ) {
				$.each( values, function( make, value ) {
					
					selector.append('<option value="' + value + '">' + value + '</option>');
				});	
			});	
			
			selector.parent().find('.dbload').remove();
			
		}
	});
	

	
	///// LOAD CARS MODEL
	$('#make').on('change', function() {
		
		var selector = $('#model');
		selector.html('');
		$('#model').html('');
		$('#year').html('');
		$('#engine').html('');
		var make = $(this).val();
		selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');
		
		$.ajax({
			
			url: '/loadCarsModel',
			type:'POST',
			dataType : 'json',
			data: {
				make: make
			},
			success: function(data) {
				selector.append('<option  selected="selected" disabled="disabled">Select</option>')
				$.each( data.models, function( models, values ) {
					$.each( values, function( model, value ) {
						selector.append('<option value="' + value + '">' + value + '</option>');
					});	
				});	
				
				selector.parent().find('.dbload').remove();
				
			}
		});
	});
	
	///// LOAD CARS YEAR
	$('#model').on('change', function() {
		
		var selector = $('#year');
		selector.html('');
		$('#engine').html('');
		var make = $('#make').val();
		var model = $(this).val();
		
		selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');
		
		$.ajax({
			
			url: '/loadCarsYear',
			type:'POST',
			dataType : 'json',
			data: {
				make: make,
				model: model
			},
			success: function(data) {
				selector.append('<option  selected="selected" disabled="disabled">Select</option>')
				$.each( data.years, function( years, values ) {
					$.each( values, function( year, value ) {
						selector.append('<option value="' + value + '">' + value + '</option>');
					});	
				});	
				
				selector.parent().find('.dbload').remove();
				
			}
		});
	});
	
	///// LOAD CARS ENGINE
	$('#year').on('change', function() {
		
		var selector = $('#engine');
		selector.html('');
		var make = $('#make').val();
		var model = $('#model').val();
		var year = $(this).val();
		
		selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');
		
		$.ajax({
			
			url: '/loadCarsEngine',
			type:'POST',
			dataType : 'json',
			data: {
				make: make,
				model: model,
				year: year
			},
			success: function(data) {
				selector.append('<option  selected="selected" disabled="disabled">Select</option>')
				$.each( data.engines, function( engines, values ) {
					$.each( values, function( engine, value ) {
						selector.append('<option value="' + value + '">' + value + '</option>');
					});	
				});	
				
				selector.parent().find('.dbload').remove();
				
			}
		});
	});
	
	
	

		var $uploadCrop,
		tempFilename,
		rawImg,
		imageId,
		fileName,
		selector;
		function newCarReadFile(input) {
		 	if (input.files && input.files[0]) {
		            var reader = new FileReader();
		           reader.onload = function (e) {
					$('.newCarUpload-demo').addClass('ready');
					$('#newCarCropImagePop').modal('show');
		            rawImg = e.target.result;
		           }
		           reader.readAsDataURL(input.files[0]);
		       }
		       else {
		        alert("Sorry - you're browser doesn't support the FileReader API. Please use other for upload images");
		    }
		}
		
		
		if($( document ).width()<450){
			var width = $( document ).width()/100*79
		}
		else{
			var width = $( document ).width()/100*43
		}
		
	    var height = width/16*9
		
		$uploadCrop = $('#newCarUpload-demo').croppie({
			
			viewport: {
				width: width,
				height: height,
			},
			boundary: {
				width: width+20,
				height: (width+20)/16*9
			},
			enableExif: true
		});
		$('#newCarCropImagePop').on('shown.bs.modal', function(){
			// alert('Shown pop');
			$uploadCrop.croppie('bind', {
		      		url: rawImg
		      	}).then(function(){
		      		//console.log('jQuery bind complete');
		      	});
		});

		$(document).on('change', '.newCarItemIimg', function () { 
			imageId = $(this).data('id'); 
			tempFilename = $(this).val();
		
			$('#cancelCropBtn').data('id', imageId); 
			newCarReadFile(this); 
			selector = $(this).parent();
			fileName = $(this).val().split('/').pop().split('\\').pop();
			
			var parts = fileName.split(".");
			fileName = parts[0];
			selector.attr('id', fileName)
		});
		
		$('#newCarCropImageBtn').on('click', function (ev) {
			$uploadCrop.croppie('result', {
				type: 'base64',
				format: 'jpeg',
				size: {width: 1900, height: 1068}
			}).then(function (resp) {
				
				$('#newCarCropImagePop').modal('hide');
				
				selector.find('.hiddenLoad').fadeIn('slow')
				
				$.ajax({
					url: "/cropImage",
					type: "POST",
					data: {image:resp,name:fileName},
					async: true,
					xhr: function() {  // Custom XMLHttpRequest
						var myXhr = $.ajaxSettings.xhr();
						myXhr.upload.selector = selector;
						console.log(myXhr.upload.selector);	
							if(myXhr.upload){ // Check if upload property exists
								
								myXhr.upload.addEventListener('progress', function(e) {
									var proc = (e.loaded * 100/e.total)
									var procent = Math.round(proc)
									this.selector.find('.file').prop('disabled', true)
									this.selector.find("#progress-bar").css("width", ""+procent+"%")
									this.selector.find("#progress-bar").text(+procent+"%")
								}, false);
							}
						return myXhr;
					},
					beforeSend: function (data) {
						data.name = fileName
						$(document).find('#'+data.name).find('.progress').show()
						
					},
					complete: function (data) {	
						$(document).find('#'+data.name).find('.progress').hide()
						$(document).find('#'+data.name).find('.progress-bar').css("width", "0%")
						$(document).find('#'+data.name).find('.progress-bar').text("0%")
						
					},
					success: function (data) {
						$(document).find('#tempCont').append('<input class="inputHidden" type="hidden" id="'+data.name+'" value="'+data.path+'">')
						$(document).find('#'+data.name).find('.img-thumbnail').attr('src', data.path)
						$(document).find('#'+data.name).find('.hiddenLoad').fadeOut('slow')
					}
				});
				
			});
		});

		
		$(document).on('click', '#newCarAddFotoPreview', function () {
			var preview = '<li class="col-4 col-sm-3 previewHtml"><label class="cabinet center-block"><figure><div class="progress"><div id="progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div><div class="fa-3x hiddenLoad"><i class="fas fa-cog fa-spin"></i></div><img src="images/preview.png" class="gambar img-responsive img-thumbnail" id="newCarItemIimg-output" /><figcaption><i class="fa fa-camera"></i></figcaption></figure><input type="file"  class="newCarItemIimg file center-block" name="file_photo"/><span class="btn btn-primary deleteImage">Delete</span></li>'
			
			$('#imageCont').append(preview)
			
			var el = document.getElementById('imageCont');
			var sortable = Sortable.create(el, {animation: 150});
		});
	
		$(document).on('click', '.deleteImage', function (e) {
			e.preventDefault();
			var name = $(this).parent().attr('id')
			$(document).find('#tempCont').find('#'+name).detach()
			$(this).parent().parent().detach()
			
		});
		
		
		$(document).on('click', '#submitAddAuto', function (e) {
			var make = $('#make').val()
			var model = $('#model').val()
			var year = $('#year').val()
			var engine = $('#engine').val()
			var fuel = $('#fuel').val()
			var nickauto = $('#nickauto').val()
			var story = $('#story').val()
			
			var array = [];
			var x = document.getElementById("imageCont").querySelectorAll(".img-thumbnail"); 
			
			$.each( x, function( key, value ) {
				array.push(value.src)
			});

			var images = JSON.stringify(array);
			
			var errorContainer = $(document).find('.error_container');
		
			errorContainer.html('');
			
			if(errorContainer.hasClass('alert alert-danger')){
				errorContainer.removeClass('alert alert-danger');
			}
			if(errorContainer.hasClass('alert alert-success')){
				errorContainer.removeClass('alert alert-success');
			}
			
			$.ajax({
				url: '/saveCar',
				type:'POST',
				dataType : 'json',
				data: {
					make: make,
					model: model,
					year: year,
					engine: engine,
					fuel: fuel,
					nickauto: nickauto,
					story: story,
					images: images
				},
				success: function(data) {
					
					$('.nav-item-footer').fadeOut('slow');
					if(data.error){
						errorContainer.addClass('alert alert-danger');
						errorContainer.append(data.error);
					}else{
						 var loc = window.location;
						window.location = loc.protocol+"//"+loc.hostname+"/garage";
					}
				
					
				}
			});
		});
		
	
});