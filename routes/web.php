<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'UserController@main');                                                 // MAIN VIEW
Route::get('/vote', 'UserController@vote')->name('vote');                               // VOTING PAGE
Route::post('userVote', 'UserController@voteAction');                                   // ADD VOTE
Route::get('/test', 'UserController@test');
Route::get('/FiltredPosts', 'UserController@FiltredPosts');                             // FilterPosts






// LOGIN/REGISTER
Auth::routes();																			// LARAVEL DEFAULT AUTH ROUTES
Route::get('/redirect', 'SocialAuthFacebookController@redirect');						// FACABOOK LOGIN
Route::get('/callback', 'SocialAuthFacebookController@callback');						// FACABOOK LOGIN
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');					// REGISTRATION - EMAIL VERIFICATION 
Route::get('/home', 'HomeController@index')->name('home');								// HOME REDIRECT FROM PASS. CHANGE


// CAR
Route::get('carProfile/{id}', 'CarController@car_profile')->name('car.profile'); 		// CAR PROFILE VIEW (OWNER AND GUEST)
  //ADD CAR
Route::get('register-a-car', 'CarController@addAuto')->name('add.auto');				// VIEW
Route::post('loadCarsMake',   'CarController@cars_make_load'); 							// AJAX LOAD MAKE LIST
Route::post('loadCarsModel',   'CarController@cars_model_load'); 						// AJAX LOAD MODEL LIST
Route::post('loadCarsYear',   'CarController@cars_year_load'); 							// AJAX LOAD YEAR LIST
Route::post('loadCarsEngine',   'CarController@cars_engine_load');						// AJAX LOAD ENGINES LIST
Route::post('cropImage',   'CarController@crop_image'); 								// CROP CAR IMAGES
Route::post('saveCar',   'CarController@save_car'); 									// AJAX SAVE CAR
  // EDIT CAR
Route::get('/edit-car/{id}', 'CarController@editAuto')->name('edit.auto');				// EDIT CAR VIEW
Route::post('updateCar',   'CarController@update_car');									// AJAX DO EDIT CAR
Route::post('deleteCarImage',   'CarController@delete_car_image');						// DELETE CAR IMAGE FROM EDIT VIEW


// POST
Route::get('/new-post/{id}', 'PostController@add_car_post')->name('add.car.post');	    // ADD POST VIEW
Route::get('/edit-post/{id}', 'PostController@edit_post')->name('edit.post'); 			// EDIT POST VIEW
Route::get('/post/{id}', 'PostController@post_view')->name('post'); 				    // POST VIEW (OWNER AND GUEST)
Route::post('cropPostImage',   'PostController@crop_post_image'); 						// CROP POST IMAGES
Route::post('savePost',   'PostController@save_post'); 									// AJAX SAVE NEW POST
Route::post('deletePost',   'PostController@delete_post'); 								// AJAX DELETE POST
Route::post('updatePost',   'PostController@update_post'); 								// AJAX DO EDIT POST
Route::post('deletePostImage',   'PostController@delete_post_image');					// DELETE IMAGE FROM EDIT VIEW


// GARAGE
Route::get('garage', 'CarController@garage')->name('garage'); 							// GARAGE VIEW ( MY CARS )


// CLS                                                                                  // CLS (COMMENTS LIKES SUBSCRIBERS CONTROLLER)
Route::post('addLike',   'CLSController@add_like'); 									// ADD LIKE
Route::post('addComment',   'CLSController@add_comment'); 								// ADD COMMENT
Route::post('deleteComment',   'CLSController@delete_comment');							// DELETE COMMENT
Route::post('deleteCommentChild',   'CLSController@delete_comment_child'); 	            // DELETE COMMENT CHILD
Route::post('subscribe',   'CLSController@subscribe'); 									// SUBSCRIBE TO CAR

// USER
Route::get('user', 'UserController@editUser')->name('edit-user');
Route::get('/user/{id}', 'UserController@user_profile')->name('user-profile');			// EDIT USER PROFILE
Route::post('userUpdateData',   'UserController@user_update_data');						// AJAX DO EDIT USER DATA 
Route::post('userUpdateAvatar', 'UserController@update_avatar');						// AJAX DO EDIT AVATAR
Route::post('loadCountry',   'UserController@country_load');							// AJAX LOAD COUNTRIES LIST


// PEOPLE
Route::get('people', 'UserController@peoples')->name('people');
Route::get('people/{pageid}', 'UserController@peoplespart')->	name('peoplea');
Route::post('loadPeople',   'UserController@people_load');


// PRIVACY POLICY
Route::get('privacy-policy', 'UserController@privacy')->name('privacy.policy');        	// PRIVACY VIEW 

