<form method="POST" action="{{ route('battlehub') }}">
	<center>
        <div class="form-group row">
			 Please enter the ID of the creature that you want to become your battle champion. Please note- they must be an adult!<br>
                <div class="col-md-6">
					@csrf
                    <input id="adoptid" type="text" name="adoptid" value="" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
				</div>
            </div>
		</center>
	<div style="display:flex;align-items: center;justify-content: center;width:100%;">
    <button type="submit" id="returnButton" style='margin-right:0px;'>
    Train Champion
    </button>
	</div>
</form>
