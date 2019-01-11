<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class AdminController extends Controller
{
	public function create_adopt(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		if($user->usergroup == 1){
			return view('createcreature');
		}
		else{
			return Redirect::to('index');
		}
	}
	public function make_adopt(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		if($user->usergroup == 1){
			$magic = 'no';
				if($request->get('attack') == 'magic'){
					$magic = 'yes';
				}
			$physical = 'no';
				if($request->get('attack') == 'physical'){
					$physical = 'yes';
				}
			/* Insert into adoptable table. */
			/* Add: Color, Typename, General Description into the adoptables table. */
			DB::table('adopts_adoptables')->insert(
				['type' => $request->get('adoptname'),
				'class' => $request->get('class'),
				'description' => $request->get('description'),
				'eggimage' => "eggs/{$request->get('eggimage')}",
				'affinity' => $request->get('elements'),
				'creche' => $request->get('rarity'),
				'location' => $request->get('location'),
				'magic' => $magic, 'physical' => $physical,
				'typename' => $request->get('typename'),
				'color' => $request->get('color')]
			);
			/*Insert Start Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 0,
				'requiredclicks' => 0,
				'primaryimage' => "eggs/{$request->get('eggimage')}",
				'alternateimage' => "eggs/{$request->get('eggimage')}",
				'description' => $request->get('eggdescription')]
			);
			/*Insert First Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 1,
				'requiredclicks' => 10,
				'primaryimage' => "eggs/{$request->get('eggimage')}1",
				'alternateimage' => "eggs/{$request->get('eggimage')}1",
				'description' => "{$request->get('eggdescription')} A crack has appeared near the top of the shell!"]
			);
			/*Insert Second Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 2,
				'requiredclicks' => 20,
				'primaryimage' => "eggs/{$request->get('eggimage')}2",
				'alternateimage' => "eggs/{$request->get('eggimage')}2",
				'description' => "{$request->get('eggdescription')} The crack has grown!"]
			);
			/*Insert Third Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 3,
				'requiredclicks' => 30,
				'primaryimage' => "eggs/{$request->get('eggimage')}3",
				'alternateimage' => "eggs/{$request->get('eggimage')}3",
				'description' => "{$request->get('eggdescription')} The crack now spans a third of the shell!"]
			);
			/*Insert Fourth Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 4,
				'requiredclicks' => 40,
				'primaryimage' => "eggs/{$request->get('eggimage')}4",
				'alternateimage' => "eggs/{$request->get('eggimage')}4",
				'description' => "{$request->get('eggdescription')} The crack now covers half of the shell!"]
			);
			/*Insert Fifth Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 5,
				'requiredclicks' => 50,
				'primaryimage' => "eggs/{$request->get('eggimage')}5",
				'alternateimage' => "eggs/{$request->get('eggimage')}5",
				'description' => "{$request->get('eggdescription')} The crack now spans the entire front of the shell!"]
			);
			/*Insert Sixth Egg Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 6,
				'requiredclicks' => 60,
				'primaryimage' => "eggs/{$request->get('eggimage')}6",
				'alternateimage' => "eggs/{$request->get('eggimage')}6",
				'description' => "{$request->get('eggdescription')} A hole has opened up in the front of the shell, and a pair of eyes peek out at you!"]
			);
			/*Insert baby Stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 7,
				'requiredclicks' => 70,
				'primaryimage' => "babies/{$request->get('babyimage')}",
				'alternateimage' => "babies/{$request->get('babyimage')}",
				'description' => "{$request->get('babydescription')}"]
			);
			/*Insert teen stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 8,
				'requiredclicks' => 100,
				'primaryimage' => "teens/{$request->get('teenfemaleimage')}",
				'alternateimage' => "teens/{$request->get('teenmaleimage')}",
				'description' => "{$request->get('teendescription')}"]
			);
			/*Insert adult stage into levels */
			DB::table('adopts_levels')->insert(
				['adoptiename' => $request->get('adoptname'),
				'thisislevel' => 9,
				'requiredclicks' => 150,
				'primaryimage' => "adults/{$request->get('femaleimage')}",
				'alternateimage' => "adults/{$request->get('maleimage')}",
				'description' => "{$request->get('adultdescription')}"]
			);

			return view('createdcreature');
		}
		else{
			return Redirect::to('index');
		}
	}	
}
?>