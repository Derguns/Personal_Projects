<form method="POST" action="{{ route('battlehub') }}">
	<center>
        <div class="form-group row">
			{!! $adopt_image[0] !!}<br>
			 Please select the training plan that you would like to purchase for {!! $adopt_image[1] !!} below. Each plan earns your battle champion different amounts of experience, but at the cost of a hefty sum of blue stones.<br>
				<hr> 
					@csrf

				<div style="display:flex;align-items: center;justify-content: center;width:90%">
				<div style="margin-left:2px;width:150px!important;height:150px!important;" >
					<input id="itemid213" type="radio" name="itemid" value="123" style="margin-bottom:-10px;margin-left:21%;position: absolute;z-index: 5;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid213]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});"> 
					<label for="itemid213" class="itemid213" style="position: relative;border-radius:10px;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid213]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});">
							<div style="text-shadow: 1px 1px 1px #594848;font-size:10px;margin-top: 5px;display: float;margin-left: 5px;position: absolute;float: left;width:80px;">10,000 BS <img src="{{ asset("images/icons/orb4.png") }}"/>
							</div>
							<div style="width:150px!important;height:150px!important;display:table-cell;text-align:center;vertical-align:middle;border:2px solid;border-radius:10px;border-color:#abd5ff;background-color:rgba(144, 171, 189, 0.8196078431372549);">
								<img src='{{ asset("images/icons/level_up.png") }}'/><br><div style="text-shadow: 1px 1px 1px #000000;font-size:10px;margin-top: 5px;color:white;">Basic Training</div><br><div style='font-size:10px;'>An 8-hour training session equivalent to defeating around 25-35 enemies.</div>
							</div>
					</label>
				</div>
				<div style="margin-left:2px;width:150px!important;height:150px!important;" >
					<input id="itemid214" type="radio" name="itemid" value="124" style="margin-bottom:-10px;margin-left:21%;position: absolute;z-index: 5;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid214]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});"> 
					<label for="itemid214" class="itemid214" style="position: relative;border-radius:10px;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid214]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});">
							<div style="text-shadow: 1px 1px 1px #594848;font-size:10px;margin-top: 5px;display: float;margin-left: 5px;position: absolute;float: left;width:80px;">25,000 BS <img src="{{ asset("images/icons/orb4.png") }}"/>
							</div>
							<div style="width:150px!important;height:150px!important;display:table-cell;text-align:center;vertical-align:middle;border:2px solid;border-radius:10px;border-color:#abd5ff;background-color:rgba(144, 171, 189, 0.8196078431372549);">
								<img src='{{ asset("images/icons/war_train.png") }}'/><br><div style="text-shadow: 1px 1px 1px #000000;font-size:10px;margin-top: 5px;color:white;">Endurance Training</div><br><div style='font-size:10px;'>An 16-hour training session equivalent to defeating around 50-75 enemies.</div>
							</div>
					</label>
				</div>
				<div style="margin-left:2px;width:150px!important;height:150px!important;" >
					<input id="itemid215" type="radio" name="itemid" value="125" style="margin-bottom:-10px;margin-left:21%;position: absolute;z-index: 5;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid215]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});"> 
					<label for="itemid215" class="itemid215" style="position: relative;border-radius:10px;" onclick="$('label').find('div').css({'background-color' : 'rgba(116, 116, 138, 0.8196078431372549)', 'border-radius' : '10px'});$('label[for=itemid215]').find('div').css({'background-color' : 'rgba(171, 171, 255, 0.8196078431372549);', 'border-radius' : '10px'});">
							<div style="text-shadow: 1px 1px 1px #594848;font-size:10px;margin-top: 5px;display: float;margin-left: 5px;position: absolute;float: left;width:80px;">50,000 BS <img src="{{ asset("images/icons/orb4.png") }}"/>
							</div>
							<div style="width:150px!important;height:150px!important;display:table-cell;text-align:center;vertical-align:middle;border:2px solid;border-radius:10px;border-color:#abd5ff;background-color:rgba(144, 171, 189, 0.8196078431372549);">
								<img src='{{ asset("images/icons/master_train.png") }}'/><br><div style="text-shadow: 1px 1px 1px #000000;font-size:10px;margin-top: 5px;color:white;">War Training</div><br><div style='font-size:10px;'>An 24-hour training session equivalent to defeating around 125-200 enemies.</div>
							</div>
					</label>
				</div>
				</div>
            </div>
		</center>
	<div style="display:flex;align-items: center;justify-content: center;width:100%;">
    <button type="submit" id="returnButton" style='margin-right:0px;'>
    Train Champion
    </button>
	</div>
</form>
