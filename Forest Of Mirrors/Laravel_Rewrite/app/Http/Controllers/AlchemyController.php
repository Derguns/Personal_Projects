<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class AlchemyController extends Controller
{
	public function index(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		$brew = DB::table('adopts_current_brews')
			->where('uid', $user->uid)
			->first();
		if($brew){
			view()->share('current_brew', $brew);
			if($brew->brew_id >= 233){
				view()->share('brew_result', make_item_tooltip($brew->brew_id, 0, 0, 0));
			}
			else{
				$spell = DB::table('adopts_alchemy_spells')
					->where('id', $brew->brew_id)
					->first();
				$brew_image = asset("images/items/alchemy_recipes/{$spell->image_url}.png");
				view()->share('brew_result', "<img src='{$brew_image}'/>");
				view()->share('brew_name', $spell->name);
			}
		}
		else{
			view()->share('current_brew', 'none');
		}
		if(session('form_alert')){
			view()->share('form_alert', session('form_alert'));	
		}		
		$alchemy_list = DB::select("SELECT * FROM `adopts_alchemy_spells` where level <= ? order by level", [$user->lvl]);
		view()->share('alchemys', $alchemy_list);
		$exp = 100;
		if($user->lvl > 1){
			$exp = 500;
			if($user->lvl > 2){
				$exp = 1000;
				if($user->lvl > 3){
					$exp = 1500;
					if($user->lvl > 4){
						$exp = 2500;
						if($user->lvl > 5){
							$exp = 3500;
							if($user->lvl > 6){
								$exp = 5000;
								if($user->lvl > 7){
									$exp = 7500;
									if($user->lvl > 8){
										$exp = 10000;
									}
								}
							}
						}
					}
				}
			}
		}
		$exp_percent = ($user->exp/$exp)*100;
		if($user->lvl >= 10){
			$exp_percent = 100;
		}
		if($exp_percent > 100){
			$exp_percent = 100;
		}
		if($user->clan == 'water'){
			view()->share('color_1', 'rgba(78, 103, 216, 0.7215686274509804)');
			view()->share('color_2', '#2d3176');
		}
		if($user->clan == 'wind'){
			view()->share('color_1', 'rgba(157, 238, 255, 0.7215686274509804)');
			view()->share('color_2', '#69c3c5');
		}
		if($user->clan == 'fire'){
			view()->share('color_1', 'rgba(243, 111, 52, 0.81)');
			view()->share('color_2', '#871c01');
		}
		if($user->clan == 'leaf'){
			view()->share('color_1', 'rgba(18, 99, 18, 0.7215686274509804)');
			view()->share('color_2', '#034914');
		}
		if($user->clan == 'light'){
			view()->share('color_1', 'rgba(226, 195, 90, 0.7215686274509804)');
			view()->share('color_2', '#9c7500');
		}
		if($user->clan == 'dark'){
			view()->share('color_1', 'rgba(111, 36, 44, 0.7215686274509804)');
			view()->share('color_2', '#830016');
		}
		if($user->clan == 'life'){
			view()->share('color_1', 'rgba(80, 208, 80, 0.7215686274509804)');
			view()->share('color_2', '#00a00f');
		}
		if($user->clan == 'stone'){
			view()->share('color_1', 'rgba(121, 80, 31, 0.7215686274509804)');
			view()->share('color_2', '#5c421f');
		}
		view()->share('exp_percent', $exp_percent);
		return view('alchemy');
	}
	public function submit(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		$brew = DB::table('adopts_current_brews')
			->where('uid', $user->uid)
			->first();
		$success_message = "There was an error with the cauldron.";	
		if($brew){
			// Brew ready. 
			if($brew->time_end < time()){
				$spell = DB::table('adopts_alchemy_spells')
					->where('id', $brew->brew_id)
					->where('level', '<=', $user->lvl)
					->first();
				// No spell, brew is smelter.
				if(!$spell){
					$item_image = make_item_tooltip($brew->brew_id, 1, 0, 0);
					if(edit_inventory($brew->brew_id, 1)){
						$success_message = "<div style='width:140px;'>{$item_image}</div><br> You have successfuly gathered your brew!";
						DB::table('adopts_current_brews')
							->where('uid', $user->uid)
							->delete();	
						return Redirect::to('alchemy')->with('form_alert', $success_message);
					}
					else{
						$success_message = "There is an error collecting this brew.";
						send_error("alchemy", "Unable to edit inventory on collect.");
						return Redirect::to('alchemy')->with('form_alert', $success_message);
					}
				}
				else{
					// Alchemy spell for eggs.
					if($spell->type == 0){
						$rare_chance = mt_rand(0,25);
						$item_array = Explode(',', $spell->item_result);
						$item = $item_array[array_rand($item_array)];
						if($rare_chance == 0){
							$adopt = gen_new_egg($item, 1, 1, 1, 1, 'Alchemy');					
						}
						else{
							$adopt = gen_new_egg($item, 0, 1, 1, 1, 'Alchemy');
						}
						if($adopt){
							$success_message = "{$adopt[2]}<br>You reach into the pot and find a {$adopt[0]}!";
							DB::table('adopts_current_brews')
								->where('uid', $user->uid)
								->delete();	
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
						else{
							$success_message = "There was an error collecting the egg from this brew. Make sure you have enough egg slots open!";
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
					}
					// Alchemy spell for items.
					if($spell->type == 1 || $spell->type == 3){
						$item = edit_inventory($spell->item_result, 1);
						$item_image = make_item_tooltip($spell->item_result, 1, 0, 0);
						$actual_item = DB::table('adopts_items')
							->where('id', $spell->item_result)
							->first();
						if($item){
						$success_message = "{$item_image}<br>You reach into the pot and find a {$actual_item->itemname}!";
							DB::table('adopts_current_brews')
								->where('uid', $user->uid)
								->delete();	
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
						else{
							$success_message = "There was an error collecting the potion from this brew.";
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
					}
					// Alchemy spell for companions.
					if($spell->type == 2){
						//$item = edit_companions($spell->item_result, 1);
						$companions = DB::table('adopts_companion_information')
							->where('rarity', $spell->item_result)
							->first();
						if($companions){
							$id_array = [];
							$companion_list = DB::select("SELECT * FROM `adopts_companion_information` where element = ? and rarity =  ? ", [$user->clan, $spell->item_result]);
							foreach($companion_list as $companion){
								array_push($id_array, $companion->id);
								array_push($id_array, $companion->id);
								array_push($id_array, $companion->id);
							}
							$companion_list = DB::select("SELECT * FROM `adopts_companion_information` where element != ? and rarity =  ? ", ["none", $spell->item_result]);
							foreach($companion_list as $companion){
								array_push($id_array, $companion->id);
								array_push($id_array, $companion->id);
							}						
							$companion_list = DB::select("SELECT * FROM `adopts_companion_information` where element = ? and rarity =  ? ", ["none", $spell->item_result]);
							foreach($companion_list as $companion){
								array_push($id_array, $companion->id);
							}
							$companion_id = $id_array[array_rand($id_array)];
							$companion = DB::table('adopts_companion_information')
								->where('id', $companion_id)
								->first();
							$create = edit_companions($companion_id, 1);
							if($create){
								$item_image = make_companion_tooltip($companion_id, 1, 0, 0);
								$success_message = "{$item_image}<br>You reach into the pot and find a {$companion->name}!";
									DB::table('adopts_current_brews')
										->where('uid', $user->uid)
										->delete();	
								return Redirect::to('alchemy')->with('form_alert', $success_message);
							}
							else{
								$success_message = "There was an error collecting the companion from this brew.";
								return Redirect::to('alchemy')->with('form_alert', $success_message);
							}
						}
						else{
							$success_message = "There was an error collecting the companion from this brew.";
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
					}
				}
			}
			// Brew not ready.
			else{
				$success_message = "You already have a brew going!";
				send_error("alchemy", "Unable to brew, active brew going.");
				return Redirect::to('alchemy')->with('form_alert', $success_message);
			}
		}
		//Smelt a creature.
		if($request->get('adoptid')){
			$adopt = DB::table('adopts_owned_adoptables')
				->where('aid', $request->get('adoptid'))
				->where('owner', $user->uid)
				->first();
			if($adopt){
				$adopt_array = adopt_url($adopt->aid);
				$success_message = "{$adopt_array[0]}<br> You have successfully placed {$adopt_array[1]} into the cauldron. Come back when the timer runs out to see the results.";			
				$time_end = time() + 900;
				$items_id = mt_rand(239,242);
				DB::table('adopts_current_brews')->insert(
					['uid' => $user->uid, 'brew_id' => $items_id, 'items_id' => $adopt->aid, 'time_end' => $time_end]
				);				
				DB::table('adopts_owned_adoptables')
					->where('aid', $adopt->aid)
					->where('owner', $user->uid)
					->update(['owner' => '0']);
				update_alchemy_exp(10);
			}
			else{
				send_error("alchemy", "Unable to smelt adopt- adopt not found.");
				$success_message = "There was an error smelting this adopt.";
			}
		}
		//Smelt battle stones.
		if($request->get('itemid')){
			$item = DB::table('adopts_inventory')
				->where('itemname', $request->get('itemid'))
				->where('owner', $user->uid)
				->where('quantity', '>', 9)
				->first();
			if($item){
				if(edit_inventory($item->itemname, -10)){	
					$item_image = make_item_tooltip($item->itemname, ($item->quantity - 10), 0, 0);
					$success_message = "<div style='width:140px;'>{$item_image}</div><br> You have successfully placed 10 battle stones into the cauldron. Come back when the timer runs out to see the results.";			
					$time_end = time() + 900;
					$items_id = mt_rand(233,235);
					DB::table('adopts_current_brews')->insert(
						['uid' => $user->uid, 'brew_id' => $items_id, 'items_id' => $item->itemname, 'time_end' => $time_end]
					);				
					update_alchemy_exp(10);
				}
				else{
					send_error("alchemy", "Unable to smelt item - inventory update failed.");
					$success_message = "There was an error smelting this item.";
				}
			}
			else{
				send_error("alchemy", "Unable to smelt item - item not found in inventory.");
				$success_message = "There was an error smelting this item.";
			}
		}	
		//Smelt companions.
		if($request->get('compid')){
			$item = DB::table('adopts_user_companions')
				->where('owner', $user->uid)
				->where('quantity', '>', 9)
				->first();
			if($item){
				if(edit_companions($item->companion, -10)){	
					$item_image = make_companion_tooltip($item->companion, ($item->quantity - 10), 0, 0);
					$success_message = "<div style='width:140px;'>{$item_image}</div><br> You have successfully placed 10 companions into the cauldron. Come back when the timer runs out to see the results.";			
					$time_end = time() + 900;
					$items_id = mt_rand(236,238);
					DB::table('adopts_current_brews')->insert(
						['uid' => $user->uid, 'brew_id' => $items_id, 'items_id' => $item->companion, 'time_end' => $time_end]
					);
					if(!update_alchemy_exp(10)){
						send_error("alchemy", "Unable to update user Alchemy Experience.");
						$success_message = "There was an error smelting this companion.";
					}
				}
				else{
					send_error("alchemy", "Unable to smelt companion - companion update failed.");
					$success_message = "There was an error smelting this companion.";
				}
			}
			else{
				send_error("alchemy", "Unable to smelt companion - companion not found in inventory.");
				$success_message = "There was an error smelting this companion.";
			}
		}
		//Brew Recipe
		if($request->get('alchemyid')){
			$spell = DB::table('adopts_alchemy_spells')
				->where('id', $request->get('alchemyid'))
				->where('level', '<=', $user->lvl)
				->first();
			if($spell){
				$cost = ($spell->cost * $spell->level);
				if(change_money(0, 1, $cost)){
					$item_array = Explode(",", $spell->item_id_list);
					$item_quant_array = Explode(",", $spell->item_quant_list);
					$item_count = 1;
					$success_message = "<div style='display:flex;align:center;width:500px;'>";
					foreach($item_array as $index => $item){
						$inventory = DB::table('adopts_inventory')
							->where('itemname', $item)
							->where('owner', $user->uid)
							->first();
						if(edit_inventory($item, -$item_quant_array[$index])){	
							$item_image = make_item_tooltip($item, ($inventory->quantity - $item_quant_array[$index]), 0, 0);
							$success_message .= $item_image;			
							$time_end = time() + ($spell->make_time * $spell->level);
							$items_id = $spell->item_result;
						}
						else{
							send_error("alchemy", "Unable to smelt item - inventory update failed.");
							$success_message = "There was an error smelting this item.";
							return Redirect::to('alchemy')->with('form_alert', $success_message);
						}
					}
					$cost = ($spell->cost * $spell->level);
					$success_message .= "</div><br> You have successfully placed your items into the cauldron and paid the brewmaster the fee of <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$cost} Blue Stones. Come back when the timer runs out to see the results.";
					DB::table('adopts_current_brews')->insert(['uid' => $user->uid, 'brew_id' => $request->get('alchemyid'), 'items_id' => $spell->item_id_list, 'time_end' => $time_end]);				
					update_alchemy_exp($spell->exp);
				}
				else{
					$success_message = "You do not have enough blue stones to create this item.";
				}
				return Redirect::to('alchemy')->with('form_alert', $success_message);
			}
			else{
				$success_message = "There was an error smelting this item.";
			}
		}
		return Redirect::to('alchemy')->with('form_alert', $success_message);
	}
	public function smelt_creature(){
		return view('smeltcreature');
	}
	public function smelt_companion(){
		view()->share('inventory', get_companion_inventory(10));
		return view('smeltcompanion');
	}	
	public function smelt_battle(){
		view()->share('inventory', get_user_inventory("2,3,4,5", 10));
		return view('smeltbattle');
	}
	public function battle(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
		$user = user();
		$battle = DB::table('adopts_battles')
			->where('uid', $user->uid)
			->first();
		$message = "Your attack missed! ";
		$extra = "";
		$pause = 0;
		$damage = 0;
		if($id == 777 && (!$battle || $battle->enemy_health <= 0)){
			/* delete the old battle */
			DB::table('adopts_battles')
				->where('uid', $user->uid)
				->delete();
				
			/* generate the new enemy's name and element */
			$enemy_name = DB::select("SELECT * FROM `adopts_aggregiate` where what = 'demon' ORDER BY RAND() LIMIT 1");
			$element = DB::select("SELECT * FROM `adopts_clans` where id != 0 ORDER BY RAND() LIMIT 1");
			$proper = ucfirst($element[0]->clan);

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
			
			/*caclulate accuracy */
			$adopt_accuracy = $spd - $adopt->spd;
			$top_accuracy = 100-($adopt_accuracy*5);
			if($top_accuracy < 50){
				$top_accuracy = 50;
			}
			$adopt_accuracy = mt_rand(50, $top_accuracy);

			$enemy_accuracy = $adopt->spd - $spd;
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
		    $loot = DB::select("SELECT * FROM `adopts_items` where element = '{$element[0]->clan}' and rarity < 6  and item_class != 1 and item_class != 5 and item_class != 6 ORDER BY RAND() LIMIT {$drop}");
			$loot_array = "";
			foreach($loot as $looted){
				$loot_array .= "{$looted->id},";
			}
			DB::table('adopts_battles')->insert(
				['uid' => $user->uid, 'aid' => $battle_pet->favpet, 'reward_list' => $loot_array, 'atk' => $adopt->atk, 'spd' => $adopt->spd,
				'def' => $adopt->def, 'accuracy' => $adopt_accuracy, 'enemy_type' => $element[0]->clan, 'enemy_name' => $enemy_name[0]->value, 'enemy_health' => $max_hp, 'enemy_basehealth' => $max_hp,
				'enemy_atk' => $base_atk, 'enemy_lvl' => $enemy_level,'enemy_spd' => $spd, 'enemy_def' => $def, 'enemy_accuracy' => $enemy_accuracy, 'enemy_status' => 0, 'enemy_turns' => 0, 'active_moves' => NULL
				]
			);
		
			/* return the new message and display. */ 
			return generate_battle_display("{$enemy_name[0]->value} the {$proper} Demon appeared!", 0);
		}
		
		$adopt = DB::table('adopts_owned_adoptables')
		->where('aid', $battle->aid)
		->where('owner', $user->uid)
		->first();
		$adopt_set = DB::table('adopts_adoptables')
			->where('type', $adopt->type)
			->first();
		$moves = Explode(',', $adopt_set->moves);
		
		//Check the move is valid.
		if($id && (in_array($id, $moves) || $id == 100) && $battle && $adopt){ 
		
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
						->update(['atk' => $adopt->atk,'enemy_status' => 0,'spd' => $adopt->spd,'def' => $adopt->def,'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
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
						->update(['atk' => $adopt->atk,'status' => 0,'spd' => $adopt->spd,'def' => $adopt->def,'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
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
						->update(['enemy_status' => 0,'atk' => $adopt->atk,'spd' => $adopt->spd,'def' => $adopt->def,'accuracy' => $battle->accuracy*$multipliers[3],'enemy_atk' => $battle->enemy_atk*$multipliers[4],'enemy_spd' => $battle->enemy_spd*$multipliers[5],'enemy_def' => $battle->enemy_def*$multipliers[6],'enemy_accuracy' => $battle->enemy_accuracy*$multipliers[7],'active_moves' => NULL]);
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
						$damage_heal = round($adopt->def/2);
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