<?php
    namespace App\Providers;
    use Illuminate\Support\Facades\View;
    use Illuminate\Support\ServiceProvider;

	use Illuminate\Support\Facades\Auth;

	use App\Car;
	use App\User;
	
    class ComposerServiceProvider extends ServiceProvider
    {
        /**
        * Register bindings in the container.
        *
        * @return void
        */
    public function boot()
    {
		// SHARE CARL LIST TO ALL VIEWS
		 View::composer('*', function($view) {
			$cars =  Car::select(['id','make','nickauto'])->where('user_id', Auth::id())->orderBy('id')->get();
			//$user =  User::select(['location'])->where('id', Auth::id())->first();
			//Auth::user()->setAttribute('location', $user->location);
            
			$view->with('userCars', $cars);
        });

    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
        //
    }
}