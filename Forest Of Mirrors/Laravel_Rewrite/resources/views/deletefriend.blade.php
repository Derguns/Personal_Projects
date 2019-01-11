<form method="POST" action="{{ route('friends') }}">
	<center>
        <div class="form-group row">
            <label for="tabname" class="">Are you sure you want to remove {{$friend->username}} from your friends list?</label><br>
                <div class="col-md-6">
					@csrf
					<input type="hidden" name="deletefriendid" value="{{$friend->uid}}"/>
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Remove {{$friend->username}}
    </button>
</form>
