@extends('master')
@section('title', 'The Battle Hub')

@section('content')

<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'></button>
        <h4 class='modal-title'>The Battle Hub</h4>
      </div>
      <div class='modal-body'>
        <p>Battle Text Here</p>
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
<script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_battle.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
<div id='returnButtonRight' style='margin-left:700px;'>{{$user->battle_charges}} Charges</div>
<br>
	<div id='questWords'>
		<img src="{{ asset("images/icons/arelonvvsmol.png") }}"/>
		<br>
		<br>
		Hello, {{$user->username}}. I see you're one of the castle's mages, so what brings you here? I doubt your kind know about how the demons have been troubling us, as around the castle grounds all you need to worry about is mages with a love for transformation spell jokes. We've had the wicked beings destroying our crops, tearing up our settlements, chasing off and in some cases even killing our farm animals. It hasn't been easy, but to see you here gives me hope- maybe the castle will finally step in to help. So what do you need from me? I can give you guidance on where you need to go to find demons, appraise items that you've find and train your creatures. 
	</div>
	<div id="newsView">The Battle Hub</div>
		<div id="questWords" style="display:flex;padding-left:190px;">
			<div data-toggle='modal' data-target='.modal' data-task='1' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
				<img src='{{ asset("images/icons/heal_creatures.png") }}'/><br>Heal<br>Creatures
			</div> 
				@if(!$train)
					<div data-toggle='modal' data-target='.modal' data-task='2' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
						<img src='{{ asset("images/icons/level_up.png") }}'/><br>
						Train<br> Creatures
					</div>
				@elseif($train->time_end >= time())
				<script>
						// Set the date we're counting down to
						var countDownDate = new Date({{$train->time_end}}*1000).getTime();

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
							+ minutes + 'm ' + seconds + 's';
							
							// If the count down is over, write some text 
							if (distance < 0) {
								clearInterval(x);
								location.reload();
							}
						}, 1000);
					</script>
					<div style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
						<img src="{{ route('image', $train->aid)}}" style="width:45px;height:45px;"/><br><div id='demo'></div>
					</div>
				@else
					<div style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
						<form method="POST" action="{{ route('battlehub') }}">
						@csrf
						<img src="{{ route('image', $train->aid)}}" style="width:45px;height:45px;"/><br>
						<input type="hidden" name="training" value="{{$train->id}}"/>
						<button type="submit" id='returnButton' style='width:70px;height:25px;margin-right:0px;padding:0px;'>
							{{ __('Collect') }}
						</button>
						</form>
					</div>				
				@endif
				<div data-toggle='modal' data-target='.modal' data-task='3' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
				<img src='{{ asset("images/items/battle_items/valravnticket.png") }}'/><br>Appraise<br> Tickets
			</div> 
			<div data-toggle='modal' data-target='.modal' data-task='4' style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
				<img src='{{ asset("images/items/battle_items/eyeoforrama.png") }}'/><br>Manage<br> Battle Stones
			</div> 
		</div>	
    <div id="newsView">Battle</div>
	<div id="questWords">
		<img src="{{ asset("images/icons/FOMMAP2.png") }}" usemap="#image-map">
		<map name="image-map">
			<area target="" alt="The Lost Fields" title="The Lost Fields" href="{{ route('battle_location', 0) }}" coords="123,32,122,41,126,48,135,52,144,52,150,47,153,38,146,29,137,26,131,25" shape="poly">
			<area target="" alt="The Ruins" title="The Ruins" href="{{ route('battle_location', 1) }}" coords="33,163,32,155,25,148,14,149,4,155,3,167,4,177,12,183,23,185,17,170,24,163" shape="poly">
			<area target="" alt="The Edgelands" title="The Edgelands" href="{{ route('battle_location', 2) }}" coords="120,42,112,42,104,43,95,39,91,32,89,27,97,24,106,23,115,23,124,30,127,36" shape="poly">
			<area target="" alt="The Volcanic Wastes" title="The Volcanic Wastes" href="{{ route('battle_location', 3) }}" coords="91,35,86,26,78,23,69,24,62,32,59,39,52,39,46,36,34,36,27,41,39,59,52,60,63,55,72,48,84,43" shape="poly">
			<area target="" alt="The Deep Forest" title="The Deep Forest" href="{{ route('battle_location', 4) }}" coords="68,113,58,115,48,112,39,111,34,102,27,90,35,81,46,73,62,68,96,64,114,54,129,60,129,79,127,90,121,97,110,104,102,100,92,104,84,108,78,114,76,112,91,104" shape="poly">
			<area target="" alt="The Drowned Town" title="The Drowned Town" href="{{ route('battle_location', 5) }}" coords="206,215,195,213,182,205,180,193,191,186,205,182,213,192,215,203" shape="poly">
			<area target="" alt="The Endless Hills" title="The Endless Hills" href="{{ route('battle_location', 6) }}" coords="213,154,211,162,211,172,222,178,232,175,240,171,247,171,250,157,250,146,247,135,250,127,243,122,236,118,227,123,222,127,219,134,216,140" shape="poly">
			<area target="" alt="The Arcane Portals" title="The Arcane Portals" href="{{ route('battle_location', 7) }}" coords="35,215,31,205,26,202,20,198,11,197,4,200,5,208,7,216,15,221,26,220" shape="poly">
			<area target="" alt="The Edgeworld" title="The Edgeworld" href="{{ route('battle_location', 8) }}" coords="250,168,246,179,243,193,243,208,246,221,241,229,228,239,209,247,178,248,162,247,149,247,250,248" shape="poly">
			<area target="" alt="The Edgeworld" title="The Edgeworld" href="{{ route('battle_location', 8) }}" coords="0,215,0,236,0,246,17,249,32,248,44,249,61,249,31,245,20,244,10,241,5,228" shape="poly">
			<area target="" alt="The Edgeworld" title="The Edgeworld" href="{{ route('battle_location', 8) }}" coords="0,205,4,196,12,191,20,189,7,180,3,167,2,157,10,149,18,146,13,135,9,123,7,116,3,110,8,101,4,90,11,83,15,73,18,62,19,51,26,40,34,33,35,18,32,10,27,0,9,0,0,1" shape="poly">
			<area target="" alt="The Edgeworld" title="The Edgeworld" href="{{ route('battle_location', 8) }}" coords="36,28,46,32,53,34,59,25,73,22,85,21,94,22,116,21,126,25,137,22,148,27,157,31,166,23,172,10,177,1,164,1,189,0,114,0,77,0,52,0,38,2,32,0" shape="poly">
			<area target="" alt="The Edgeworld" title="The Edgeworld" href="{{ route('battle_location', 8) }}" coords="180,0,187,13,191,20,201,23,212,24,221,33,224,41,235,49,245,57,250,62,248,39,249,22,247,7,245,0" shape="poly">
		</map>
		<br>
		<br>
		<div style='display:flex;flex-wrap:wrap;margin-left:50px;'>
			<a href="{{ route('battle_location', 0) }}">
				<button class='btn btn-default'>Lost Fields</button>
			</a>
			<a href="{{ route('battle_location', 1) }}">
				<button class='btn btn-default'>Ruins</button>
			</a>
			<a href="{{ route('battle_location', 2) }}">
				<button class='btn btn-default'>Edgelands</button>
			</a>
			<a href="{{ route('battle_location', 3) }}">
				<button class='btn btn-default'>Volcanic Wastes</button>
			</a>
			<a href="{{ route('battle_location', 4) }}">
				<button class='btn btn-default'>Deep Forest</button>
			</a>
			<a href="{{ route('battle_location', 5) }}">
				<button class='btn btn-default'>Drowned Town</button>
			</a>
			<a href="{{ route('battle_location', 6) }}">
				<button class='btn btn-default'>Endless Hills</button>
			</a>
			<a href="{{ route('battle_location', 7) }}">
				<button class='btn btn-default'>Arcane Portals</button>
			</a>
			<a href="{{ route('battle_location', 8) }}">
				<button class='btn btn-default'>The Edgeworld</button>
			</a>
		</div>
	</div>
	<div id="newsView">Your Champion</div>
		<div id="questWords">
			@if($adopt)
				{!! $adopt_image[0] !!}<br>
				{!! $adopt_image[1] !!} (Level {{$adopt->lvl}})
				<div class='prograss' style='height:20px;width:400px;background-color:red;border-radius:10px;margin-top:15px;margin-left:-5px;'>
						<div class='progress-bar' role='progressbar' style='width:{{($adopt->basehp/$adopt->maxhp)*100}}%;border-radius:10px;background-color:green;' aria-valuenow='{$adopt->basehp}' aria-valuemin='0' aria-valuemax='10000'>{{$adopt->basehp}} HP</div>
				</div>
				<div class='prograss' style='height:20px;width:400px;background-color:#222226;border-radius:10px;margin-top:15px;margin-left:-5px;'>
						<div class='progress-bar' role='progressbar' style='width:{{($adopt->exp/(3.5 * pow($adopt->lvl,3)))*100}}%;border-radius:10px;background-color:#003780;' aria-valuenow='{$adopt->exp}' aria-valuemin='0' aria-valuemax='10000'>{{$adopt->exp}} EXP</div>
				</div>
				<br>
				<div style='width:133px;width: 133px;height: 20px !important;display:table-cell;text-align:center;vertical-align:middle;background-color: #c5b6a5;border-radius: 10px;border-color: #3c3c3c;color: #383838;font-size:15px;;font-size:15px;'>{{$stats[0]}} ATK</div>
				<div style='width:133px;width: 133px;height: 20px !important;display:table-cell;text-align:center;vertical-align:middle;background-color: #c5b6a5;border-radius: 10px;border-color: #3c3c3c;color: #383838;font-size:15px;;font-size:15px;'>{{$stats[1]}} SPD</div>
				<div style='width:133px;width: 133px;height: 20px !important;display:table-cell;text-align:center;vertical-align:middle;background-color: #c5b6a5;border-radius: 10px;border-color: #3c3c3c;color: #383838;font-size:15px;;font-size:15px;'>{{$stats[2]}} DEF</div>
				<br>
				<div style='display:flex;align-items: center;justify-content: center;'>
				@foreach($stones as $stone)
					{!! make_item_tooltip($stone->iid,1,0,0) !!}
				@endforeach
				</div>
			@endif
			<br>
			<button class='btn-default btn' data-toggle='modal' data-target='.modal' data-task='5'>Change Champion</button>
		</div>
@endsection
