<form method="POST" action="{{ route('bank') }}">
	<center>
        <div class="form-group row" style='padding:2px;'>
			 You currently have <img src="{{ asset("images/icons/orb4.png") }}"/> {{ $user->money }} blue stones and <img src="{{ asset("images/icons/orb5.png") }}"/> {{ $user->reactorstones }} reactor stones on hand that you can transfer to another user.
                <hr>
				<div class="col-md-6">
					@csrf
					<input id="username" type="text" name="username" placeholder="Username or User ID" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
                    <label for="bluestones" class="" style="display:float;float:left;margin-bottom:-15%;margin-left:60%;">
						<img src="{{ asset("images/icons/orb4.png") }}"/>
					</label>
						<input id="bluestones" type="text" name="bluestones" value="" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;'>
                    <label for="reactorstones" class="" style="display:float;float:left;margin-bottom:-15%;margin-left:60%;">
						<img src="{{ asset("images/icons/orb5.png") }}"/>
					</label>
						<input id="reactorstones" type="text" name="reactorstones" value="" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;'>
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Send Transfer
    </button>
</form>
