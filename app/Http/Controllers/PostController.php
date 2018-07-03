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
use App\Visit;
use App\Comment;
use App\PostImage;
use \HTMLPurifier;
use Carbon\Carbon;
use Facades\ScoreCalc;

class PostController extends Controller
{
    
	// ADD POST VIEW
	public function add_car_post($id){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			$car =  Car::select(['id','user_id','make','model','year','nickauto'])->where('id', $id)->first();
			$owner = $car->user_id;
			$guest = Auth::id();

			if($owner == $guest){
				return view('new-post')->with(['car'=>$car]);
			}
			else{
				$error = 'This Car have other owner';
				$error1 = 'You can`t create Posts to this Car';
				return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
			}
		}
	}
	
	// CROP IMAGE FOR ADD POST
	public function crop_post_image(Request $request)
    {
        $data = $request->image;
		$name = $request->name;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
		$pathWeb = "/images/postImages/" . time() . Auth::id();
		
		Image::make($data)->save( public_path( $pathWeb . 'Full.jpg' ));
		Image::make($data)->resize(1000, 562)->save(public_path( $pathWeb . 'Medium.jpg' ));
		Image::make($data)->resize(583, 328)->save(public_path( $pathWeb . 'Small.jpg' ));
		Image::make($data)->resize(150, 84)->save(public_path( $pathWeb . 'Logo.jpg' ));

        return response()->json(['path'=>$pathWeb.'Small.jpg', 'name'=>$name]);
    }
	
	// SAVE POST AJAX
	public function save_post(Request $request)
    {
		// VALIDATION
		$validator = Validator::make($request->all(), [
			'title' => 'required | max:150',
			'category' => 'required',
			'content' => 'required',
			'price' => 'max:23',
			'km' => 'max:23',
			'images' => 'present|min:1'
		]); 
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }
		else{
			$car =  Car::select(['user_id'])->where('id', $request->car_id)->first();
			if($car->user_id == Auth::id()){
				$images = $request->images;
				$countImg = count($images);
				
				// Save post
				$data = $request->all();
				$post = new Post;
				$post->fill($data);
				$cleaned = \Purifier::clean($post->content, 'youtube');
				$post->content = $cleaned;
				$post->content = str_replace('<iframe', '<iframe allowfullscreen', $post->content); 
				$post->user_id = Auth::id();
				$post->date = Carbon::now()->toDateTimeString();
				$post->save();
				//// ADD SCORE POINT TO CAR
				ScoreCalc::newPoints($post->car_id, 300);
				// Save POST Image
				for ( $i = 0; $i < $countImg; $i++ ) {
					$postImage = new PostImage;
					$postImage->post_id = $post->id;
					$postImage->car_id = $request->car_id;
					$postImage->user_id = Auth::id();
					$postImage->path = $images[$i];
					$postImage->number = $i;
					$postImage->save();
				}
				return response()->json(['success'=>'Your car data stored']);
			}
			else{
				return response()->json(['error'=>'Some error with your car ID']);
			}
		}	
    }
	
	// DELETE POST
	public function delete_post(Request $request)
    {
		$post = Post::find($request->id);
		if ($post->user_id == Auth::id()){
			postImage::where('post_id', $request->id)->delete();
			$post->delete();
			return response()->json(['success'=>'The post deleted']);
		}
		else{
			return response()->json(['error'=>'Some error with your post ID']);
		}
	}
	
	// EDIT POST VIEW
	public function edit_post($id){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			
			$post = Post::find($id);
			$car =  Car::select(['id','user_id','make','model','year','nickauto'])->where('id', $post->car_id)->first();
			
			$owner = $post->user_id;
			$guest = Auth::id();
			$post->km_type = substr($post->km, -2, count($post->km)+1);
			$post->km = substr($post->km,  0, -2);
			
			$post->price_type = substr($post->price, strpos($post->price, ":") + 1);
			$post->price = substr($post->price, 0, strpos($post->price, ":"));
			
			$postImages = PostImage::select(['path'])->where('post_id', $post->id)->orderBy('number', 'asc')->get();
			
			foreach($postImages as $postImage){
				$postImage->pathS = str_replace('Full', 'Small', $postImage->path);
			}
			
			if($owner == $guest){
				return view('edit-post')->with(['car'=>$car, 'post'=>$post, 'postImages'=>$postImages]);
			}
			else{
				$error = 'This Car have other owner';
				$error1 = 'You can`t create Posts to this Car';
				return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
			}
		}
	}
	
	// EDIT POST AJAX CALL
	public function update_post(Request $request)
    {
		// VALIDATION
		$validator = Validator::make($request->all(), [
			'title' => 'required | max:150',
			'category' => 'required',
			'content' => 'required',
			'price' => 'max:23',
			'km' => 'max:23',
			'images' => 'present|min:1'
		]); 
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }
		else{
			
			$car =  Car::select(['user_id'])->where('id', $request->car_id)->first();
			if($car->user_id == Auth::id()){
				
				$images = $request->images;
				$countImg = count($images);
				$data = $request->all();
				// UPDATE POST
				$post = Post::findOrFail($request->id);
				$post->update($data);
				//$post->content = str_replace('  ', '&nbsp;', $post->content);
				$cleaned = \Purifier::clean($post->content, 'youtube');
				$post->content = $cleaned;
				$post->content = str_replace('<iframe', '<iframe allowfullscreen', $post->content); 
				//$post->content = str_replace('<a', '<a class="postLink"', $post->content);
				$post->save();
				
				// UPDATE POST Image
				for ( $i = 0; $i < $countImg; $i++ ) {
					$postImage = postImage::where('path', $images[$i])->first();
					if($postImage){
						$postImage->number = $i;
						$postImage->save();
					}
					else{
						$postImage = new PostImage;
						$postImage->post_id = $post->id;
						$postImage->car_id = $request->car_id;
						$postImage->user_id = Auth::id();
						$postImage->path = $images[$i];
						$postImage->number = $i;
						$postImage->save();
					}
				}
				return response()->json(['success'=>'Your car data Updated']);
			}
			else{
				return response()->json(['error'=>'Some error with your car ID']);
			}
		}	
    }
	
	// DELETE POST IMAGE AJAX CALL
	public function delete_post_image(Request $request)
    {
		if($postImage = PostImage::where('path', str_replace('Small', 'Full', $request->image))->delete()){
			return response()->json(['succes'=>'Image deleted']);
		}
		else{
			return response()->json(['succes'=>'????']);
		}
		
	}
	
	// POST VIEW
	public function post_view($id, Request $request){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login or register';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			if($post =  Post::find($id)){
				
				$post->date = Carbon::createFromTimeStamp(strtotime($post->date))->diffForHumans();
				
				//// GET POST IMAGES IF DON'T INSERTED IN TEXT
				$postImages = PostImage::select(['path'])->where('post_id', $post->id)->orderBy('number', 'asc')->get();
				foreach ($postImages as $i => $image) {
					$str = str_replace('https://vocsway.com', '', $image->path); 
					if ( strpos($post->content, $str) !== false ) {
						unset($postImages[$i]);
					}
				}
				
				//// GET LIKES
				$like = Like::select(['user_id', 'user_name'])->where('type', 'post')->where('item_id', $id)->orderBy('id', 'desc')->get();
				if($like->contains('user_id', Auth::id())){
					$like->owner = 1;
				}
				else{
					$like->owner = 0;
				}
				
				//// GET VISITS AND ADD VISIT IF NOT EXIST
				$visits = Visit::select(['user_id', 'user_name'])->where('post_id', $id)->orderBy('id', 'desc')->get();
				if($visits->contains('user_id', Auth::id())){}
				else{
					if( $post->user_id != Auth::id()){
						$visit = new Visit;
						$visit->post_id = $id;
						$visit->user_id = Auth::id();
						$visit->user_name = Auth::user()->name;
						$visit->save();
						$visits->push($visit);
					}
				}
				
				// GET COMMENTS
				$comments = Comment::where('post_id', $id)->where('child', 0)->orderBy('id', 'desc')->get();
				foreach ($comments as $comment){
					$comment->date = Carbon::createFromTimeStamp(strtotime($comment->date))->diffForHumans();
					$comment->childs = Comment::where('post_id', $id)->where('child', $comment->id)->orderBy('id', 'desc')->get();
				}

				return view('post-view')->with(['postImages'=>$postImages, 'post'=>$post, 'like'=>$like, 'visits'=>$visits, 'comments'=>$comments]);
			}
			else{
				$error = 'ERROR: The post not found';
				$error1 = 'Try go back and refresh your browser';
				return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
			}
		}
	}
	
}
