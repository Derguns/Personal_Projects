
@extends('master')
@section('title', 'Create A Creature')
@section('content')
<form method="POST" action="{{ route('adminAdopt') }}">
	<center>
        <div class="form-group row">
            <label for="tabname" class="">Create a Creature</label><br>
			 Please fill out the information below to create a new creature.<br>
			 <center>
                <div>
					@csrf
					<hr>
					Creature General Information:
					<hr>
					<br>Creature Specific Name:<br>
                    <input id="adoptname" type="text" name="adoptname" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Creature General Name:<br>
                    <input id="typename" type="text" name="typename" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Creature General Description:<br>
                    <input id="description" type="text" name="description" value="" style='height:75px;width:420px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Creature Rarity:<br>
					<select name="rarity" id="rarity">
						<option id="1" value="1">Very Common
						</option>
						<option id="2" value="2">Common
						</option>
						<option id="3" value="3">Uncommon
						</option>
						<option id="4" value="4">Rare
						</option>
						<option id="5" value="5">Very Rare
						</option>
						<option id="6" value="6">Event
						</option>
						<option id="7" value="7">Artist ALT
						</option>
						<option id="8" value="8">Alchemy
						</option>
						<option id="9" value="9">Shiny
						</option>
						<option id="10" value="10">Shop or Hybrid
						</option>
					</select>
					<br>Creature Class:<br>
					<select name="class" id="class">
						<option id="dragon" value="dragon">dragon
						</option>
						<option id="drake" value="drake">drake
						</option>
						<option id="amphitere" value="amphitere">amphitere
						</option>
						<option id="anem" value="anem">anem
						</option>
						<option id="amphibian" value="amphibian">amphibian
						</option>
						<option id="wyvern" value="wyvern">wyvern
						</option>
						<option id="wyrm" value="wyrm">wyrm
						</option>
						<option id="beast" value="beast">beast
						</option>
						<option id="chicken" value="chicken">chicken
						</option>
						<option id="goo" value="goo">goo
						</option>
						<option id="steed" value="steed">steed
						</option>
						<option id="pygmy" value="pygmy">pygmy
						</option>
						<option id="wing" value="wing">wing
						</option>
						<option id="anem" value="anem">anem
						</option>
						<option id="lizard" value="lizard">lizard
						</option>
						<option id="long" value="long">long
						</option>
						<option id="sabre" value="sabre">sabre
						</option>
						<option id="phoenix" value="phoenix">phoenix
						</option>
						<option id="canid" value="canid">canid
						</option>
						<option id="gryphon" value="gryphon">gryphon
						</option>
						<option id="glider" value="glider">glider
						</option>
						<option id="twin" value="twin">twin
						</option>
						<option id="inkwell" value="inkwell">inkwell
						</option>
					</select>
					<br>Creature Location:<br>
					<select name="location" id="location">
						<option id="Creche" value="Creche">Creche
						</option>
						<option id="Morado" value="Morado">Morado
						</option>
						<option id="Breeding" value="Breeding">Breeding
						</option>
						<option id="Artist Variant" value="Artist Variant">Artist Variant
						</option>
						<option id="Darklands" value="Darklands">Darklands
						</option>
						<option id="Fishing" value="Fishing">Fishing
						</option>
						<option id="Forest" value="Forest">Forest
						</option>
						<option id="Lost Fields" value="Lost Fields">Lost Fields
						</option>
						<option id="Forest" value="Forest">Forest
						</option>
						<option id="Mountains" value="Mountains">Mountains
						</option>
						<option id="Ocean" value="Ocean">Ocean
						</option>
						<option id="Ruins" value="Ruins">Ruins
						</option>
						<option id="Shinks Area" value="Shinks Area">Shinks Area
						</option>
					</select>
					<br>Creature Elements:<br>
                    <input id="elements" type="text" name="elements" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Creature Color:<br>
					<select name="color" id="color">
						<option id="Red" value="Red">Red
						</option>
						<option id="Blue" value="Blue">Blue
						</option>
						<option id="Yellow" value="Yellow">Yellow
						</option>
						<option id="Green" value="Green">Green
						</option>
						<option id="Orange" value="Orange">Orange
						</option>
						<option id="Purple" value="Purple">Purple
						</option>
						<option id="Black" value="Black">Black
						</option>
						<option id="White" value="White">White
						</option>
					</select>
					<br>Creature Attack Preference:<br>
					<select name="attack" id="attack">
						<option id="magic" value="magic">Magic
						</option>
						<option id="physical" value="physical">Pysical
						</option>
						<option id="none" value="none">None
						</option>
					</select>
					<hr>
					<br>Creature Egg Image Base:<br>
                    <input id="eggimage" type="text" name="eggimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Egg Description:<br>
                    <input id="eggdescription" type="text" name="eggdescription" value="" style='height:75px;width:420px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<hr>
					<br>Baby Image Base:<br>
                    <input id="babyimage" type="text" name="babyimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Baby Description:<br>
                    <input id="babydescription" type="text" name="babydescription" value="" style='height:75px;width:420px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<hr>
					<br>Female Teen Image Base:<br>
                    <input id="teenfemaleimage" type="text" name="teenfemaleimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Male Teen Image Base:<br>
                    <input id="teenmaleimage" type="text" name="teenmaleimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Teen Description:<br>
                    <input id="teendescription" type="text" name="teendescription" value="" style='height:75px;width:420px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<hr>
					<br>Female Image Base:<br>
                    <input id="femaleimage" type="text" name="femaleimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Male Image Base:<br>
                    <input id="maleimage" type="text" name="maleimage" value="" style='height:25px;width:210px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
					<br>Adult Description:<br>
                    <input id="adultdescription" type="text" name="adultdescription" value="" style='height:75px;width:420px;border-radius:10px;padding:3px;padding-left:7px;' required autofocus>
				</div>
            </div>
    <button type="submit" id="returnButton" >
    Create Creature
    </button>
	</center>
	</center>
</form>
 @endsection
