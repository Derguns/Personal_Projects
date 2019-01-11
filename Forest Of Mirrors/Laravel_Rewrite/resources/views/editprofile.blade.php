@extends('master')
@section('title', 'Managing My Profile')

@section('content')
  <a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Editing Profile</div>
	<div id="questWords">Manage and change your profile information below. All text typed here must abide by site rules, and will be displayed on your public account profile. 
	</div>
	<div id="questWords">
<form method="POST" action="{{ route('editprofile') }}">
	<center>
        <div class="form-group row">
                <div class="col-md-6">
					@csrf
					<div style='display:flex;margin-left:100px;'><div><img src='{{$avatar}}'></img></div>
						<div><input id="avatar" type="text" name="avatar" value="{{$avatar}}" size='700px' style='height:30px;width:500px !important;border-radius:10px;padding:3px;padding-left:7px;' required autofocus><br>Please enter a direct image URL for your avatar above.<br><br><br>Profile Bio:</div>
					</div>
					<br>
					<textarea name="bio" id="bio" rows="10" cols="40" style='width:625px !important;margin-left:100px;' class="form-control">{{$profile->bio}}</textarea>
					<br>
					<div style='margin-left:375px;width:100px;'>Profile CSS:</div>
					@if($css)
						<textarea name="css" id="css" rows="10" cols="40" style='width:625px !important;margin-left:100px;' class="form-control">{{$css->css}}</textarea>
					@endif
					<br>
					@if($user_options->profile_css == 1)
						<div style='margin-left:325px;width:200px;'>Disable Custom CSS
						<input name="disable" id="disable" value="disable" type="checkbox" class="" style='width:10px;height:10px;'></div><br>
					@else
						<div style='margin-left:325px;width:200px;'>Enable Custom CSS
						<input name="enable" id="enable" value="enable" type="checkbox" class="" style='width:10px;height:10px;'></div><br>
					@endif	
					<div style='margin-left:325px;width:200px;'>Gender:</div>
                    <select name="gender" style='margin-left:325px; height:30px;width:210px;border-radius:10px;padding:3px;padding-left:7px;background-color:white;' required autofocus>
					@foreach($genderlist as $indexKey => $gender)
						<option value="{{$indexKey}}"
						@if($gender == $profile->gender)
							selected
						@endif
						>{{$gender}}</option>
					@endforeach
					</select>					</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:350px;">
    Save Changes
    </button>
</form>
</div>
 @endsection
