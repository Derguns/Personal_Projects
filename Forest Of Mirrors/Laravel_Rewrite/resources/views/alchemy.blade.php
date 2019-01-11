@extends('master')
@section('title', 'Alchemy')

@section('content')
<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'></button>
        <h4 class='modal-title'>Smelting an Item</h4>
      </div>
      <div class='modal-body'>
        <p>Smelting Text Here</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_smelting.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>

<a href='{{ route('account') }}'><div id='returnButton'>Alchemy Store</div></a>
<div id='returnButtonRight'>Level {{$user->lvl}}<br>
<div class="prograss" style="height:20px;width:140px;background-color:{{$color_1}};border-radius:10px;margin-top:15px;margin-left:-5px;">
 	<div class="progress-bar" role="progressbar" style="width:{{$exp_percent}}%;border-radius:10px;background-color: {{$color_2}};" aria-valuenow="{{$user->exp}}" aria-valuemin="0" aria-valuemax="100"> {{$user->exp}} EXP</div>
 	                 </div></div>
<br>
<body style="">
<article>
<div id="speciesInformation">
	@if($current_brew != 'none')
		@if($current_brew->time_end > time())
			<script>
				// Set the date we're counting down to
				var countDownDate = new Date({{$current_brew->time_end}}*1000).getTime();

				// Update the count down every 1 second
				var x = setInterval(function() {

					// Get todays date and time
					var now = new Date().getTime();
					
					// Find the distance between now an the count down date
					var distance = countDownDate - now;
					
					// Time calculations for days, hours, minutes and seconds
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);
					
					// Output the result in an element with id='demo'
					document.getElementById('demo').innerHTML = hours + 'h '
					+ minutes + 'm ' + seconds + 's Until Brew Is Finished';
					
					// If the count down is over, write some text 
					if (distance < 0) {
						clearInterval(x);
						location.reload();
					}
				}, 1000);
			</script>
			<img src="{{ asset("images/icons/{$user->clan}gif.gif") }}"/><br>
			<img src="{{ asset("images/icons/{$user->clan}_caldrounsm.png") }}"/>
			<br>
			<div id="questWords" style="width:800px">
			@if($current_brew->brew_id >= 239 && $current_brew->brew_id <= 242)
					Currently Smelting <br> <img src="{{ asset("image/{$current_brew->items_id}") }}"/> ({{$current_brew->items_id}})
			@elseif($current_brew->brew_id >= 233 && $current_brew->brew_id <= 235)
				Currently Smelting <br> 
				<div style='width:150px'>
					<?php echo make_item_tooltip($current_brew->items_id, 10, 0, 0); ?>	
				</div>
			@elseif($current_brew->brew_id >= 236 && $current_brew->brew_id <= 238)
				 Currently Smelting <br>
				 <div style='width:150px'>
					<?php echo make_companion_tooltip($current_brew->items_id, 10, 0, 0); ?>	
				</div>
		    @else
				Currently Smelting <br>
				<div style='width:150px'>
					{!! $brew_result !!}
					<br>
					<i>{{ $brew_name }}</i>
				</div>
			@endif
			<div id='demo'></div>
			</div>
			<br> <br>
			The cauldron bubbles happily with the items that you've placed inside. Come back to pick up your results when it is done.
		@else
			<img src="{{ asset("images/icons/{$user->clan}_caldrounsm.png") }}"/>
			<br>
			<div id="questWords" style="width:800px">
			Something lies inside of the cauldron :<br> <div style='width:150px;'>{!! $brew_result !!}</div>
			<form method="POST" action="{{ route('alchemy') }}" style="width:175px !important">
				@csrf
				<input type="hidden" name="currentbrew" value="{{$current_brew->id}}"/>
				<button type="submit" id="returnButton" style="margin-right:0px;">
					{{ __('Collect') }}
				</button>
			</form>
			</div>
			<br> <br>
			The cauldron bubbles happily with the items that you've placed inside. Come back to pick up your results when it is done.			
		@endif
		</div>
		<div id="newsView">
			The Alchemist's Cauldron
		</div>
		<div id="questWords">
			You cannot actively brew anything while the pot is full.
		</div>
	@else
			<img src="{{ asset("images/icons/empty_caldrounsm.png") }}"/>		
			<br> <br>
			The cauldron beckons for you to place an object within it- but it reveals nothing of what it will do with what it is given.
			You're fairly sure somewhere around here you have recipes that you've collected from potions class and on your adventures, maybe following them can guide you better.
			Some mages have also spoke of a mysterious being selling potion scrolls to those who can find his shop...
		</div>
		<div id="newsView">
			The Alchemist's Cauldron
		</div>
		<div id="questWords" style="display:flex;padding-left:255px;">
				<div data-toggle='modal' data-target='.modal' data-task='1' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">Smelt Companions
			</div> 
				<div data-toggle='modal' data-target='.modal' data-task='2' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">Smelt<br> Creatures
			</div> 
				<div data-toggle='modal' data-target='.modal' data-task='3' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">Smelt<br> Battle Stones
			</div> 
		</div>		
	@endif
		<div id="questWords">
			@foreach($alchemys as $alchemy)
			<div style="filter:border:1px solid;border-radius:10px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;display:flex;padding:3px;margin:2px;">
					<div style='padding:10px;margin-right:40px;width:60px;height:50px;font-size:10px;'>
						<img src="{{ asset("images/items/alchemy_recipes/{$alchemy->image_url}.png") }} "/>
					</div>
					<div style='margin-top:5px;width:600px;'>
						<i>{{$alchemy->name}}</i>
						<br>
						<span style='font-size:10px;'>Level {{$alchemy->level}}</span>
						<br>
						<div style='display:flex;margin-left:40px;'>
							<?php 
								$cost = $alchemy->cost*$alchemy->level;
								$item_array = Explode(",", $alchemy->item_id_list);
								$item_quant_array = Explode(",", $alchemy->item_quant_list);
								$item_count = 1;
								foreach($item_array as $index => $item){
									$user_item = DB::select("SELECT * FROM `adopts_inventory` where itemname = ? and owner = ?", [ $item, $_SESSION['uid']]);
									$quantity = 0;
									if($user_item){
										$quantity = $user_item[0]->quantity;
										if($user_item[0]->quantity < $item_quant_array[$index]){
											$item_count = 0;
										}
									}
									else{
										$item_count = 0;
									}
									echo(make_item_tooltip($item, $quantity, $item_quant_array[$index], 0));
								}
							?>
						</div>
					</div>
					<div style='width:200px;'>
					@if($item_count > 0 && $current_brew == 'none' && $user->money >= $cost)
					<form method="POST" action="{{ route('alchemy') }}" style="width:175px !important">
						@csrf
						<input type="hidden" name="alchemyid" value="{{$alchemy->id}}"/>
						<button type="submit" id="returnButton" style="margin-right:0px;">
							{{ __('Make') }}
						</button>
					</form>
					@endif
					<br>
					<?php
						echo gmdate("H:i:s", ($alchemy->make_time * $alchemy->level));
						echo " Hours";
						echo "<br>";
						echo "{$alchemy->exp} EXP<br>";
						echo "<img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'> {$cost}<br>";
					?>
					</div>
				</div>	
			@endforeach
		</div>
	<br>
</article>
 @endsection
