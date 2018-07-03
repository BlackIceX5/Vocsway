
	@foreach ($users as $user)

					@if(file_exists('images/users/' . $user->id  . '.jpg')) 
							@php ($avatar = asset('images/users/' . $user->id . 'Full.jpg'))
						@else
							@php ($avatar = asset('images/users/user-loged.png'))
						@endif
					<div class="col-md-2">
						<div class="card-new">
						<p class="card-title">Chernivtsi, Ukraine</p>	
						<img src="{{$avatar}}" alt="John" style="width:70%;border-radius: 50%!important;">
						<p class="card-name">{{ $user->name }}</p>
						<p class="card-role">{{ $user->name }}, 29</p>
						<p><button class="card-contact">View Details</button></p>
					</div>
					</div>
			
	@endforeach	

