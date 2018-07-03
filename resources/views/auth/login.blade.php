@extends('layouts.mainLayout')
@section('title')
    Login
@endsection
@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<!-- Section Slide -->
<div class="section light-content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                
				
				
                <div class="card-mod card-body Ymiddle">
                    
					<form class="YmiddleChild" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 text-center">
                                <div class="checkbox float-left">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
								
							
								<a class="btn btn-link float-right" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
						
                            <div class="col-md-6 offset-md-4 text-center">
                                
								<button type="submit" class="btn btn-primary float-left">
                                    Login
                                </button>
							
                                <a href="{{url('/redirect')}}" class="btn btn-primary float-right">Login with <i class="fab fa-facebook"></i></a>
                            
                                
                            </div>
							
							
                        
						</div>

						
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>    

@endsection
