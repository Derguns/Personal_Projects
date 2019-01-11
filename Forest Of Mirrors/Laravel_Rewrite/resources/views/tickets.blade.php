@extends('master')
@section('title', 'The Ticketmaster')

@section('content')
<a href='{{ route('battlehub') }}'>
	<div id='returnButton'>
		Battle Hub
	</div>
</a>
<form method="POST" action="{{ route('battleticket') }}">
        <div id='questWords'>
		<img src="{{ asset("images/icons/ticketmaster.png") }}"/>
		<br>
		<br>
		So I heard you found some of my tickets lying around in the depths of the world? I know it sounds strange, me, a normal mage, with some sort of ~magical~ tickets lying around. Well, to be honest, they're not really magic on their own. I can exchange you a random item from my stock of stuff or, if you're really lucky, an egg! Just don't get your hopes too up, ok.
			 Please select the type of ticket you want to appraise, and enter in the box under it the amount of them you would like to give me.
					<hr>
					<div style="display:flex;align-items: center;justify-content: center;width:100%;">
						@foreach(get_user_inventory("21", 0) as $item)
								{!! $item[0] !!}
						@endforeach
					</div>
					@csrf
            
	<div style="display:flex;align-items: center;justify-content: center;width:100%;">
		<button type="submit" id="returnButton" style="margin-right:0px">
		Appraise Ticket
		</button>
	</div>
</div>
</form>

@endsection
