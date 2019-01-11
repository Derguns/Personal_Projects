<form method="POST" action="{{ route('battlehub') }}">
	<center>
        <div class="form-group row" style='padding:2px;'>
				{!! $adopt[0] !!}
				<br>
				It seems your battle champion has suffered damage, {{$health}} points to be exact!<br> I can patch them up for 50<img src="{{ asset("images/icons/orb4.png") }}"/> blue stones for each point or 1<img src="{{ asset("images/icons/orb5.png") }}"/> reactor stone for each ten.
				<br>Just select the option below you'd like to purchase and give me a bit and they'll be back to stat! You can also wait for their health to go back up over time, as they'll heal 25% each hour.
				<hr>
				<div class="col-md-6" style='margin-left:90px;'>
					@csrf
                    <label for="bluestones" class="" style="display:float;float:left;margin-bottom:-15%;margin-left:60%;">
						<img src="{{ asset("images/icons/orb4.png") }}"/> {{$bscost}}
					</label>
					<input id="bluestones" type="radio" name="stones" value="bluestones" style='width:30px;' required autofocus>
					<br>
                    <label for="reactorstones" class="" style="display:float;float:left;margin-bottom:-15%;margin-left:60%;">
						<img src="{{ asset("images/icons/orb5.png") }}"/> {{$rscost}}
					</label>
						<input id="reactorstones" type="radio" name="stones" value="reactorstones" style='width:30px;margin-left:-5px' required autofocus>
				</div>
            </div>
		</center>
	<div style="display:flex;align-items: center;justify-content: center;width:100%;margin-right:0px;">
    <button type="submit" id="returnButton" style='margin-right:0px;'>
    Heal Champion
    </button>
	</div>
</form>
