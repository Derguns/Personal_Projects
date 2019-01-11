<form method="POST" action="{{ route('addtab') }}">
	<center>
        <div class="form-group row">
            <label for="tabname" class="">Where to Move Creatures:</label><br>
                <div class="col-md-6">
					@csrf
                    <select name="movetab" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;background-color:white;' required autofocus>
					@foreach($tablist as $tab)
						 <option value="{{$tab->id}}">{{$tab->tab_name}}</option>
					@endforeach
					</select>
					<input type="hidden" name="deletetabid" value="{{$tab_id}}"/>
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Delete Tab
    </button>
</form>
