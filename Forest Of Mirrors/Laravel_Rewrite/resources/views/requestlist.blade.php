Here is a list of all of your pending friend requests.
@foreach($requests as  $index => $request)
<div id='questWords' style="display:flex;width:500px;">
	<div style="width:300px"><label for="tabname" class=""><a href='/profile/view/{{$request->fromuser}}'>{{$request->fromuser}} would like to be your friend.</label></div>
	<div style="width:100px"><form method="POST" action="{{ route('friends') }}">
		@csrf
		<input type="hidden" name="requestid" value="{{$request->fid}}"/>
		<input type="hidden" name="action" value="accept"/>
		<button type="submit" id="returnButton"">
			Accept
		</button>
	</form>
	<form method="POST" action="{{ route('friends') }}">
		@csrf
		<input type="hidden" name="requestid" value="{{$request->fid}}"/>
		<input type="hidden" name="action" value="deny"/>
		<button type="submit" id="returnButton"">
			Deny
		</button>
	</form>
	</div>
</div>
@endforeach