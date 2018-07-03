
$(document).ready(function() {		

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	// WEB SOCKET PUSH NOTIFICATION COUNT
		// Enable pusher logging - don't include this in production
		Pusher.logToConsole = true
		
		// USER CHANEL
		var user = $(document).find('#user_id').val()
		var pusher = new Pusher('4d2e3fce26ff9f2d5cfb', {
			cluster: 'eu',
			encrypted: true
		});
		
		var channel = pusher.subscribe('user-'+user)
		channel.bind('notifications', function(data) {
			
			$(document).find('#notificationIcon').text(' '+data['count'])
			$(document).find('#burger-circle').addClass('active-item')
			$(document).find('#notificationIcon').addClass('faa-ring animated')
			
			var pushContainer = $(document).find('.pushNotificationContainer')
			var timeOut
			
			
			
			pushContainer.html('')

			if(pushContainer.hasClass('visible')){
				timer(true)
			}
			else{
				pushContainer.addClass('visible')
				pushContainer.show('slow')
				timer(false)
			}
			
			pushContainer.append(data['link'])
			
			function timer (done = false) {
				if(done) {
					clearTimeout(timeOut);
					
				} else {
					timeOut = setTimeout( function(){				
						pushContainer.html('')
						pushContainer.hide('slow')
						pushContainer.removeClass('visible')
					} ,9999)
				}
			}   
		});
	
	
	//  ADD COMMENT
	$(document).on('click', '#saveComment', function(){
		var selector = $(this),
			comment = selector.parent().find('#commentArea').val(),
			post_id = selector.data('post_id'),
			user_id = selector.data('user_id'),
			user_name = selector.data('user_name'),
			post_owner_id = selector.data('post_owner_id'),
			child = selector.data('child'),
			source = selector.data('source'),
			car_id = selector.data('car_id')

		if(comment != ''){
			$.ajax({
				url: '/addComment',
				type:'POST',
				dataType : 'json',
				encode  : true,
				data: {
					comment: comment,
					post_id: post_id,
					post_owner_id: post_owner_id,
					child: child,
					car_id: car_id
				},
				success: function(data) {
					selector.parent().find('#commentArea').val('')
					//if(child != 0){
					//	selector.closest('.collapse').toggle('slow')
					//}
					
					//switch(source) {
					//	case 'comment':
					//		var html = $('#commentSemple').html()
					//		var newSource = 'child'
					//		$('.commentContainer').prepend('<div class="row commentBG new'+data.id+'">'+html+'</div>')
					//		$('.new'+data.id).find('.saveComment').attr('data-child', data.id)
					//		//$('.new'+data.id).find('.replyIcon').attr('data-target', '#reply'+data.id)
					//		//$('.new'+data.id).find('.replyIcon').attr('aria-controls', 'reply'+data.id)
					//		$('.new'+data.id).find('.dropdown-menu').attr('aria-labelledby', data.id)
					//		//$('.new'+data.id).find('.sampleDropdownIcon').attr('id', data.id)
					//		$('.new'+data.id).find('#deleteComment').attr('data-comment_id', data.id)
					//		$('.new'+data.id).find('.collapse').attr('id', 'reply'+data.id)
					//		$('.new'+data.id).find('.saveComment').attr('data-source', newSource)
					//		$('.new'+data.id).find('.saveComment').attr('data-post_id', post_id)
					//		$('.new'+data.id).find('.saveComment').attr('data-post_owner_id', post_owner_id)
					//		$('.new'+data.id).find('.saveComment').attr('data-user_name', user_name)
					//		$('.new'+data.id).find('.saveComment').attr('data-user_id', user_id)     
					//	break;
					//	
					//	case 'child':
					//		var html = $('#commentSemple').html()
					//		$(selector).closest('.commentBG').find('.replyCommentContainer').first().prepend('<div class="row commentReplyBG new'+data.id+'">'+html+'</div>')
					//		$('.new'+data.id).find('.saveComment').attr('data-child', data.id)
					//		$('.new'+data.id).find('.replyIcon').attr('data-target', '#reply'+data.id)
					//		$('.new'+data.id).find('.replyIcon').attr('aria-controls', 'reply'+data.id)
					//		$('.new'+data.id).find('.dropdown-menu').detach()
					//		$('.new'+data.id).find('.sampleDropdownIcon').detach()
					//		$('.new'+data.id).find('.commentText').parent().append('<i class="fas fa-trash commentMenu" id="removeChild" data-child_id="'+data.id+'"></i>')
					//	break;
                    //
					//	default:
					//		
					//}
					//$('.new'+data.id).find('.commentDate').text(data.date)
					//$('.new'+data.id).find('.commentUserName').text(user_name)
					//$('.new'+data.id).find('.commentText').html(comment)
				}
			});
		}
	});
	
	// HIDE MAIN COMMENT TEXTAREA WHEN REPLY
	$(document).on('click', '.replyButton', function(){
		var old = $(".collapse:visible")
		if ( old.length > 0){
			old.toggle('slow')
		}else{
			$('.mainCommentBox').toggle('slow')
		}

		$(this).closest('.dropleft').find('.collapse').toggle('slow')
	});
	
	// SHOW MAIN COMMENT WHEN CLOSE REPLY
	$(document).on('click', '.saveCommentReply', function(){
		$(this).closest('.collapse').toggle('slow')
		$('.mainCommentBox').toggle('slow')
	});
	
	// REMOVE COMMENT ( OWNER OR OWNER OF POST )
	$(document).on('click', '#deleteComment', function(){
		var selector = $(this),
			id = selector.data('comment_id')
			console.log(id)
		$.ajax({
			url: '/deleteComment',
			type:'POST',
			dataType : 'json',
			encode  : true,
			data: {
				id: id
			},
			success: function(data) {
				selector.closest('.commentBG').detach()
			}
		});
	});
	
	// REMOVE COMMENT CHILD ( OWNER OF CHILD OR OWNER OF POST )
	$(document).on('click', '#removeChild', function(){
		var selector = $(this),
			id = selector.data('child_id')
			console.log(id)
		$.ajax({
			url: '/deleteCommentChild',
			type:'POST',
			dataType : 'json',
			encode  : true,
			data: {
				id: id
			},
			success: function(data) {
				selector.closest('.commentReplyBG').detach()
			}
		});
	});
	
	// ADD LIKE FOR POST AND SHOW LIKES LIST
	$(document).on('click', '#addLike', function(){
		var selector = $(this),
			id = selector.data('id'),
			type = selector.data('type'),
			count = selector.data('count'),
			car_id = selector.data('car_id'),
			owner = selector.data('owner')
		if(selector.hasClass('justLiked')){
			//$('#likeList').collapse("toggle")
		}
		else{
			$.ajax({
				url: '/addLike',
				type:'POST',
				dataType : 'json',
				encode  : true,
				data: {
					item_id: id,
					type: type,
					car_id: car_id,
					owner: owner
				},
				success: function(data) {
					$(document).find('.likeDropdown').prepend('<a class="vocColor likeListItem capitalize" href="/user/'+selector.data('user_id')+'" data-type="page-transition">'+selector.data('user_name')+',  </a>')
					selector.addClass('justLiked')
					selector.text(' '+(count+1))
					selector.prepend('<i class="fas fa-thumbs-up"></i> ')
				}
			});
		}
	});
	
	
	// ADD LIKE FOR CAR AND SHOW LIKES LIST
	$(document).on('click', '#addCarLike', function(){
		var selector = $(this),
			id = selector.data('id'),
			type = selector.data('type'),
			count = selector.data('count'),
			owner = selector.data('owner')
		if(selector.hasClass('justLikedCar')){}
		else{
			$.ajax({
				url: '/addLike',
				type:'POST',
				dataType : 'json',
				encode  : true,
				data: {
					item_id: id,
					type: type,
					car_id: id,
					owner: owner
				},
				success: function(data) {
					$(document).find('.likeDropdown').prepend('<a class="vocColor likeListItem capitalize" href="/user/'+selector.data('user_id')+'" data-type="page-transition">'+selector.data('user_name')+',  </a>')
					selector.addClass('justLikedCar')
					selector.find('.newPostText').addClass('justLikedCar')
					selector.parent().parent().find('.likeBoxText').text(' '+(count+1))
					
					// GAUGE SCORE TO MAX END RETURN
					var score = $('#scoreGauge').data('value')
					var subscribers = $('#subsribersGauge').data('value')
					$('#scoreGauge').attr('data-value',  $('#scoreGauge').attr('data-max-value'))
					var scoreInterval = setInterval( function() {
						$('#scoreGauge').attr('data-value',  score)
						
					}, 1500);
					
					setInterval( function() {
						clearInterval(scoreInterval)
					}, 3500)
				}
			})
		}
	})
	
	// SUBSCRIBE TO CAR AND UNSUBSCRIBE
	$(document).on('click', '#subscribe', function(){
		var selector = $(this),
			id = selector.data('id'),
			count = selector.data('count'),
			owner = selector.data('owner')

			$.ajax({
				url: '/subscribe',
				type:'POST',
				dataType : 'json',
				encode  : true,
				data: {
					car_id: id,
					owner: owner
				},
				success: function(data) {
					if(selector.hasClass('justLikedCar')){
						selector.removeClass('justLikedCar')
						selector.find('.orange').removeClass('justLikedCar')
						selector.find('.editCarText').removeClass('justLikedCar')
						selector.find('.editCarText').text('Follow')
						$(document).find('.subscribersDropdown').find('#'+selector.data('user_id')).detach()
						$('#subsribersGauge').attr('data-value', 0)
					}
					else{
						selector.addClass('justLikedCar')
						selector.find('.orange').addClass('justLikedCar')
						selector.find('.editCarText').addClass('justLikedCar')
						selector.find('.editCarText').text('UnFollow')
						$(document).find('.subscribersDropdown').prepend('<a class="vocColor likeListItem capitalize" id="'+selector.data('user_id')+'" href="/user/'+selector.data('user_id')+'" data-type="page-transition">'+selector.data('user_name')+',  </a>')			
						$('#subsribersGauge').attr('data-value',  $('#subsribersGauge').attr('data-max-value'))
					}

					// GAUGE SCORE TO MAX END RETURN

					
					var subscribersInterval = setInterval( function() {
							$('#subsribersGauge').attr('data-value',  data.count)

					}, 1500)
					
					setInterval( function() {
						
						clearInterval(subscribersInterval)
					}, 3500)
				}
			})
		
	})
	
	///// DELETE POST
	
		$(document).on('click', '.deletePost', function () {
			post_id = $(this).parent().data('id')
			var title = $(this).parent().data('title')
			console.log('prepare to delete: '+title + 'id:'+post_id)
			
			$('#blackModalTitle').text('Delete Post')
			$('#blackModalBody').text('Are you sure want to delete '+title)
			$('#blackModal').modal('show')
		})
		
		$(document).on('click', '#blackModalYes', function () {
			var id = post_id
			console.log('deleted id:'+id)
			var errorContainer = $(document).find('.error_container')
			
			errorContainer.html('')
			if(errorContainer.hasClass('alert alert-danger')){
				errorContainer.removeClass('alert alert-danger')
			}
			if(errorContainer.hasClass('alert alert-success')){
				errorContainer.removeClass('alert alert-success')
			}
			
			$('#blackModal').modal('hide')
			$.ajax({
				url: '/deletePost',
				type:'POST',
				dataType : 'json',
				data: {    
					id :id,     
				},
				success: function(data) {
					if(data.error){
						errorContainer.addClass('alert alert-danger')
						errorContainer.append(data.error)
					}else{
						post_id = ''
						errorContainer.addClass('alert alert-success')
						errorContainer.append(data.success)
						$(document).find('#post-'+id).detach()
						window.setTimeout(function() {
							errorContainer.removeClass('alert alert-success')
							errorContainer.html('')
						}, 5000)
					}
				}
			})
		})
	
})