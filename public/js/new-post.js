$(document).ready(function() {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var $uploadCrop,
	tempFilename,
	rawImg,
	imageId,
	fileName,
	selector;
	function newPostReadFile(input) {
	 	if (input.files && input.files[0]) {
	            var reader = new FileReader();
	           reader.onload = function (e) {
				$('.newPostUpload-demo').addClass('ready');
				$('#newPostCropImagePop').modal('show');
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
	
	$uploadCrop = $('#newPostUpload-demo').croppie({
		
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
	$('#newPostCropImagePop').on('shown.bs.modal', function(){
		// alert('Shown pop');
		$uploadCrop.croppie('bind', {
	      		url: rawImg
	      	}).then(function(){
	      		//console.log('jQuery bind complete');
	      	});
	});

	$(document).on('change', '.newPostItem-img', function () { 
		imageId = $(this).data('id'); 
		tempFilename = $(this).val();
	
		$('#cancelCropBtn').data('id', imageId); 
		newPostReadFile(this); 
		selector = $(this).parent();
		fileName = $(this).val().split('/').pop().split('\\').pop();
		
		var parts = fileName.split(".");
		fileName = parts[0];
		

		selector.attr('id', fileName)

	});
	
	$('#newPostCropImageBtn').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'base64',
			format: 'jpeg',
			size: {width: 1900, height: 1068}
		}).then(function (resp) {
			
			$('#newPostCropImagePop').modal('hide');
			
			selector.find('.hiddenLoad').fadeIn('slow')
			
			$.ajax({
				url: "/cropPostImage",
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
					$(document).find('#'+data.name).find('.insertImage').attr('data-src', data.path)
					$(document).find('#'+data.name).find('.insertImage').prop('disabled', false)
					$(document).find('#'+data.name).find('.img-thumbnail').attr('src', data.path)
					$(document).find('#'+data.name).find('.hiddenLoad').fadeOut('slow')
				}
			});
			
		});
	});
	
	
	$(document).on('click', '#newPostAddFotoPreview', function () {
		var preview = '<li class="col-4 col-sm-3 previewHtml"><label class="cabinet center-block"><figure><div class="progress"><div id="progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div><div class="fa-3x hiddenLoad"><i class="fas fa-cog fa-spin"></i></div><img src="/images/preview.png" class="gambar img-responsive img-thumbnail" id="newPostItem-img-output" /><figcaption><i class="fa fa-camera"></i></figcaption></figure><input type="file" class="newPostItem-img file center-block" name="file_photo"/><button type="button" class="btn btn-primary addPostInsertImage insertImage" data-src="" disabled="true">Insert</button><button type="button"  class="btn btn-danger newPostDeleteImage deleteImage">Delete</button></li>'
		
		$('#imageCont').append(preview)
		
		var el = document.getElementById('imageCont');
		var sortable = Sortable.create(el, {animation: 150});
	});
	
	$(document).on('click', '.newPostDeleteImage', function (e) {
		e.preventDefault();
		var name = $(this).parent().attr('id')
		$(document).find('#tempCont').find('#'+name).detach()
		$(this).parent().parent().detach()
		
	});
	
	
	$(document).on('click', '#submitAddPost', function () {
		var button    = $(this)
		var make      =  button.data('make')
		var model     = button.data('model')
		var year      = button.data('year')
		var car_id    = button.data('car_id')
		var location  = button.data('location')
		var category  = $('#category').val()
		var title     = $('#title').val()
		var content   = $('#content').val()
		var price     = $('#price').val()+' :'+$('#price_type').val()
		var km        = $('#km').val()+' '+$('#km_type').val()
		var string
		
		if($('#price').val() == ''){
			price = ''
		}
		
		if($('#km').val() == ''){
			km = ''
		}
		
		var array = [];
		var x = document.getElementById("imageCont").querySelectorAll(".img-thumbnail"); 
		
		$.each( x, function( key, value ) {
			if(value.src == 'https://vocsway.com/images/preview.png'){
				$(this).parent().parent().detach()
			}
			else{
				string = value.src.replace("Small", "Full");
				array.push(string)
			}
			
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
			url: '/savePost',
			type:'POST',
			dataType : 'json',
			data: {    
				make :make,     
				model :model,   
				year :year,     
				car_id :car_id,   
				country :location, 
				category :category, 
				title :title,    
				content :content,  
				price :price,    
				km :km,
				images: array
			},
			success: function(data) {
				
				$('.nav-item-footer').fadeOut('slow');
				if(data.error){
					errorContainer.addClass('alert alert-danger');
					errorContainer.append(data.error);
				}else{
					 var loc = window.location;
					window.location = loc.protocol+"//"+loc.hostname+"/carProfile/"+car_id;
				}
			
				
			}
		});
	});
	
	// INSERT VIDEO
	$(document).on("click", '#addPostVideo', function() {
		$('#videoModal').modal('show')
	})
	
	
	$(document).on("click", '#addPostInsertModalVideo', function() {
		var type = $('#videoType').val()
		var videoId = $('#videoIdModal').val()
		var string = ''
		
		console.log(type + videoId)
		if (videoId == ''){
			alert('Please copy video ID')
		}
		else{
			if(type == 'youtube'){
				string = '<iframe class="postVideo" src="https://www.youtube.com/embed/'+ videoId +'"></iframe>'
				newPostTypeInTextarea($('#content'), string)
				return false
			}
			else if(type == 'vimeo'){
				string = '<iframe class="postVideo" src="https://player.vimeo.com/video/'+ videoId +'"></iframe>'
				newPostTypeInTextarea($('#content'), string)
				return false
			}
			else{
				alert('Video type undefined')
			}
		}
	})
	
	$(document).on("click", '.addPostInsertImage', function() {
		var make      =  $(document).find('#submitAddPost').data('make')
		var model     = $(document).find('#submitAddPost').data('model')
		var image = $(this).data('src')
		var string = '\n <p><img class="img-thumbnail postImage" src="'+image+'" alt="'+make+' '+model+'"></p>\n'
		string = string.replace("Small", "Full");
		newPostTypeInTextarea($('#content'), string)
		return false
	})
	
	$(document).on("click", '#addPostBold', function() {
		newPostTypeInTextarea($('#content'), '<b> !!! Your bold text here !!!</b>')
		return false
	})
	
	$(document).on("click", '#addPostItalic', function() {
		newPostTypeInTextarea($('#content'), '<i> !!! Your italic text here !!!</i>')
		return false
	})
	
	$(document).on("click", '#addPostStrike', function() {
		newPostTypeInTextarea($('#content'), '<ol> !!! Your strikeout text here !!!</ol>')
		return false
	})
	
	$(document).on("click", '#addPostAdd_car_link', function() {
		$('#linkModal').find('#labelIdModal').text('Car ID (Get from this car page)')
		$('#linkModal').find('#hiddenLinkdModal').val('CAR')
		$('#linkModal').modal('show')
	})
	
	$(document).on("click", '#addPostAdd_post_link', function() {
		$('#linkModal').find('#labelIdModal').text('Post ID (Get from this Post page)')
		$('#linkModal').find('#hiddenLinkdModal').val('POST')
		$('#linkModal').modal('show')
	})
	
	$(document).on("click", '#addPostAdd_user_link', function() {
		$('#linkModal').find('#labelIdModal').text('User ID (Get from this User profile)')
		$('#linkModal').find('#hiddenLinkdModal').val('USER')
		//$('#linkModal').modal('show')
		$('#linkModal').modal('toggle')
	})
	
	$(document).on("click", '#addPostInsertModalLink', function() {
		var id = $('#linkModal').find('#linkIdModal').val()
		var name = $('#linkModal').find('#linkNameModal').val()
		var type = $('#linkModal').find('#hiddenLinkdModal').val()
		
		if(id == ''){alert('ID is required')}
		else if(name == ''){alert('Name is required')}
		else{

			if(type == 'CAR'){
				newPostTypeInTextarea($('#content'), '<a class="postLink" href="https://vocsway.com/carProfile/'+id+'">'+name+'</a>')
				return false
			}
			
			if(type == 'USER'){
				newPostTypeInTextarea($('#content'), '<a class="postLink" href="https://vocsway.com/user/'+id+'">'+name+'</a>')
				return false
			}
			
			if(type == 'POST'){
				newPostTypeInTextarea($('#content'), '<a class="postLink" href="https://vocsway.com/post/'+id+'">'+name+'</a>')
				return false
			}
			
			$('#linkModal').modal('toggle')
		
		}
	})
	
	
	function newPostTypeInTextarea(el, newText) {
		var start = el.prop("selectionStart")
		var end = el.prop("selectionEnd")
		var text = el.val()
		var before = text.substring(0, start)
		var after  = text.substring(end, text.length)
		el.val(before + newText + after)
		el[0].selectionStart = el[0].selectionEnd = start + newText.length
		el.focus()
		return false
	}
});