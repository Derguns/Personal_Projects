@extends('master')
@section('title', 'Managing Tabs')

@section('content')

<body style="">
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
 <!-- Taken from Bootstrap's documentation -->
<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'></button>
        <h4 class='modal-title'>Managing A Tab</h4>
      </div>
      <div class='modal-body'>
        <p>Manage tab page here </p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_tabs.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
<script type="text/javascript">
$(document).ready(function (){
    $('#sortable').sortable({
        axis: 'xy',
        stop: function (event, ui) {
	        var data = $(this).sortable('serialize');
            $('span').text(data);
			$.ajax({
				data: data,
				type: 'POST',
				url: 'http://localhost/laravel/laraveltest/ajaxfiles/updatetaborder.php?uid={{$user->uid}}'
			});
		}
    });
});
</script>
	<a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Add A Tab</div>
	<div id="questWords">
        <form method="POST" action="{{ route('addtab') }}">
            <div class="form-group row">
                <label for="tabname" class="">{{ __('Tab Name') }}</label><br>
                    <div class="col-md-6">
						@csrf
                        <input id="tabname" type="text" name="tabname" style='margin-left:325px; height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;'>
                    </div>

                </div>
            <button type="submit" id="returnButton" style="margin-left:355px">
                {{ __('Add Tab') }}
            </button>
		</form>
	</div>
	<div id="newsView">Managing Creature Tabs</div>
	<div id="questWords">
    <div id="sortable" style="display: flex; flex-wrap:wrap;padding-left:50px;">
		@foreach($tablist as $tab)
			<div id="tab-{{$tab->id}}"><div class="btn btn-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$tab->tab_name}}
			<img src='{{ asset("/images/icons/delete_icon.png") }}'  data-toggle='modal' data-target='.modal' data-task='1' data-tab_id='{{$tab->id}}'></img> <img src='{{ asset("/images/icons/edit.png") }}'  data-toggle='modal' data-target='.modal' data-task='2' data-tab_id='{{$tab->id}}'></img></div></div>
		@endforeach
	</div>
	</div>
	</ul>
	@endsection
