<form method="POST" action="{{ route('alchemy') }}">
	<center>
        <div class="form-group row">
			 Please select the battle stone that you would like to smelt below.
			 <br> You need ten stones total in order to begin smelting.<br>
                <div class="col-md-6">
					<div style="display:flex;  flex-wrap: wrap;  width:590px;margin-left:20px;">
						@foreach($inventory as $item)
								{!! $item[0] !!}
						@endforeach
					</div>
					@csrf
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Smelt Battle Stones
    </button>
</form>