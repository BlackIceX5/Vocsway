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
use Illuminate\Support\Collection;
use App\Carmodel;
use App\CarImage;
use App\Car;
use App\Country;
use App\Post;
use App\Visit;
use App\Like;
use App\Comment;
use App\Subscriber;
use App\PostImage;
use Carbon\Carbon;
use App\VotingProces;
use App\VotingResult;
use Illuminate\Pagination\Paginator;
//use Facades\ScoreCalc;


class UserController extends Controller
{
///////////////////////////      USER PROFILE     ///////////////////////////////////

	// MAIN	PAGE VIEW + AJAX DINAMIC LOAD NEXT POSTS
	public function main(Request $request){

	    //LOAD 3 POSTS
	    $posts = Post::select(['id','title','category','content','price','km','date'])->orderBy('id', 'desc')->paginate(3);

        //GET POST INFO
        $this->GetPostInfo($posts);

        if ($request->ajax == 'ajax') {
            $data = view('filtredPosts')->with(['posts'=>$posts])->render();
            return response()->json([$data]);
        }

        // GET CAR OF THE DAY
        $carOfDay = VotingResult::where('date', Carbon::today()->format('Y-m-d'))->first();
        $path = CarImage::select('path')->where('main_img', 0)->where('car_id', $carOfDay->carId)->first();
        $path1 = str_replace('Small', 'Medium', $path->path);
        $carOfDay->carImage = $path1;

        // Return to View one array JSON with data from 2 tabels
        return view('main')->with(['posts'=>$posts, 'carOfDay'=>$carOfDay]);
	}

    ///// LOAD FILTRED POSTS
    public function FiltredPosts(Request $request){
        if ($request->model == ''){
            $posts =  Post::select(['id','title','category','content','price','km','date'])->where('make', $request->make )->orderBy('id', 'desc')->paginate(3);
        }elseif ($request->year == ''){
            $posts =  Post::select(['id','title','category','content','price','km','date'])->where('make', $request->make )->where('model', $request->model )->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $posts =  Post::select(['id','title','category','content','price','km','date'])->where('make', $request->make )->where('model', $request->model )->where('year', $request->year )->orderBy('id', 'desc')->paginate(3);
        }

        //GET POST INFO
        $this->GetPostInfo($posts);

        $data = view('filtredPosts')->with(['posts'=>$posts])->render();
        return response()->json([$data]);
    }

