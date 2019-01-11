<form method="POST" action="{{ route('addtab') }}">
	<center>
        <div class="form-group row">
            <label for="tabname" class="">Renaming A Tab</label><br>
                <div class="col-md-6">
					@csrf
                    <input id="retabname" type="text" name="retabname" value="{{$tab_name}}" style='margin-left:182px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<input type="hidden" name="tabid" value="{{$tab_id}}"/>
				</div>
            </div>
		</center>
    <button type="submit" id="returnButton" style="margin-left:210px">
    Rename Tab
    </button>
</form>
