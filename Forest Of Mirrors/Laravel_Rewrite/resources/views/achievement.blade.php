@extends('master')
@section('title', 'All Achievements')

@section('content')
@if($uid == $user->uid)
	<a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
@else
	<a href='{{ route('account') }}'><div id='returnButton'>Back To Profile</div></a>	
@endif
<br>
<body style="">
<article>
<div id="speciesInformation"><img src="{{ asset("images/icons/achievementman.png") }}"/><br> <br>
	{!! $text !!}
</div>
	<div id="newsView">All Achievements</div>
	<div id="questWords">
		@foreach($achievements as $achievement)
			@if(in_array($achievement->id, $unlocked_achievements, TRUE))
				<div style="border:1px solid;border-radius:10px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;display:flex;padding:3px;margin:1px;">
					<div style='padding:10px;margin-right:40px;'>
						<img src="{{ asset("images/achievements/{$achievement->image}_achievement.png") }} "/>
					</div>
					<div style='margin-top:5px;width:550px;'>
						<i>{{$achievement->name}}</i>
						<br><br>
						{{$achievement->description}}
					</div>
					<?php 
						if($uid == $_SESSION['uid']){
							$achieved = DB::select("SELECT * FROM `adopts_achievements` where adopts_achievements.what = ? and adopts_achievements.owner = ?", [$achievement->id, $_SESSION['uid']]); 
							if($achieved[0]->claimed == 'no'){ ?>
							<form method="POST" action="{{ route('achievements') }}" style="width:150px !important">
								@csrf
								<input type="hidden" name="achievementid" value="{{$achieved[0]->id}}"/>
								<button type="submit" id="returnButton" style="margin-right:0px;">
									{{ __('Claim Achievement') }}
								</button>
							</form>
							<?php 
							}
						}
					?> 
				</div>
			@else
				<div style="filter: grayscale(100%);border:1px solid;border-radius:10px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;display:flex;padding:3px;margin:1px;">
					<div style='padding:10px;margin-right:40px;'>
						<img src="{{ asset("images/achievements/{$achievement->image}_achievement.png") }} "/>
					</div>
					<div style='margin-top:5px;width:600px;'>
						<i>{{$achievement->name}}</i>
						<br><br>
						{{$achievement->description}}
					</div>
				</div>				
			@endif
		@endforeach
	</div>
    <br>
</article>
 @endsection