    // LOAD ALL INFO OF POST
    public function GetPostInfo($posts){
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
            $post->content = strip_tags($post->content);
            $post->content = mb_strimwidth($post->content, 0, 40, "...");
        }
        return $posts;
    }

    // VOTING PAGE
    public function vote(){
	    // CHECK IF USER LOGGED
        if(Auth::guest()){
            $error = 'Your session is expired ';
            $error1 = 'Please login';
            return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
        }
        else {
            // GET VOTING PROCCESS TODAY
            $vote = VotingProces::where('date', Carbon::today()->format('Y-m-d'))->first();
            // TOTAL VOTES FOR LAYOUT
            $vote->total = $vote->resCar1 + $vote->resCar2 + $vote->resCar3;
            // GET CARS INFO
            $car1 = Car::find($vote->car1);
            $car2 = Car::find($vote->car2);
            $car3 = Car::find($vote->car3);
            $car1->vote = $vote->resCar1;
            $car2->vote = $vote->resCar2;
            $car3->vote = $vote->resCar3;
            $cars = collect([$car1,$car2,$car3]);
            $user = Auth::id();
            // CHECK IF USER VOTTED
            $votedUsers = explode( ',', $vote->users );
            if( in_array($user, $votedUsers ) ){
                $vote->votedUser = 'yes';
            }else{
                $vote->votedUser = 'no';
            }
            // SET VOTES VALUE TO CARS
            foreach ($cars as $car) {
                // Get main image of car
                $path = CarImage::select('path')->where('main_img', 0)->where('car_id', $car->id)->first();
                $path1 = str_replace('Small', 'Full', $path->path);
                $car->path = $path1;
            }
            return view('vote')->with(['vote' => $vote, 'cars' => $cars]);
        }
    }

    // ADD NEW VOTE
    public function voteAction(Request $request){
        $vote = VotingProces::where('date', Carbon::today()->format('Y-m-d'))->first();
        $user = Auth::id();
        $votedUsers = explode( ',', $vote->users );
        if( in_array($user, $votedUsers ) ){
            return response()->json(['error'=>'Error: you vote present in Voting System ']);
        }else{
            $vote->users = $vote->users.','.$user;
            switch ($request->carId) {
                case $vote->car1:
                    $vote->resCar1 = $vote->resCar1+1;
                    break;
                case $vote->car2:
                    $vote->resCar2 = $vote->resCar2+1;
                    break;
                case $vote->car3:
                    $vote->resCar3 = $vote->resCar3+1;
                    break;
                default:
                    return response()->json(['error'=>'Error: Car Id Not found ']);
            }
            $vote->save();
            return response()->json(['success'=>'Thanks, Your vote added!']);
        }
    }

    // TEST
    public function test(){

    }
	
	// USER PROFILE VIEW	
	public function user_profile($id){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			$owner = $id;
			$guest = Auth::id();
	 
			if($owner == $guest){
				return view('user-profile-owner');
			}
			else{
				return view('user-profile-guest');
			}
		}
	}
	
	// EDIT USER PROFILE VIEW	
	public function editUser(){
		if(Auth::guest()){
			$error = 'Your session is expired ';
			$error1 = 'Please login again';
			return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
		}
		else{
			return view('edit-user');
		}	
	}
	
	// LOAD COUNTRY
	public function country_load(Request $request){
		$countries =  Country::select('country')->get();
		return response()->json([ 'countries'=>$countries ]);
	}
	
	
	// AVATAR CHANGE
	public function update_avatar(Request $request){
		
		$data = $request->image;
		
		if($data){
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
	
			$data = base64_decode($data);

			if(File::exists(public_path('/images/users/' . Auth::id() . 'Full.jpg'))){
				File::delete(public_path('/images/users/' . Auth::id() . 'Full.jpg'));
				File::delete(public_path('/images/users/' . Auth::id() . '.jpg'));
			}
			
    		Image::make($data)->save( public_path('/images/users/' . Auth::id() . 'Full.jpg'  ) );
			Image::make($data)->resize(100, 100)->save( public_path('/images/users/' . Auth::id() . '.jpg'  ) );
			
			return response()->json(['success'=>'Avatar Updated']);
			
    	}
		else{
			return response()->json(['success'=>'Avatar image is same! Select other image to save']);
		}
    }
	
	///// EDIT USER DATA VALIDATION & DB CALL
	public function user_update_data(Request $request){
		$user = Auth::user();
		$data = array_filter($request->all());
		$validator = Validator::make($data, [
			'email' => 'unique:users,email|max:190',
			'name' => 'unique:users,name|max:190',
			'password' => 'min:6|same:password_confirm',
			'password_confirm' => 'min:6'
		]); 
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()->all(), 'success'=>'No detected any changes']);
		}
		else{
			$updateNow = $user->update($data);

			$user->save();
			return response()->json(['success'=>'Your profile updated!', ]);
		}	
	} 
	
	///////////////////////////    END USER PROFILE     ///////////////////////////////////
	
	
	
	
	// USER PROFILE VIEW GUEST
	public function peoples(){
        if(Auth::guest()){
            $error = 'Your session is expired ';
            $error1 = 'Please login again';
            return view('error-page')->with(['error'=>$error, 'error1'=>$error1]);
        }
        else {
            $countPerPage = 5;

            $userCount = User::select()->count();
            $pageCount = ceil($userCount / $countPerPage);
            $users = User::select(['id', 'name', 'email'])->orderBy('id')->limit($countPerPage)->get();

            return view('peoples')->with(['users' => $users, 'count' => $pageCount]);
        }
	}
	
	public function privacy()
    {
        return view('privacy');
    }
	
	public function people_load(Request $request){

		$page = $request->page;
		
		$users =  User::select(['id','name','email'])->orderBy('id')->limit(1)->get();
		return response()->json([ 'users'=>$users ]);
	}
	
	// USER PROFILE VIEW GUEST
	public function peoplespart($pageid){
		
		$countPerPage = 5;
		
		$maxUsers = $countPerPage * $pageid;
		
		$users =  User::select(['id','name','email'])->offset($maxUsers-$countPerPage)->limit($countPerPage)->orderBy('id')->get();
		
		return view('people-card')->with(['users'=>$users]);
			
	}
}
