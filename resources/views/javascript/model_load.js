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
	
				$.each( data.engines, function( engines, values ) {
					$.each( values, function( engine, value ) {
						selector.append('<option value="' + value + '">' + value + '</option>');
					});	
				});	
				
				selector.parent().find('.dbload').remove();
				
			}
		});
	});
	
	
	
	$(document).find(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
		var $uploadCrop,
		tempFilename,
		rawImg,
		imageId,
		selector;
		function readFile(input) {
		 	if (input.files && input.files[0]) {
		            var reader = new FileReader();
		           reader.onload = function (e) {
					$('.upload-demo').addClass('ready');
					$('#cropImagePop').modal('show');
		            rawImg = e.target.result;
		           }
		           reader.readAsDataURL(input.files[0]);
		       }
		       else {
		        alert("Sorry - you're browser doesn't support the FileReader API");
		    }
		}

		$uploadCrop = $('#upload-demo').croppie({
			viewport: {
				width: 300,
				height: 168,
			},
			boundary: {
				width: 320,
				height: 180
			},
			enableExif: true
		});
		$('#cropImagePop').on('shown.bs.modal', function(){
			// alert('Shown pop');
			$uploadCrop.croppie('bind', {
		      		url: rawImg
		      	}).then(function(){
		      		console.log('jQuery bind complete');
		      	});
		});

		$('.item-img').on('change', function () { 
			imageId = $(this).data('id'); 
			tempFilename = $(this).val();
		
			$('#cancelCropBtn').data('id', imageId); 
			readFile(this); 
			selector = $(this).parent();
		});
		
		$('#cropImageBtn').on('click', function (ev) {
			$uploadCrop.croppie('result', {
				type: 'base64',
				format: 'jpeg',
				size: {width: 200, height: 112}
			}).then(function (resp) {
				selector.find('#item-img-output').attr('src', resp);
				$('#cropImagePop').modal('hide');
			});
		});
				// End upload preview image
	
	
	
	
	
	//$uploadCrop = $('#upload-demo').croppie({
	//	viewport: {
	//		width: 300,
	//		height: 168,
	//		type: 'square'
	//	},
	//	boundary: {
	//		width: 320,
	//		height: 180
	//	},
	//	enableExif: true
	//});
    //
	//$('#upload').on('change', function (e) { 
	//	const files = e.currentTarget.files;
	//	Object.keys(files).forEach(i => {
	//		const file = files[i];
	//		const reader = new FileReader();
	//		var selector =  files[i].name.split('.', 1)[0];
	//		var image = new Image();
	//		image.height = 112;
	//		image.width = 200;
	//		image.title = file.name;
	//		image.setAttribute('class', 'img-thumbnail');
	//		
	//		reader.onload = (e) => {
	//			image.src = e.target.result;
	//			$('#viewContainer').append('<div class="col-md-3 padding" id="'+selector+'" style="width:200px">');
	//			$('#'+selector).append( image );
	//			$('#'+selector).append(' <button type="button" id="showCropModal" data-toggle="modal" data-target="#cropModal" class="btn btn-primary showCropModal" >Crop image</button> ')
	//		}
    //
	//		reader.readAsDataURL(file);
    //
	//	})
	//	
	//	
	//});
	//
	//$(document).on('click', '.showCropModal', function () {
	//	var selector = $(this).parent()
	//	var name = $(this).parent().attr('id')
	//	var url = selector.find('.img-thumbnail').attr('src')
    //
	//	$uploadCrop.croppie('bind', {
	// 	url: url
	//	})
	//});
	//
    //
	//
	//$(document).on('click', '#saveCrop', function (ev) {
	//	$uploadCrop.croppie('result', {
	//		size: 'viewport',
	//		type: 'base64',
	//		format: 'jpeg',
	//		
	//	}).then(function (resp) {
	//		$.ajax({
	//			url: "/cropImage",
	//			type: "POST",
	//			data: {"image":resp},
	//			success: function (data) {
	//				console.log(resp)
	//				html = '<img src="' + resp + '" />';
	//				$("#viewContainer").html(html);
	//			}
	//		});
	//	});
	//});

});