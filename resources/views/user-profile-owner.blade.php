@extends('layouts.mainLayout')

@section('content')

<!-- Hero Section -->
    <div id="hero">
        <div id="hero-styles" class="opacity-onscroll">
            <div id="hero-caption">
                <div class="inner">
                    <h2 class="hero-title">{{ Auth::user()->name }}</h2>
					<p class="hero-title">{{ Auth::user()->location }}</p>
                                            
                </div>
            </div>
        </div>
    </div>     

@endsection

@section('page-nav')

@endsection

@section('scripts') 

@endsection	