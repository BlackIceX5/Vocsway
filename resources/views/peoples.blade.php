@extends('layouts.mainLayout')

@section('content')

	<style>
.card-new {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 150px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.card-title {
  color: grey;
  font-size: 9px;
  padding-top: 0.25rem;
  padding-bottom: 0px;
  margin-bottom: 0px;
}

.card-name{
	margin-top: 0.5rem;
	margin-bottom: 0px;
	white-space: nowrap;
    overflow: hidden;
}
	
.card-role {
  color: grey;
  font-size: 11px;
  padding-top: 0rem;
  margin-top:-10px;
}

.card-contact {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 5px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 14px;
}

</style>
<div id="showcase-holder"> 
<div id="showcase-slider"> 
<!-- Section Slide -->
<div class="section text-align-center"> 
<div class="row justify-content-center">
	@include('people-card')
</div>
</div> 
<!--/Section Slide -->	  
</div>
</div>    

@endsection

<@section('page-nav')
	<div class="nav-item-footer">
		<div id="scroll_page" class="page-item-footer">
			<p class="page-item up" id="fp-viewing">----------</p>
			<p class="page-item " id="fp-viewing-1">Page 1</p>
			@for ($i = 2; $i <= $count; $i++)		
				<p class="page-item down" id="fp-viewing-{{ $i }}">Page {{ $i }}</p>
			@endfor
			<p class="page-item down" id="fp-viewing">----------</p>
			
		</div>
	</div>
@endsection>

@section('scripts')
<!--/          Your SCRIPT in JS PEOPLE.JS                 -->	
@endsection