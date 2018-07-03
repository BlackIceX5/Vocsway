<?php

namespace App\Facades;
use Auth;
use App\User;
use App\Like;
use App\Comment;
use App\Subscriber;

class CLSWebSocket
{
    public function pushNotification($user_id, $type, $user_name, $owner_id) {
		
		$user = User::find($user_id);
		
		if ($user->isOnline()){
			$countTotal = 0;
			//// GET NEW LIKES
			$like = Like::where('owner', $user_id)->where('status', 'new')->count();
			$countTotal+= $like;
			//// GET NEW SUBSCRIBERS
			$subscribers = Subscriber::where('owner', $user_id)->where('status', 'new')->count();
			$countTotal+= $subscribers;
			// GET NEW COMMENTS
			$comments = Comment::where('owner', $user_id)->where('status', 'new')->count();
			$countTotal+= $comments;
			
			//$countTotal = $like+$subscribers+$comments;

			$options = array(
				'cluster' => 'eu',
				'encrypted' => true
			);
			$pusher = new \Pusher\Pusher(
				'4d2e3fce26ff9f2d5cfb',
				'b4f98146febf7bca1f0e',
				'497315',
				$options
			);
			
			
			
			switch ($type) {
				// LIKE
				case 'car':
					$link = '<a class="vocColor likeListItem capitalize" href="/user/'.$owner_id.'" data-type="page-transition"> '.$user_name.' </a> liked your Car';
					
				break;
				// LIKE
				case 'post':
					$link = '<a class="vocColor likeListItem capitalize " href="/user/'.$owner_id.'" data-type="page-transition"> '.$user_name.' </a> liked your Post';
				break;
				// COMMENT
				case 'comment':
					$link = '<a class="vocColor likeListItem capitalize " href="/user/'.$owner_id.'" data-type="page-transition"> '.$user_name.' </a> commented your Post';
				break;
				// SUBSCRIBER
				case 'subscriber':
					$link = '<a class="vocColor likeListItem capitalize " href="/user/'.$owner_id.'" data-type="page-transition"> '.$user_name.' </a> subscribed for your Car';
				break;
			}
			//$data['countTotal'] = ;
			//$data['link'] = ;
			$data = ['count'=>$countTotal, 'link'=>$link];

			$pusher->trigger('user-'.$user_id, 'notifications', $data);
		}
		

	}
	
	public static function getnotificationCount($user_id) {
		
		//// GET NEW LIKES
		$like = Like::where('owner', $user_id)->where('status', 'new')->count();
		//// GET NEW SUBSCRIBERS
		$subscribers = Subscriber::where('owner', $user_id)->where('status', 'new')->count();
		// GET NEW COMMENTS
		$comments = Comment::where('owner', $user_id)->where('status', 'new')->count();

		$countTotal = $like+$subscribers+$comments;
			
		return $countTotal;

	}
	
}