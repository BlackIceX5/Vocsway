$(document).ready(function() {
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	//// HIDE NAV ITEMS FOR PAGE SCROLL
	$(document).find('.menu-info').hide()
	$(document).find('.error_container').css('height', '3%')
	$(document).find('.copyright').hide()
	$(document).find('footer').hide()
	
	///// LOAD COUNTRY
	var selector = $('#location');
	selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');
	
	$.ajax({
		
		url: '/loadCountry',
		type:'POST',
		dataType : 'json',
		data: {},
		success: function(data) {
			
			
			$.each( data.countries, function( countries, values ) {
				$.each( values, function( country, value ) {
					selector.append('<option value="' + value + '">' + value + '</option>');
				});	
			});	
			
			selector.parent().find('.dbload').remove();
			
		}
	});
	
	
	
	// EDIT USER DATA
    $(document).on('click','#submitEditUser', function(){
		
		var name = $('#name').val();
		var email = $('#email').val();
		var location = $('#location').val();
		var password = $('#password').val();
		var password_conf = $('#password-confirm').val();
		var errorContainer = $(document).find('.error_container');
		
		errorContainer.html('');
		
		if(errorContainer.hasClass('alert alert-danger')){
			errorContainer.removeClass('alert alert-danger');
		}
		if(errorContainer.hasClass('alert alert-success')){
			errorContainer.removeClass('alert alert-success');
		}

		if (name == $(this).data('name')){
			name = '';
		}
		
		if (email == $(this).data('email')){
			email = '';
		}
		
		$.ajax({
			url: '/userUpdateData',
			type:'POST',
			dataType : 'json',
			encode  : true,
			data: {
				name: name,
				email: email,
				location: location,
				password: password,
				password_confirm: password_conf
			},
			success: function(data) {
				$('.nav-item-footer').fadeOut('slow');
				if(data.error){
					errorContainer.addClass('alert alert-danger');
					errorContainer.append(data.error);
				}else{
					errorContainer.addClass('alert alert-success')
					errorContainer.append(data.success);
					setTimeout(function(){
						errorContainer.removeClass('alert alert-success');
						errorContainer.html('');
						$('.nav-item-footer').fadeIn('slow');
					} , 3000 );	  
					
					
				}
			}
		});
		
    });
	
	
	// Start upload preview image
	
	var $uploadCrop,
	tempFilename,
	rawImg,
	imageId;
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
	        swal("Sorry - you're browser doesn't support the FileReader API");
	    }
	}
	
	if($( document ).width()<450){
		var width = $( document ).width()/100*79
	}
	else{
		var width = $( document ).width()/100*43
	}
	
	   var height = width/16*9
	
	$uploadCrop = $('#upload-demo').croppie({
		
		viewport: {
			width: width,
			height: width
			
		},
		boundary: {
			width: width+20,
			height: width+20
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
		imageId = $(this).data('id'); tempFilename = $(this).val();
		$('#cancelCropBtn').data('id', imageId); readFile(this); 
	});
	
	$('#cropImageBtn').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'base64',
			format: 'jpeg',
			size: {width: 333, height: 333}
		}).then(function (resp) {
			$('#item-img-output').attr('src', resp);
			$('#tempAvatarImage').val(resp);
			$('#cropImagePop').modal('hide');
		});
	});
	
	$(document).on('click', '#saveAvatarImage', function (e) {
		var image = $('#tempAvatarImage').val()
		var selector = $('#avatarContainer')
		var errorContainer = $(document).find('.error_container');
		
		errorContainer.html('');
		
		if(errorContainer.hasClass('alert alert-danger')){
			errorContainer.removeClass('alert alert-danger');
		}
		if(errorContainer.hasClass('alert alert-success')){
			errorContainer.removeClass('alert alert-success');
		}

		if (name == $(this).data('name')){
			name = '';
		}
		
		if (email == $(this).data('email')){
			email = '';
		}
		
		$.ajax({
			url: "/userUpdateAvatar",
			type: "POST",
			data: {
				image:image
			},
			async: true,
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				myXhr.upload.selector = selector;
				console.log(myXhr.upload.selector);	
					if(myXhr.upload){ // Check if upload property exists
						
						myXhr.upload.addEventListener('progress', function(e) {
							var proc = (e.loaded * 100/e.total)
							var procent = Math.round(proc)
							//this.selector.find('.file').prop('disabled', true)
							this.selector.find("#progress-bar").css("width", ""+procent+"%")
							this.selector.find("#progress-bar").text(+procent+"%")
						}, false);
					}
				return myXhr;
			},
			beforeSend: function (data) {
				selector.find('.progress').show()
				
			},
			complete: function (data) {	
				selector.find('.progress').hide()
				selector.find('.progress-bar').css("width", "0%")
				selector.find('.progress-bar').text("0%")
				
			},
			success: function (data) {
				selector.find('.hiddenLoad').fadeOut('slow')
				$('.nav-item-footer').fadeOut('slow');
				$('.black-logo').attr('src', image);
				errorContainer.addClass('alert alert-success')
				errorContainer.append(data.success);
				setTimeout(function(){
					errorContainer.removeClass('alert alert-success');
					errorContainer.html('');
					$('.nav-item-footer').fadeIn('slow');
				} , 5000 );	  
			}
		});
	
	});
	
});
