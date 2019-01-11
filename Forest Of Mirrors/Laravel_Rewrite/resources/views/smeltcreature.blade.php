<form method="POST" action="{{ route('alchemy') }}">
	<center>
        <div class="form-group row">
			 Please enter the ID of the creature that you want to smelt.<br>
                <div class="col-md-6">
					@csrf
                    <input id="adoptid" type="text" name="adoptid" value="" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Smelt Creature
    </button>
</form>
