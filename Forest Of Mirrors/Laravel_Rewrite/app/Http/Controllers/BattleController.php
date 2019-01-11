<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class BattleController extends Controller
{
	public function index(){
		$user = user();
		if($user){
			view()->share("turns", $user->battle_charges);
			return view('battle');
		}
		else{
			return view("login");
		}
	}
	
	public function hub(){
		$user = user();
		if($user){
			$battle_pet = DB::table('adopts_users_profile')
				->where('username', $user->username)
				->first();
			$adopt = DB::table('adopts_owned_adoptables')
				->where('aid', $battle_pet->favpet)
				->where('owner', $user->uid)
				->first();
			view()->share('adopt', $adopt);
			$train = DB::table('adopts_training')
				->where('uid', $user->uid)
				->first();
			view()->share('train', $train);				
			view()->share('adopt', $adopt);				
			if($adopt){
				$adopt_image = adopt_url($adopt->aid);
				$stones = DB::select("SELECT * FROM `adopts_battle_stones` where aid = ? and uid = ?", [$adopt->aid, $user->uid]);
				view()->share('stones', $stones);
				view()->share('adopt_image', $adopt_image);	
				view()->share('stats', generate_adopt_stats($adopt->aid));
			}
			return view("hub");
		}
		else{
			return view("login");
		}
	}

	public function hubsub(Request $request){
		$user = user();
		if(!$user){
			return view("login");
		}
		$sucess_message = "error";
		$success_message = "There was an error submitting your request. Try again.";
		$battle_pet = DB::table('adopts_users_profile')
			->where('username', $user->username)
			->first();
		$adopt = DB::table('adopts_owned_adoptables')
			->where('aid', $battle_pet->favpet)
			->where('owner', $user->uid)
			->first();
		view()->share('adopt', $adopt);	
		
		$train = DB::table('adopts_training')
			->where('uid', $user->uid)
			->first();
		view()->share('train', $train);	
	
		if($adopt){
			$stones = DB::select("SELECT * FROM `adopts_battle_stones` where aid = ? and uid = ?", [$adopt->aid, $user->uid]);
			view()->share('stones', $stones);
			view()->share('stats', generate_adopt_stats($adopt->aid));
			$adopt_image = adopt_url($adopt->aid);
			view()->share('adopt_image', $adopt_image);
		}
		if($request->get('training') && $train){
			if($train->time_end <= time()){
				$message = calculate_battle_exp($train->exp_earned, $train->aid);
				$adopted_image = adopt_url($train->aid);
				$success_message = "{$adopted_image[0]}<br> You have collected {$adopted_image[1]} from training!<br>{$message}";
				DB::table('adopts_training')
					->where('uid', $user->uid)
					->delete();
				$train = NULL;
				view()->share('train', $train);	
			}
		}
		if($request->get('itemid') && $adopt && !$train){
			$error = false;
			if($request->get('itemid') == 123){
				$cost = 10000;
				$hours = 8;
				$amount = mt_rand(25,35);
			}
			elseif($request->get('itemid') == 124){
				$cost = 25000;
				$hours = 16;
				$amount = mt_rand(50,75);
			}
			elseif($request->get('itemid') == 124){
				$cost = 50000;
				$hours = 24;
				$amount = mt_rand(125,200);
			}
			else{
				$error = true;
			}
			if(change_money(0,1,$cost) && !$error){
				$success_message = "{$adopt_image[0]}<br>You have successfully sent in {$adopt_image[1]} for an {$hours}-hour training session.";
				$exp = $amount*(5+(((1 * ($adopt->lvl) * ($adopt->lvl))/5)*(((pow((2*$adopt->lvl)+10,2.5))/(pow(($adopt->lvl+$adopt->lvl+10),2.5))))));
				$time_end = time() + (3600*$hours);
				DB::table('adopts_training')->insert(
					['uid' => $user->uid, 'aid' => $adopt->aid, 'time_end' => $time_end, 'exp_earned' => $exp]
				);					
			}
			else{
				$success_message = "You do not have enough blue stones to cover the {$cost} <img src='{$bs_image}'/> Blue Stones cost!";
			}
		}
		else if($request->get('adoptid')){
			$adopt = DB::table('adopts_owned_adoptables')
				->where('aid', $request->get('adoptid'))
				->where('currentlevel', 9)
				->where('owner', $user->uid)
				->first();
			if($adopt){
				DB::table('adopts_battles')
					->where('uid', $user->uid)
					->delete();
				DB::table('adopts_users_profile')
					->where('username', $user->username)
					->update(['favpet' => $request->get('adoptid')]);
				$stones = DB::select("SELECT * FROM `adopts_battle_stones` where aid = ? and uid = ?", [$adopt->aid, $user->uid]);
				view()->share('stones', $stones);
				view()->share('adopt', $adopt);	
				view()->share('stats', generate_adopt_stats($adopt->aid));
					
				$adopt_image = adopt_url($adopt->aid);
				view()->share('adopt_image', $adopt_image);		
				$success_message = "{$adopt_image[0]}<br>Your creature {$adopt_image[1]} has been selected as your battle champion.";
			}
			else{
				$success_message = "<br>Your creature was unable to be selected as your battle champion.";
			}
		}
		else if($request->get('stones') == 'bluestones' && $adopt){
			$cost = ($adopt->basehp - $adopt->maxhp)*-1;
			$bscost = $cost * 50;
			$bs_image = asset('images/icons/orb4.png');
			
			if(change_money(0,1,$bscost)){				
				//Update the  health. 
				DB::table('adopts_owned_adoptables')
					->where('aid', $adopt->aid)
					->where('owner', $user->uid)
					->update(['basehp' => $adopt->maxhp]);
				$success_message = "{$adopt_image[0]}<br>You healed your creature {$adopt_image[1]} for {$bscost}<img src='{$bs_image}'/> Blue Stones!";
			}
			else{
				$success_message = "You do not have enough blue stones to cover the {$bscost}<img src='{$bs_image}'/> Blue Stones cost!";
			}
		}
		else if($request->get('stones') == 'reactorstones' && $adopt){
			$cost = ($adopt->basehp - $adopt->maxhp)*-1;
			$bscost = $cost * 50;
			$rscost = ceil($bscost/500);
			$rs_image = asset('images/icons/orb5.png');
			
			if(change_money(1,1,$rscost)){
				//Update the  health. 
				DB::table('adopts_owned_adoptables')
					->where('aid', $adopt->aid)
					->where('owner', $user->uid)
					->update(['basehp' => $adopt->maxhp]);
				$success_message = "{$adopt_image[0]}<br>You healed your creature {$adopt_image[1]} for {$rscost}<img src='{$rs_image}'/> Reactor Stones!";
			}
			else{
				$success_message = "You do not have enough reactor stones to cover the {$rscost}<img src='{$rs_image}'/> Reactor Stones cost!";
			}
		}
		view()->share('form_alert', $success_message);	
		return view("hub");
	}

	public function heal(){
		$user = user();
		if(!$user){
			return view("login");
		}
		$battle_pet = DB::table('adopts_users_profile')
			->where('username', $user->username)
			->first();
		$adopt = DB::table('adopts_owned_adoptables')
			->where('aid', $battle_pet->favpet)
			->where('owner', $user->uid)
			->first();
		if($adopt){
			view()->share("adopt", adopt_url($adopt->aid));
			$cost = ($adopt->basehp - $adopt->maxhp)*-1;
			$bscost = $cost * 50;
			$rscost = ceil($bscost/500);
			view()->share("health", $cost);
			view()->share("bscost", $bscost);
			view()->share("rscost", $rscost);
			return view("heal");
		}
		return "You need to have a battle champion to use this option!";
	}
	
	public function buddy(){
		$user = user();
		if(!$user){
			return view("login");
		}
		return view("buddy");
	}

	public function ticket(){
		$user = user();
		if(!$user){
			return view("login");
		}
		return view("tickets");
	}
	
	public function train(){
		$user = user();
		if(!$user){
			return view("login");
		}
		$battle_pet = DB::table('adopts_users_profile')
			->where('username', $user->username)
			->first();
		$adopt = DB::table('adopts_owned_adoptables')
			->where('aid', $battle_pet->favpet)
			->where('owner', $user->uid)
			->first();
		if($adopt){
			view()->share('adopt', $adopt);
			view()->share('adopt_image', adopt_url($adopt->aid));
			return view('train');
		}
		return "You need to have a battle champion to use this option!";
	}
	
	public function initiate_the_starting_battle_now(){
		$user = user();
		if(!$user){
			return view("login");
		}
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
        $location = $parts[count($parts) - 2];
		$user = user();
		$battle = DB::table('adopts_battles')
			->where('uid', $user->uid)
			->first();
		$message = "Your attack missed! ";
		$extra = "";
		$pause = 0;
		$damage = 0;
		if($id == 555){
			DB::table('adopts_battles')
				->where('uid', $user->uid)
				->delete();
				
			switch(mt_rand(0,9)){
				case 0:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully fled from the demon {$battle->enemy_name}'s corrupting clutches!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div>
							</div>";
					break;
				case 1:
					return "<div style='margin-left:-15px;'><div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully broken free from the demon {$battle->enemy_name}'s twisting talons!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 2:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully escaped the demon {$battle->enemy_name}'s  gnarled gaze!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 3:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully sprinted away from the demon {$battle->enemy_name}'s rotting lair!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 4:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully wrought yourself free the demon {$battle->enemy_name}'s wicked trap!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 5:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully evaded the foul ire of the demon {$battle->enemy_name}!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 6:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully avoided the demon {$battle->enemy_name}'s unending wrath!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 7:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully eluded the sharpened daggers of the demon {$battle->enemy_name}!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 8:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully shunned the malice of the demon {$battle->enemy_name}!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
				case 9:
					return "<div style='margin-left:-15px;'><div id='newsView'>Successfully Fled!</div>
								<div id='questWords'>You have successfully eshewn the demon {$battle->enemy_name}'s invitation to battle!<br><br><div id='returnButton' onClick='load(777)' style='margin-left:355px'>Start Battle</div></div></div>";
					break;
			}
		}
		if($id == 777 && (!$battle || $battle->enemy_health <= 0)){
			/* delete the old battle */
			DB::table('adopts_battles')
				->where('uid', $user->uid)
				->delete();
			if($user->battle_charges > 0){
				/* generate the new enemy's name and element */
				$enemy_name = DB::select("SELECT * FROM `adopts_aggregiate` where what = 'demon' ORDER BY RAND() LIMIT 1");
				
				$element_random = mt_rand(0,15);
				if($location == 0){
					$elements = ['dark','dark','light','light','fire','fire','water','water','wind','wind','leaf','leaf','life','life','stone','stone'];
				}
				if($location == 1){
					$elements = ['stone','dark','stone','light','life','fire','stone','stone','life','wind','stone','leaf','life','water','life','stone'];
				}
				if($location == 2){
					$elements = ['dark','dark','dark','dark','wind','fire','dark','water','wind','wind','dark','leaf','wind','life','stone','dark'];
				}
				if($location == 3){
					$elements = ['fire','dark','light','light','fire','fire','light','water','fire','wind','light','wind','fire','stone','stone','stone'];
				}
				if($location == 4){
					$elements = ['leaf','dark','leaf','light','dark','life','leaf','water','wind','dark','leaf','leaf','life','life','stone','leaf'];
				}
				if($location == 5){
					$elements = ['dark','water','dark','water','wind','leaf','water','water','wind','wind','leaf','leaf','water','life','water','stone'];
				}
				if($location == 6){
					$elements = ['dark','wind','light','wind','wind','fire','stone','water','stone','wind','wind','leaf','stone','life','stone','stone'];
				}
				if($location == 7){
					$elements = ['dark','light','light','light','life','fire','water','dark','wind','life','leaf','light','life','dark','stone','life'];
				}
				if($location == 8){
					$elements = ['light','dark','light','light','fire','dark','water','fire','wind','wind','dark','leaf','life','life','dark','stone'];
				}
				$element = $elements[$element_random];
				$proper = ucfirst($element);

				/* generate the battle */
				$battle_pet = DB::table('adopts_users_profile')
					->where('username', $user->username)
					->first();
				$adopt = DB::table('adopts_owned_adoptables')
					->where('aid', $battle_pet->favpet)
					->where('owner', $user->uid)
					->first();
					
				/*generate the new stats for the enemy */
				$enemy_scale = mt_rand(50,150);
				$enemy_scale = $enemy_scale/100;
				$enemy_level = mt_rand($adopt->lvl-5, $adopt->lvl+5);
				if($enemy_level < 1){
					$enemy_level = 1;
				}
				$base_atk = (($enemy_level) * mt_rand(1,3))* $enemy_scale;
				$max_hp = (($enemy_level) * mt_rand(3,5))* $enemy_scale;
				$spd = (($enemy_level) * mt_rand(1,3))* $enemy_scale;
				$def = (($enemy_level) * mt_rand(1,3))* $enemy_scale;
				
				$stats = generate_adopt_stats($adopt->aid);
				/*caclulate accuracy */
				$adopt_accuracy = $spd - $stats[1];
				$top_accuracy = 100-($adopt_accuracy*5);
				if($top_accuracy < 50){
					$top_accuracy = 50;
				}
				$adopt_accuracy = mt_rand(50, $top_accuracy);

				$enemy_accuracy = $stats[1] - $spd;
				$enemy_accuracy = mt_rand(0, (100-($enemy_accuracy*5)));
				
				/* caclulate the loot */
				/* loot amount */
				$loot_chance = mt_rand(0,100);
				$drop = 0;
				if($loot_chance > 15){
					$drop = 1;
				}
				if($loot_chance > 40){
					$drop = 2;
				}
				if($loot_chance > 60){
					$drop = 3;
				}
				if($loot_chance > 80){
					$drop = 4;
				}
				if($loot_chance > 95){
					$drop = 5;
				}
				$loot = DB::select("SELECT * FROM `adopts_items` where (element = '{$element}' and rarity < 6  and (item_class = 2 or item_class = 3 or item_class = 4 or item_class = 0)) or item_class = 21 ORDER BY RAND() LIMIT {$drop}");
				$loot_array = "";
				foreach($loot as $looted){
					$loot_array .= "{$looted->id},";
				}
				DB::table('adopts_battles')->insert(
					['uid' => $user->uid, 'aid' => $battle_pet->favpet, 'reward_list' => $loot_array, 'atk' => $stats[0], 'spd' => $stats[1],
					'def' => $stats[2], 'accuracy' => $adopt_accuracy, 'enemy_type' => $element, 'enemy_name' => $enemy_name[0]->value, 'enemy_health' => $max_hp, 'enemy_basehealth' => $max_hp,
					'enemy_atk' => $base_atk, 'enemy_lvl' => $enemy_level,'enemy_spd' => $spd, 'enemy_def' => $def, 'enemy_accuracy' => $enemy_accuracy, 'enemy_status' => 0, 'enemy_turns' => 0, 'active_moves' => NULL
					]
				);
				DB::table('adopts_users')
					->where('uid', $user->uid)
					->where('username', $user->username)
					->update(['battle_charges' => $user->battle_charges-1]);				
				/* return the new message and display. */ 
				return generate_battle_display("{$enemy_name[0]->value} the {$proper} Demon appeared!", 0);
			}
			else{
				return "<div style='margin-left:-15px;'><div id='newsView'>No more charges!</div>
						<div id='questWords'>You have run out of battle charges for the hour! Come back soon to get more, or use an item to replenish them.</div></div>";
			}
		}
		
		$adopt = DB::table('adopts_owned_adoptables')
		->where('aid', $battle->aid)
		->where('owner', $user->uid)
		->first();
		$adopt_set = DB::table('adopts_adoptables')
			->where('type', $adopt->type)
			->first();
		$moves = Explode(',', $adopt_set->moves);
		$stats = generate_adopt_stats($adopt->aid);
		
		//Check the move is valid.
		if($id && (in_array($id, $moves) || $id == 100) && $battle && $adopt && $adopt->basehp > 0 && $battle->enemy_health > 0){ 
		
			//health stacking if the enemy has a stacking status effect. 
			$status = DB::table('adopts_status_effects')
			->where('id', $battle->enemy_status)
			->first();
			if($status && $status->stacking == 1 && $battle->enemy_turns > 0){
				$hp = $battle->enemy_health*$status->hp;
				if($hp < 0){
					$hp = 0;
				}
				if($hp > $battle->enemy_basehealth){
					$hp = $battle->enemy_basehealth;
				}
				DB::table('adopts_battles')
					->where('id', $battle->id)
					->where('uid', $user->uid)
					->update(['enemy_health' => $hp]);
				$battle = DB::table('adopts_battles')
					->where('uid', $user->uid)
					->first();	
				$extra = "Your enemy suffered from their status effect {$status->name}!";
			}

			//health stacking if the player has a stacking status effect. 
			$status = DB::table('adopts_status_effects')
			->where('id', $battle->status)
			->first();
			if($status && $status->stacking == 1 && $battle->turns > 0){
				$hp = $adopt->basehp*$status->hp;
				if($hp < 0){
					$hp = 0;
				}
				if($hp > $adopt->maxhp){
					$hp = $adopt->maxhp;
				}
				DB::table('adopts_owned_adoptables')
					->where('aid', $battle->aid)
					->where('owner', $user->uid)
					->update(['basehp' => $hp]);
				$extra = "Your status effect {$status->name} has affected you!";
			}
			
			//Reset the enemy's status effects if it has worn off. (no accuracy check.)
			$enemy_turns = $battle->enemy_turns;
			if($enemy_turns > 0){
				$enemy_turns = $battle->enemy_turns - 1;
				DB::table('adopts_battles')
					->where('id', $battle->id)
					->where('uid', $user->uid)
					->update(['enemy_turns' => ($enemy_turns)]);	
				if($enemy_turns == 0){
					$multipliers =  Explode(',', $battle->active_moves);
					DB::table('adopts_battles')
						->where('id', $battle->id)
						->where('uid', $user->uid)
						->update(['atk' => $stats[0],'enemy_status' => 0,'spd' => $stats[1],'def' => $stats[2],'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
					$battle = DB::table('adopts_battles')
						->where('uid', $user->uid)
						->first();
				}
			}

			//Reset the player's status effects if it has worn off. (no accuracy check.)
			$player_turns = $battle->turns;
			if($player_turns > 0){
				$player_turns = $battle->turns - 1;
				DB::table('adopts_battles')
					->where('id', $battle->id)
					->where('uid', $user->uid)
					->update(['turns' => ($player_turns)]);	
				if($player_turns == 0){
					$multipliers =  Explode(',', $battle->active_moves);
					DB::table('adopts_battles')
						->where('id', $battle->id)
						->where('uid', $user->uid)
						->update(['atk' => $stats[0],'status' => 0,'spd' => $stats[1],'def' => $stats[2],'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
					$battle = DB::table('adopts_battles')
						->where('uid', $user->uid)
						->first();
				}
			}
			
			//check accuracy
			if((mt_rand(0, $battle->accuracy) > mt_rand(0, $battle->enemy_accuracy)) || ((mt_rand(0,$battle->enemy_spd) < mt_rand(0,$battle->spd))) || $id == 100 || $id == 12){		
				//Reset on status moves.
				$move = DB::table('adopts_creature_attacks')
					->where('id', $id)
					->first();
				if($battle->active_moves != NULL && $move && $move->applies_status != 0){
					$multipliers =  Explode(',', $battle->active_moves);
					DB::table('adopts_battles')
						->where('id', $battle->id)
						->where('uid', $user->uid)
						->update(['enemy_status' => 0,'atk' => $stats[0],'spd' => $stats[1],'def' => $stats[2],'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
					$battle = DB::table('adopts_battles')
						->where('uid', $user->uid)
						->first();
				}
				
				//Skip turn.
				if($id == 100){
					if($battle->skip_turn > 0){
					DB::table('adopts_battles')
						->where('id', $battle->id)
						->where('uid', $user->uid)
						->update(['skip_turn' => ($battle->skip_turn-1)]);	
					}
					$message = "You have done nothing this turn.";
				}
				
				//Ebony Abyss.
				if($id == 29){
					$damage = 0;
					$enemy_spd = $battle->enemy_spd*.5;
					$enemy_accuracy = $battle->enemy_accuracy*.9;
					$player_accuracy = $battle->accuracy*.9;
					DB::table('adopts_battles')
						->where('id', $battle->id)
						->where('uid', $user->uid)
						->update(['enemy_spd' => $enemy_spd, 'enemy_turns' => 100, 'accuracy' => $player_accuracy, 'enemy_accuracy' => $enemy_accuracy, 'active_moves' => "1,1,1,1.1111,1,2,1,1.1111"]);				
					$message  = "You cast <b>Ebony Abyss</b>! Your enemy has had their speed reduced by 50%, and both you and the enemy have had their accuracy reduced by 10%.";
				}
				
				//heal 
				if($id == 12 || $id == 26 || $id == 39 || $id == 40){
					$extra = '';
					if($id == 12){
						$damage_heal = round($stats[2]/2);
					}
					if($id == 39){
						$damage_heal = round($adopt->maxhp/10);
					}
					if($id == 40){
						$damage_heal = round($adopt->maxhp/4);
					}
					if($id == 26){
						$damage_heal = round($adopt->maxhp/2);
						$turns = mt_rand(1,4);
						DB::table('adopts_battles')
							->where('id', $battle->id)
							->where('uid', $user->uid)
							->update(['skip_turn' => $turns]);
						$extra = "You have been frozen for {$turns} turns!";
					}
					$healed_damage = $adopt->basehp + ($damage_heal);
					$status = "You have healed for {$damage_heal} damage!";
					if($healed_damage > $adopt->maxhp){
						$healed_damage = $adopt->maxhp;
					}
					
					DB::table('adopts_owned_adoptables')
						->where('aid', $battle->aid)
						->where('owner', $user->uid)
						->update(['basehp' => $healed_damage]);

					$message = "You cast {$move->name}! {$status}";
				}
				
				//Damage and status effects.
			    if($id == 41 || $id == 30 || $id == 32 || $id == 1 || $id == 33 || $id == 34 || $id == 35 || $id == 36 || $id == 37 || $id == 38 || $id == 6 || $id == 7 || $id == 9 || $id == 10 || $id == 14 || $id == 16 || $id == 17 || $id == 18 || $id == 19 || $id == 21 || $id == 24 || $id == 25){
					$damage = generate_battle_damage($id);
					$damage =  round($damage);
					if($move->applies_status != 0){
						if($id == 18){
							$status = generate_status_check($id, 'player');	
						}
						else{
							$status = generate_status_check($id);
						}
					}
					$message = "You dealt {$damage} {$move->element} damage! {$status}";

					if($id == 30){
						DB::table('adopts_battles')
							->where('id', $battle->id)
							->where('uid', $user->uid)
							->update(['skip_turn' => 1]);	
					}
					if($id == 25){
						$damage_heal = round($damage * .25);
						$healed_damage = $adopt->basehp - ($damage_heal);
						$status = "You have also were hurt for {$damage_heal} damage!";
						if($healed_damage < 0){
							$healed_damage = 0;
						}
						$message .= $status;
						DB::table('adopts_owned_adoptables')
							->where('aid', $battle->aid)
							->where('owner', $user->uid)
							->update(['basehp' => $healed_damage]);
					}
					
				}
				
				//Damage and heal. 
				if($id == 3){			
					$damage = generate_battle_damage($id);
					$damage =  round($damage);
					$damage_heal = round($damage * $move->multiplier);
					$healed_damage = $adopt->basehp + ($damage_heal);
					$status = "You have also healed for {$damage_heal} damage!";
					if($healed_damage > $adopt->maxhp){
						$healed_damage = $adopt->maxhp;
						$status = "You are already at max health so you did not heal.";
					}
					
					DB::table('adopts_owned_adoptables')
						->where('aid', $battle->aid)
						->where('owner', $user->uid)
						->update(['basehp' => $healed_damage]);

					$message = "You dealt {$damage} {$move->element} damage! {$status}";
				}
				
				//Straight status effect enemy.
				if($id == 2 || $id == 4 || $id == 5 || $id == 11 || $id == 20 || $id == 27 || $id == 42){
					$status = generate_status_check($id);	
					$message  = "You cast <b>{$move->name}</b>!<br> {$status}.";
					$battle = DB::table('adopts_battles')
						->where('uid', $user->uid)
						->first();
				}
				
				//Straight status effect player.
				if($id == 8 || $id == 13 || $id == 15 || $id == 22 || $id == 23 || $id == 28 || $id == 31){
					$status = generate_status_check($id, 'player');	
					$message  = "You cast <b>{$move->name}</b>!<br> {$status}.";
				}
			}
			//Enemy Attacks!
			//check accuracy
			$enemy_damage = 0;
			$battle = DB::table('adopts_battles')
				->where('uid', $user->uid)
				->first();	
			if(((mt_rand(0, $battle->accuracy) < mt_rand(0, $battle->enemy_accuracy)) || ((mt_rand(0,$battle->enemy_spd) > mt_rand(0,$battle->spd)))) && ($battle->enemy_status != 16 && $enemy_turns <= 0)){
				$messages = generate_battle_damage_enemy();
				$enemy_damage = $messages[1];
				$message .= "<hr>{$messages[0]} It did {$messages[1]} damage!";
			}
			else{
				$message .= "<hr>The enemy missed their attack!";
			}
			
			//Update the player health. 
			$hp = $adopt->basehp-$enemy_damage;
			if($hp <= 0){
				$hp = 0;
				$message .="<hr><b>You health has fallen to 0! You must heal before you can continue battling.</b>";
			}
			DB::table('adopts_owned_adoptables')
				->where('aid', $battle->aid)
				->where('owner', $user->uid)
				->update(['basehp' => $hp]);

			//Update enemy health.
			$health = $battle->enemy_health - $damage;
			if($health <= 0){
				$health = 0;
				$message .= "<hr><b>You won! View your rewards below and continue to battle onwards!</b>";
				$extra = "";
			}
			DB::table('adopts_battles')
				->where('id', $battle->id)
				->where('uid', $user->uid)
				->update(['enemy_health' => $health]);

			return generate_battle_display("{$message}{$extra}", $pause);
		}
	}
}
?>