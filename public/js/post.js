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
	
	// WEB SOCKET
	// Enable pusher logging - don't include this in production
	Pusher.logToConsole = true;
	
	// COMMENTS CHANNEL
	var post = $(document).find('#post_id').val()
	var user = $(document).find('#user_id').val()
	var pusher = new Pusher('716b119f930a79f15fc2', {
		cluster: 'eu',
		encrypted: true
	});
	
	var channel = pusher.subscribe('post-'+post);
		channel.bind('comments', function(data) {
		
			switch(data.child) {
				
			case 0:
				var html = $('#commentSemple').html()
				var newSource = 'child'
				$('.commentContainer').prepend('<div class="row commentBG new'+data.id+'">'+html+'</div>')
				$('.new'+data.id).toggle()
				$('.new'+data.id).find('.saveComment').attr('data-child', data.id)
				$('.new'+data.id).find('.dropdown-menu').attr('aria-labelledby', data.id)
				$('.new'+data.id).find('#deleteComment').attr('data-comment_id', data.id)
				$('.new'+data.id).find('.collapse').attr('id', 'reply'+data.id)
				$('.new'+data.id).find('.saveComment').attr('data-source', newSource)
				$('.new'+data.id).find('.saveComment').attr('data-post_id', data.post_id)
				$('.new'+data.id).find('.saveComment').attr('data-post_owner_id', data.owner)
				$('.new'+data.id).find('.saveComment').attr('data-user_name', data.user_name)
				$('.new'+data.id).find('.saveComment').attr('data-user_id', data.user_id)   
				if ( data.user_id != user){
					$('.new'+data.id).find('#deleteComment').detach()
				}			
			break;
			
			default:
				var html = $('#commentSemple').html()
				var selector = $(document).find('.comment'+data.child)
				if( selector.length == 0 ) {
					selector = $(document).find('.new'+data.child)
				}
				selector.find('.replyCommentContainer').first().prepend('<div class="row commentReplyBG new'+data.id+'">'+html+'</div>')
				$('.new'+data.id).toggle()
				$('.new'+data.id).find('.saveComment').attr('data-child',data.id)
				$('.new'+data.id).find('.replyIcon').attr('data-target', '#reply'+data.id)
				$('.new'+data.id).find('.replyIcon').attr('aria-controls', 'reply'+data.id)
				$('.new'+data.id).find('.dropdown-menu').detach()
				$('.new'+data.id).find('.sampleDropdownIcon').detach()
				if ( data.user_id == user){
					$('.new'+data.id).find('.commentText').parent().append('<i class="fas fa-trash commentMenu" id="removeChild" data-child_id="'+data.id+'"></i>')
				}	
				
				
			}
			
			
			
			$('.new'+data.id).find('.dropleft').css('background', '#cdeaac')
			
			$('.new'+data.id).find('.commentDate').text(data.date)
			$('.new'+data.id).find('.commentUserName').text(data.user_name)
			$('.new'+data.id).find('.commentText').html(data.comment)	
			$('.new'+data.id).find('.card-img-top').attr('src', '/images/users/'+data.user_id+'.jpg')
			
			$('.new'+data.id).toggle('slow')
			setTimeout( function(){				
				$('.new'+data.id).find('.dropleft').css('background', 'none')
			} , 3500 );
		//console.log(data.comments);
		
	});
	
});