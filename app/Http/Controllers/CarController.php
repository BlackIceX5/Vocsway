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
use \HTMLPurifier;
use App\Post;
use App\Visit;
use App\Like;
use App\Comment;
use App\Subscriber;
use App\PostImage;
use Carbon\Carbon;
use Facades\ScoreCalc;

class CarController extends Controller
{
   ///////////////////////////    USER CARS     ///////////////////////////////////

	// ADD AUTO PROFILE VIEW	
	public function addAuto(){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			return view('add_auto');
		}
	}
	
	// LOAD CARS MAKE AJAX	
	public function cars_make_load(){
		
		$models =  Carmodel::select(['make'])->groupBy('make')->get();
		return response()->json([ 'make'=>$models ]);
	
	}
	
	// LOAD CARS MODEL AJAX	
	public function cars_model_load(Request $request){
		
		$models =  Carmodel::select(['model'])->where('make', $request->make)->groupBy('model')->get();
		return response()->json([ 'models'=>$models ]);
	
	}
	
	// LOAD CARS YEAR AJAX		 
	public function cars_year_load(Request $request){
		
		$models =  Carmodel::select(['year'])->where('make', $request->make)->where('model', $request->model)->groupBy('year')->get();
		return response()->json([ 'years'=>$models ]);
	
	}
	
	// LOAD CARS ENGINE AJAX		
	public function cars_engine_load(Request $request){
		
		$models =  Carmodel::select(['engine'])->where('make', $request->make)->where('model', $request->model)->
					where('year', $request->year)->groupBy('engine')->get();
		return response()->json([ 'engines'=>$models ]);
	
	}
	
	// CROP IMAGE FOR ADD CAR
	public function crop_image(Request $request)
    {
        $data = $request->image;
		$name = $request->name;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);


        $data = base64_decode($data);
        //$image_name= time().Auth::id().'Full.jpg';
        //$path = public_path() . "/images/userCars/" . $image_name;
		$pathWeb = "/images/userCars/" . time() . Auth::id();
		
		Image::make($data)->save( public_path( $pathWeb . 'Full.jpg' ));
		Image::make($data)->resize(1000, 562)->save(public_path( $pathWeb . 'Medium.jpg' ));
		Image::make($data)->resize(583, 328)->save(public_path( $pathWeb . 'Small.jpg' ));
		Image::make($data)->resize(150, 84)->save(public_path( $pathWeb . 'Logo.jpg' ));

        //file_put_contents($path, $data);


        return response()->json(['path'=>$pathWeb.'Small.jpg', 'name'=>$name]);
    }
	
	// SAVE CAR
	public function save_car(Request $request)
    {
		// VALIDATION
		$validator = Validator::make($request->all(), [
			'make' => 'required',
			'model' => 'required',
			'year' => 'required',
			'engine' => 'required',
			'fuel' => 'required',
			'nickauto' => 'required | max:35',
			'story' => 'required | min:100 | max:500',
			'images' => 'present|min:3'
		]); 
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }
		else{
			
			$images = json_decode($request->images);
			$countImg = count($images);
			
			// Save Car
			$data = $request->all();
			$car = new Car;
			$car->fill($data);
			$car->story = str_replace('  ', '&nbsp;', $car->story);
			$cleaned = \Purifier::clean($car->story);
			$car->story = $cleaned;
			$car->user_id = Auth::id();
			$car->score = 10;
			$car->date = date("Y-m-d");
			$car->save();
			
			// Save Car Image
			for ( $i = 0; $i < $countImg; $i++ ) {
				$carImage = new CarImage;
				$carImage->car_id = $car->id;
				$carImage->user_id = Auth::id();
				$carImage->path = $images[$i];
				
				$carImage->main_img = $i;
				
				
				$carImage->save();
			}
			return response()->json(['success'=>'Your car data stored']);
		}	
    }
	
	// Garage VIEW	
	public function garage(){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			// Cars of user collections (array json)
			$cars =  Car::select(['id','make','model','nickauto'])->where('user_id', Auth::id())->orderBy('id')->get();
			
			// Add image from CarImages table to car collections 
			foreach($cars as $car){
				// Get main image of car
				$path = CarImage::select('path')->where('user_id', Auth::id())->where('main_img', 0)->where('car_id', $car->id)->first();
				// Only for section-image!!! Use replace to build string  for blade template(For Auto select image resolution js function)
					// Final string mast be: data-full="path*Full.jpg" data-medium="path*medium.jpg" data-small="path*Small.jpg"
				$car->path ='data-full="'.str_replace('Small','Full', $path->path).'" data-medium="'.str_replace('Small', 'Medium', $path->path).'" data-small="'.$path->path.'"';
			}
			// Return to View one array JSON with data from 2 tabels
			return view('garage')->with(['cars'=>$cars]);
		}
	}
	
	// CAR PROFILE VIEW
	public function car_profile($id){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			
			$car =  Car::select(['id','user_id','make','model','year','engine','fuel','nickauto','story','score','date'])->where('id', $id)->first();
			$carImages = CarImage::select('path','main_img')->where('car_id', $id)->orderBy('main_img', 'asc')->get();
			$posts =  Post::select(['id','title','category','price','km','date'])->where('car_id', $id)->orderBy('id', 'desc')->get();

			foreach($posts as $post){
				//// GET VISITS COUNT
				$post->visits = Visit::select(['id'])->where('post_id', $post->id)->count();
				//// GET LIKES COUNT
				$post->likes = Like::select(['id'])->where('type', 'post')->where('item_id', $post->id)->count();
				//// GET COMMENT COUNT
				$post->comments = Comment::where('post_id', $post->id)->count();
				//// Humman date
				$post->date = Carbon::createFromTimeStamp(strtotime($post->date))->diffForHumans();
				//// GET MAIN IMAGE OF POST
				$postImages = PostImage::select(['path'])->where('post_id', $post->id)->where('number', 0)->first();
				$post->main_img = str_replace('Full', 'Small', $postImages->path);
				//// TRIM TITLE
				$post->title = mb_strimwidth($post->title, 0, 35, "...");
			}
			
			$imgString ='';
			$i = 0;
			foreach($carImages as $image){
				$imgString .= 'data-image'.$i.'="'.str_replace('Small','Full', $image->path).' "';
				$image->full = str_replace('Small','Full', $image->path);
				$i++;
				
			}
			
			$car->date = str_replace('ago', '', Carbon::createFromTimeStamp(strtotime($car->date))->diffForHumans());
			
			//// GET CAR LIKES
			$car->likes = Like::where('type', 'car')->where('item_id', $car->id)->get();
			if($car->likes->contains('user_id', Auth::id())){
				$car->justLiked = 1;
			}
			else{
				$car->justLiked = 0;
			}
			
			//// GET CAR SUBSCRIBERS
			$car->subscribers = Subscriber::where('car_id', $car->id)->get();
			if($car->subscribers->contains('user_id', Auth::id())){
				$car->justSubscribed = 1;
			}
			else{
				$car->justSubscribed = 0;
			}
			
			//// SCORE FACADE
			ScoreCalc::exist($car->id);
			
			$owner = $car->user_id;
			$guest = Auth::id();
			//dump($carImagesS);
			if($owner == $guest){
				return view('car-profile-owner')->with(['car'=>$car, 'imgString'=>$imgString, 'carImages'=>$carImages, 'posts'=>$posts]);
				
			}
			else{
				return view('car-profile-guest')->with(['car'=>$car, 'imgString'=>$imgString, 'carImages'=>$carImages, 'posts'=>$posts]);
			}
		}
	}
	
	// EDIT AUTO VIEW
	public function editAuto($id){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			
			$car =  Car::select(['id','user_id','make','model','year','engine','fuel','nickauto','story','score','date'])->where('id', $id)->first();
			$carImages = CarImage::select('path','main_img')->where('car_id', $id)->orderBy('main_img', 'asc')->get();
			$owner = $car->user_id;
			$guest = Auth::id();

			foreach($carImages as $image){
				//$imgString .= 'data-image'.$i.'="'.str_replace('Small','Full', $image->path).' "';
				$image->name = str_replace('.jpg','', $image->path);
			}
			
			if($owner == $guest){
				return view('edit-auto')->with(['car'=>$car, 'carImages'=>$carImages]);
			}
			else{
				$error = 'This Car have other owner';
				$error1 = 'You can`t edit this Car';
				return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
			}
			
		
		
		}
	}
	
	// EDIT//UPDATE CAR AJAX CALL
	public function update_car(Request $request)
    {
		// VALIDATION
		$validator = Validator::make($request->all(), [
			'make' => 'required',
			'model' => 'required',
			'year' => 'required',
			'engine' => 'required',
			'fuel' => 'required',
			'nickauto' => 'required | max:35',
			'story' => 'required | min:100 | max:500',
			'images' => 'present|min:3'
		]); 
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }
		else{
			
			$images = json_decode($request->images);
			$countImg = count($images);
			
			// Save Car
			$data = $request->all();
			
			$car = Car::findOrFail($request->id);
			
			$car->update($data);
			$car->story = str_replace('  ', '&nbsp;', $car->story);
			$cleaned = \Purifier::clean($car->story);
			$car->story = $cleaned;
			$car->save();
			
			
			//// Update Car Image
			for ( $i = 0; $i < $countImg; $i++ ) {
				$carImage = CarImage::where('path', $images[$i])->first();
				if($carImage){
					
					$carImage->main_img = $i;

					
					$carImage->save();
				}
				else{

					$carImage = new CarImage;
					$carImage->car_id = $car->id;
					$carImage->user_id = Auth::id();
					$carImage->path = $images[$i];
					if( $i == 0 ){
						$carImage->main_img = 1;
					}
					else{
						$carImage->main_img = 0;
					}

					$carImage->save();
					
				}
			}
			return response()->json(['error'=>'Car Data Updated']);
		}	
    }
	
	// DELETE CAR IMAGE AJAX CALL
	public function delete_car_image(Request $request)
    {
		if($carImage = CarImage::where('path', $request->image)->delete()){
			return response()->json(['succes'=>'Image deleted']);
		}
		else{
			return response()->json(['succes'=>'????']);
		}
		
	}
	

}
