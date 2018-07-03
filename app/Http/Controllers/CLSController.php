<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use File; 
use Image;
use Artisan;
use \Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection; // strtoupper($elem) - erase empty value in array
use App\Carmodel;
use App\CarImage;
use App\Car;
use App\Post;
use App\Like;
use App\Comment;
use App\Subscriber;
use App\PostImage;
use \HTMLPurifier;
use Carbon\Carbon;
use Facades\ScoreCalc;
use Facades\CLSWebSocket;

	
class CLSController extends Controller
{
	

	
	
    // ADD LIKE AJAX CALL
	public function add_like(Request $request)
    {
		
		
		$like = Like::where('type', $request->type)->where('item_id', $request->item_id)->where('user_id', Auth::id())->first();
		if($like){
			return response()->json(['error'=>'Just Liked']);
		}
		else{
			$newLike = new Like;
			$newLike->fill($request->all());
			$newLike->user_id = Auth::id();
			$newLike->status = 'new';
			$newLike->user_name = Auth::user()->name;
			$newLike->save();
			ScoreCalc::newPoints($request->car_id, 200);
			CLSWebSocket::pushNotification($newLike->owner, $newLike->type, Auth::user()->name, Auth::id());
			return response()->json(['success'=>'Like Added']);
		}
		
	}
	
	 // SUBSCRIBE AJAX CALL
	public function subscribe(Request $request)
    {
		$subscribed = Subscriber::where('car_id', $request->car_id)->where('user_id', Auth::id())->first();
		if($subscribed ){
			$subscribed->delete();
			ScoreCalc::deletePoints($request->car_id, 200);
		}
		else{
			$newSubscriber = new Subscriber;
			$newSubscriber->fill($request->all());
			$newSubscriber->user_id = Auth::id();
			$newSubscriber->status = 'new';
			$newSubscriber->user_name = Auth::user()->name;
			$newSubscriber->save();
			ScoreCalc::newPoints($request->car_id, 200);
			CLSWebSocket::pushNotification($newSubscriber->owner, 'subscriber', Auth::user()->name, Auth::id());
		}
		$count = Subscriber::where('car_id', $request->car_id)->count();
		return response()->json(['count'=>$count]);
		
	}
	
	// ADD COMMENT AJAX CALL
	public function add_comment(Request $request)
    {
		$comment = new Comment;
		$comment->post_id = $request->post_id;
		$comment->user_id = Auth::id();
		$comment->user_name = Auth::user()->name;
		$comment->comment = \Purifier::clean($request->comment);
		If ($request->child){
			$comment->child = $request->child;
		}
		else{
			$comment->child = 0;
		}
		$comment->date = Carbon::now()->toDateTimeString();
		$comment->status = 'new';
		$comment->owner = $request->post_owner_id;
		$comment->save();
		$date = Carbon::createFromTimeStamp(strtotime($comment->date))->diffForHumans();
		ScoreCalc::newPoints($request->car_id, 200);
		CLSWebSocket::pushNotification($comment->owner, 'comment', Auth::user()->name, Auth::id());
		///////// WEB SOCKET

		$options = array(
			'cluster' => 'eu',
			'encrypted' => true
		);
		$pusher = new \Pusher\Pusher(
			'716b119f930a79f15fc2',
			'cd844a8801ea0dd9432b',
			'492803',
			$options
		);
		$comment->date = $date;
		//$data['message'] = 'hello world';
		$pusher->trigger('post-'.$request->post_id, 'comments', $comment);
		
		return response()->json(['id'=>$comment->id, 'date'=>$date]);
	}
	
	// DELETE COMMENT CHILD AJAX CALL
	public function delete_comment(Request $request)
    {
		$comment = Comment::find($request->id);
		if( $comment->user_id == Auth::id() ){
			$comment->delete();
			$commentChilds = Comment::where('child', $request->id)->delete();
		}
		else if( $comment->owner == Auth::id() ){
			$comment->delete();
			$commentChilds = Comment::where('child', $request->id)->delete();
		}
		else{
			return response()->json(['error'=>'Error comment not fount or you don`t have permmision to remove']);
		}
		return response()->json(['success'=>'Comment Deleted']);
	}
	
	// DELETE COMMENT CHILD AJAX CALL
	public function delete_comment_child(Request $request)
    {
		$child = Comment::find($request->id);

		if( $child->user_id == Auth::id() ){
			$child->delete();
		}
		else if( $child->owner == Auth::id() ){
			$child->delete();
		}
		else{
			return response()->json(['error'=>'Error comment not fount or you don`t have permmision to remove']);
		}
		return response()->json(['success'=>'Comment Child Deleted']);
	}
	
}
