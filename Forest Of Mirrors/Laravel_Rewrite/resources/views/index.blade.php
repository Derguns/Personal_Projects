@extends('master')
@section('title', 'Home')

@section('content')
<script>
	function load(id){
	  $( "#staples" ).load( "battle/"+id+"" );
	}
</script>
<div class="container">
    	<div class="row">
    		<div class="col-md-12" id="content-section">
    		<h1 style="text-align: center; margin-top:300px; margin-bottom:300px;">Home Page</h1>
			<div style="display:flex;  flex-wrap: wrap;  width:850px;margin-left:-250px;">
			@foreach($items as $item)
				{!! $item !!}
			@endforeach
			<div id='staples'>
				<?php echo(generate_battle_display()); ?> 
			</div>
    		</div>
    	</div>
    </div>
 @endsection
