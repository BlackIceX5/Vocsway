@extends('layouts.mainLayout')

@section('content')
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<div class="section light-content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>    

@endsection
