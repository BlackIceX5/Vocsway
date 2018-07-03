$(document).ready(function() {

	// EDIT USER DATA
    $(document).on('click','#submitEditUser', function(){
		
		var name = $('#name').val();
		var email = $('#email').val();
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
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: '/userUpdateData',
			type:'POST',
			dataType : 'json',
			encode  : true,
			data: {
				name: name,
				email: email,
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
	
	
	
	
});
