@extends('layouts.mainLayout')

@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<div class="section light-content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
              

                <div class="card-body Ymiddle">
                    

                    <form class="YmiddleChild" method="POST" action="{{ route('password.email') }}">
                        @csrf

						<div class="form-group row mb-0 text-center">
							@if (session('status'))
							<div class="alert alert-success" style="width: 100%;margin: 3% 10%;">
								{{ session('status') }}
							</div>
							@endif
						</div>
						
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 float-right text-right">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
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
