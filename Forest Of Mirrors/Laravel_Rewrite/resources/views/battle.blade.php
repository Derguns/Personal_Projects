@extends('master')
@section('title', 'Home')

@section('content')
<script>
	function load(id){
	  $( "#staples" ).load( "<?php
			$pageURL = 'http';
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} //this here  
			$parts = Explode('/', $pageURL);
			$id = $parts[count($parts) - 1];
			echo $id; 
		?>/"+id+"" );
	}
</script>
<a href='{{ route('battlehub') }}'>
	<div id='returnButton'>
		Battle Hub
	</div>
</a>
<div style="display:flex;  flex-wrap: wrap; width:850px;">
	<div id='staples'>
		<?php echo(generate_battle_display()); ?> 
	</div>
</div>
 @endsection
