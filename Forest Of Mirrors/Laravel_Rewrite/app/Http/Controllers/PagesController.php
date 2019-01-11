<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
    public function index(){
		$words = "";
		$companionlist = explode(",", $words);
		foreach($companionlist as $word){
			$word = ucfirst($word);
			DB::table('adopts_aggregiate')->insert(
				['what' => 'name', 'value' => $word]
			);		
		}
		view()->share('items', $companionlist);
    	return view('index');
    }
    public function login(){
 		view()->share('old_email', '');	
    	return view('login');
    }
    public function dologin(Request $request){
		if(Auth::check()){
			return redirect("index");
		}
		$validate = $this->validate($request,
			['email' => 'required|email',
			'password' => 'required|alphaNum|min:3']
		);
		
		$user_data = array(
			'email' => $request->get('email'), 
			'password' => $request->get('password')
		);
		
		$user = DB::table('adopts_users')
			->where('email', $request->get('email'))
			->first();
		view()->share('old_email', $request->get('email'));	
		if(!$user){
			$success_message = "{$request->get('email')} The information you entered does not match any user in our system.";
			view()->share('form_alert', $success_message);	
			return redirect('login');
		}
		$password = $request->get('password');
		$password_compare = password_verify($password, $user->password); 
		if($password_compare){
			$_SESSION['username'] = $user->username;
			$_SESSION['email'] = $user->email;
			$_SESSION['code'] = $user->salt;
			$_SESSION['usergroup'] = $user->usergroup;
			$_SESSION['uid'] = $user->uid;
			$_SESSION['logged_in'] = 1;
			return redirect('index');
		}
		else{
			$success_message = "The information you entered does not match any user in our system.";
			view()->share('form_alert', $success_message);				
			return redirect('login');
		}
		$success_message = "The information you entered does not match any user in our system.";
		view()->share('form_alert', $success_message);			
    	return view('login');
    }
	public function resetpass(){
		return view('resetpass');
	}
	public function doresetpass(Request $request){
		$password = $request->get('password');
		$user = DB::table('adopts_users')
			->where('email', $request->get('email'))
			->first();
		$password = password_hash($password, PASSWORD_DEFAULT);
		DB::table('adopts_users')
			->where('email', $request->get('email'))
			->update(['password' => $password]);		
		return redirect('login');
	}
	public function drink(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $aid = $parts[count($parts) - 1];
		$aid = Explode('.', $aid);
		$action = $aid[1];
		$adopt_id = $aid[0];
		make_new_special_image($adopt_id, $action);
	}
	public function image(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here           
        $parts = Explode('/', $pageURL);
        $aid = $parts[count($parts) - 1];
		$aid = Explode('.', $aid);
		$aid = $aid[0];
		$adopt_image = DB::select("SELECT * FROM `adopts_owned_adoptables` JOIN  `adopts_levels` where adopts_owned_adoptables.type = adopts_levels.adoptiename and adopts_owned_adoptables.aid = ? and adopts_owned_adoptables.currentlevel = adopts_levels.thisislevel LIMIT 1", [$aid]);
		if($adopt_image[0]){
			if($adopt_image[0]->currentlevel < 8){
				$image_url = $adopt_image[0]->primaryimage;
			}
			else if($adopt_image[0]->gender == 'f'){
				$image_url = $adopt_image[0]->primaryimage;
			}
			else{
				$image_url = $adopt_image[0]->alternateimage;
			}
		}
		else{
            $image_url = "icons/unknown_egg";
		}
        if ($adopt_image[0]->type == 'Raincatcher' && $this->adopt->currentlevel == '9') {
            $now  = new DateTime();
            $temp = (int) $now->format("G");
                    
            if ($temp >= 2 AND $temp <= 10) {
                $weather = "morning";
            } elseif ($temp >= 1 AND $temp < 2) {
                $weather = "dawn";
            } elseif ($temp > 10 AND $temp <= 18) {
                $weather = "afternoon";
            } elseif ($temp > 18 AND $temp <= 19) {
                $weather = "dusk";
            } elseif ($temp > 19 AND $temp <= 24) {
                $weather = "night";
            } else {
                $weather = "gilden";
            }
            $image_url = "adults/{$weather}bow";
        }
		$effects = DB::table('adopts_effects')
			->where('user', $adopt_image[0]->aid)
			->first();
		if($effects){
            $image_url = "changed/{$aid}";
		}
		$image_url = "images/{$image_url}.png";
		ob_end_clean();
		header('Content-Type: image/png');
		readfile($image_url);
	}
	public function itemimage(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here           
        $parts = Explode('/', $pageURL);
        $aid = $parts[count($parts) - 1];
		$aid = Explode('.', $aid);
		$aid = $aid[0];
		$item = DB::select("SELECT * FROM `adopts_items` where id = ? LIMIT 1", [$aid]);
		if($item[0]->itemtype == 0){
			$image_url = asset("/images/items/ingredients/{$item[0]->imageurl}.png");
		}
		if($item[0]->itemtype == 1){
			$image_url = asset("/images/items/potions/{$item[0]->imageurl}.png");
		}
		if($item[0]->itemtype == 2 || $item[0]->itemtype == 3 || $item[0]->itemtype == 4 || $item[0]->itemtype == 5 || $item[0]->itemtype == 21){
			$image_url = asset("/images/items/battle_items/{$item[0]->imageurl}.png");
		}
		if($item[0]->itemtype == 6){
			$image_url = asset("/images/items/smelting_items/{$item[0]->imageurl}.png");
		}
		ob_end_clean();
		header('Content-Type: image/png');
		readfile($image_url);
	}
	public function companionimage(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here           
        $parts = Explode('/', $pageURL);
        $aid = $parts[count($parts) - 1];
		$aid = Explode('.', $aid);
		$aid = $aid[0];
		$item = DB::select("SELECT * FROM `adopts_companion_information` where id = ? LIMIT 1", [$aid]);
		$image_url = asset("/images/companions/{$item[0]->image}sm.png");
		ob_end_clean();
		header('Content-Type: image/png');
		readfile($image_url);
	}
}