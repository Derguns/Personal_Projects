<?php

class ContestController extends AppController
{
    
    const PARAM = "contest";
    
    private $view;
    private $subController;
    
    public function __construct()
    {
        parent::__construct("member");
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
		//If the user has submitted a creature to the contest page, check that the creature meets all valid data.
        if ($mysidia->input->post("contestform")) {
			
            $contest = $mysidia->db->select("contest", array(), "contestId = '{$mysidia->input->post("contest")}'")->fetchObject();
            $countCountests = $mysidia->db->select("contest", array(), "contestId = '{$mysidia->input->post("contest")}'")->rowCount();		
            $countEntries = $mysidia->db->select("contest_entries", array(), "contid = '{$mysidia->input->post("contest")}' and aid='{$mysidia->input->post("creatureAID")}' and uid = '{$mysidia->user->uid}'")->rowCount();		
            $countAllEntries = $mysidia->db->select("contest_entries", array(), "aid='{$mysidia->input->post("creatureAID")}'")->rowCount();	
				
			//Create a new Adopt Object for our creature and pull the stats.
			$this->adoptEgg = new OwnedAdoptable($mysidia->input->post("creatureAID"));
            $conname        = $contest->name;
            $atk            = $this->adoptEgg->atk;
            $hp             = $this->adoptEgg->maxhp;
            $spd            = $this->adoptEgg->spd;
            $trinks = $mysidia->db->select("trinkets", array(), "status = '{$mysidia->input->post("creatureAID")}'")->rowCount();		
            if ($trinks > 0) {
                //calculate trinket reduced stats for creature (trinkets are meant for Battling Only.)
                $contestIds = $mysidia->db->select("trinkets", array(), "status = '{$mysidia->input->post("creatureAID")}'");
                while ($contestId = $contestIds->fetchObject()) {
                    $class = $contestId->category;
                    if ($class == 'atk') {
                        $atk = $atk - $contestId->value;
                    }
                    if ($class == 'def') {
                        $spd = $spd - $contestId->value;
                    } else {
                        $hp = $hp - $contestId->value;
                    }
                }
            }
			//Calculate stats values based upon contest type.
            if ($conname == 'Digging') {
                $score = 2 * $atk + 1.5 * $spd + $hp;
            } else if ($conname == 'Eating') {
                $score = 2 * $hp + 1.5 * $spd + $atk;
            } else if ($conname == 'Racing') {
                $score = 2 * $spd + 1.5 * $atk + $hp;
            } else if ($conname == 'Climbing') {
                $score = 2 * $hp + 1.5 * $atk + $spd;
            } else if ($conname == 'Flying') {
                $score = 2 * $spd + 1.5 * $hp + $atk;
            } else if ($conname == 'Swimming') {
                $score = 2 * $atk + 1.5 * $hp + $spd;
            } else {
                $score = $atk + $hp + $spd;
            }
			//Our 'RNG' element to the contests.
            $determining = mt_rand(9500, 10500);
			//Our total score for the creature.
            $score       = $score * $determining;
			
			//Pulling the level requirements for the contest to check against.
            if ($contest->class == 'Bronze') {
                $minlevel = 0;
                $maxlevel = 25;
            } else if ($contest->class == 'Silver') {
                $minlevel = 25;
                $maxlevel = 50;
            } else if ($contest->class == 'Gold') {
                $minlevel = 50;
                $maxlevel = 75;
            } else if ($contest->class == 'Platinum') {
                $minlevel = 75;
                $maxlevel = 100;
            } else {
                $minlevel = 100;
                $maxlevel = 10000;
            }
			//Check if our creature matches all possible checks.
            if ($count4 < 1 && $mysidia->input->post("creatureAID") != NULL && $mysidia->input->post("adoptuser") == $mysidia->user->username && $count == 1 && $this->adoptEgg->level >= $minlevel && $this->adoptEgg->owner == "{$mysidia->user->username}" && $this->adoptEgg->level <= $maxlevel) {
                //Display our Status
				$document->addlangvar("<div id='clanpoints' class='alert alert-success'><a href='http://forestofmirrors.x10.mx/levelup/click/{$mysidia->input->post("creatureAID")}'>{$this->adoptEgg->aid} the {$this->adoptEgg->type}</a> was submitted to The {$contest->class} {$contest->name} Contest.</div>");
                $date = new DateTime;
				
				//Add into our site logbook.
                $mysidia->db->insert("logs", array(
                    "lid" => NULL,
                    "date" => $date->format('Y-m-d'),
                    "user" => $mysidia->user->username,
                    "where" => 'Contests',
                    "what" => $this->adoptEgg->aid,
                    "type" => 'Entered A Contest',
                    "time" => $date->format('G:i:s')
                ));
				//Insert into our entries DB.
                $mysidia->db->insert("contest_entries", array(
                    "id" => NULL,
                    "uid" => $mysidia->user->uid,
                    "aid" => $this->adoptEgg->aid,
                    "contid" => $contest->contestID,
                    "contcalc" => $score
                ));
				//Update our contest's entries amount.
                $entered = $contest->totalentered + 1;
                $mysidia->db->update("contest", array(
                    "totalentered" => $entered
                ), "contestId = '{$contest->contestID}'");
				
				//Lower contest run time if entry percents have been met.
				if((($contest->totalentered / $contest->limitAdopt) * 100) >= 75){
                $mysidia->db->update("contest", array(
                    "expectedran" => 2
                ), "contestId = '{$contest->contestID}'");					
				}
				else if((($contest->totalentered / $contest->limitAdopt) * 100) >= 50){
                $mysidia->db->update("contest", array(
                    "expectedran" => 4
                ), "contestId = '{$contest->contestID}'");			
				}
				else if($contest->totalentered >= $contest->limitAdopt){
                $mysidia->db->update("contest", array(
                    "expectedran" => 1
                ), "contestId = '{$contest->contestID}'");						
				}
				else{
                $mysidia->db->update("contest", array(
                    "expectedran" => 7
                ), "contestId = '{$contest->contestID}'");						
				}
            } else {
				//Otherwise throw error.
                $document->addlangvar("There was an error submitting this creature to the specified contest.");
            }
        }
    }
    
    public function index()
    {
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        $document->setTitle("The Contest Board");
        
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/contest/leaders/'><div id='returnButtonRight'>View Recent Winners</div></a><br>");
        $document->addlangvar("<div id='speciesInformation'>Along with some of the more useful activities the castle council provides its students to bond with their creatures, the council had decided long ago to allow for users to enter their creatures into contests- shows of strength, skill, and beauty to show the rest of the castle how attuned their creature raising skills are. In order to make these contests more fair for those who have just begun, the castle has ordered them into ranks: Bronze for creatures under level 25, Silver for creatures under level 50, Gold for creatures under level 75, Platinum for creatures under level 100, and Diamond for those who have shown true prowress in battling- and toppled the 100 level marker. 
		<br><br> Additionally, contests each require two passive skills from the creature to be their strengths- digging requiring <b>Attack</b> and <b>Speed</b>, eating contests requiring <b>Health</b> and <b>Speed</b>, racing contests requiring <b>Speed</b> and <b>Attack</b>, climbing contests requiring <b>Health</b> and <b>Attack</b>, flying contests requiring <b>Speed</b> and <b>Health</b>, and swimming contests requiring <b>Attack</b> and <b>Health</b>. The first stat required is counted as more important than the second stat, and the second stat is counted as more important than the third (non-mentioned). Additionally, trinkets are not counted in the calculation of your creature's ability - and a certain level of random chance is applied. However, the rewards are worth the challenge- tropies and blue stones await those deemed worthy enough.</div><br>");
       
	   //Pull our total Contests (that have not met full status)
        $contestIds = $mysidia->db->select("contest", array(
            "contestID"
        ), "totalEntered <= limitAdopt ORDER BY totalEntered/limitAdopt DESC");
		
		//Fix for users with spaces in their usernames (cannot be passed to the JS file as-is).
        $modal_user = str_replace(" ", "_", "{$mysidia->user->username}");
		
		//Our stock Bootstrap Modal function. Called when button is pressed to enter a creature. Loads a list of all creatures the user owns when clicked.
        $document->add(new Comment("
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
 <!-- Taken from Bootstrap's documentation -->
<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Enter A Creature</h4>
      </div>
      <div class='modal-body'>
        <p>One fine body&hellip;</p>
      </div>
      <div class='modal-footer'>
        <button type='button' data-dismiss='modal'>Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	<link rel='stylesheet' href='http://forestofmirrors.x10.mx/ajaxy/modals.css'>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
	<script src='http://forestofmirrors.x10.mx/ajaxy/modalcontest3.js'></script>
	<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
	<script src='http://forestofmirrors.x10.mx/ajaxy/index.js'></script>
"));
		//While loop to display available contests.
        while ($contestId = $contestIds->fetchColumn()) {
            
            $contest = new Contest($contestId);
            $document->addlangvar("<div id='newsView'><div id='newsTitle'>{$contest->getClass()} {$contest->getName()} Contest</div>");
            if ($contest->getName() == "Digging") {
                $skills = "Attack and Speed";
            } else if ($contest->getName() == "Eating") {
                $skills = "Health and Speed";
            } else if ($contest->getName() == "Racing") {
                $skills = "Speed and Attack";
            } else if ($contest->getName() == "Flying") {
                $skills = "Speed and Health";
            } else if ($contest->getName() == "Climbing") {
                $skills = "Health and Attack";
            } else if ($contest->getName() == "Swimming") {
                $skills = "Attack and Health";
            } else {
                $skills = 'No Preference';
            }
            if ($contest->getClass() == 'Bronze') {
                $minlevel = "None";
                $maxlevel = 25;
            } else if ($contest->getClass() == 'Silver') {
                $minlevel = 25;
                $maxlevel = 50;
            } else if ($contest->getClass() == 'Gold') {
                $minlevel = 50;
                $maxlevel = 75;
            } else if ($contest->getClass() == 'Platinum') {
                $minlevel = 75;
                $maxlevel = 100;
            } else {
                $minlevel = 100;
                $maxlevel = "None";
            }
			$lowerClass = lcfirst($contest->getClass());
            $document->addlangvar("<div id='postedONNEWS'>{$contest->getNumContestants()} / {$contest->getlimitAdopt()} Entries | {$contest->getDated()}</div><br><div id='contestingFlex'><div id='skills'><b>Skills Required:</b> {$skills}<br><b>Minimum Level:</b> {$minlevel} <br> <b>Maximum Level:</b> {$maxlevel}</div><div id='rewardsContest'>
			<b>1.</b> <img src='http://forestofmirrors.x10.mx/images/icons/{$lowerClass}1.png'></img> {$contest->moneyReward(1)} Blue Stones<br>
			<b>2.</b> <img src='http://forestofmirrors.x10.mx/images/icons/{$lowerClass}2.png'></img> {$contest->moneyReward(2)} Blue Stones<br>
			<b>3.</b> <img src='http://forestofmirrors.x10.mx/images/icons/{$lowerClass}3.png'></img> {$contest->moneyReward(3)} Blue Stones<br>
			</div><div id='enter'>");
            $count = $mysidia->db->select("contest_entries", array(), "uid = '{$mysidia->user->uid}' and contid = '{$contest->getID()}'")->rowCount();
            if ($count < 2) {
                $document->addlangvar("<button id='returnButtonNeutral' data-toggle='modal' data-target='.modal' data-adoptid='{$contest->getID()}' data-adoptuser='{$modal_user}'><center>Enter Creatures</center></button>");
            }
            if ($count > 0) {
                $document->addlangvar("<br>Creatures Entered:");
                $contestIds12 = $mysidia->db->select("contest_entries", array(
                    "aid"
                ), "uid = '{$mysidia->user->uid}' and contid = '{$contest->getID()}' ORDER BY id DESC");
                while ($contestId1 = $contestIds12->fetchColumn()) {
                    
                    $document->addlangvar("|<a href='http://forestofmirrors.x10.mx/levelup/click/{$contestId1}'><img src='http://forestofmirrors.x10.mx/levelup/siggy/{$contestId1}' style='width:30px;height:30px'></img></a>|");
                    
                }
            }
            $document->addlangvar("</div></div>");
        }
    }
	//Simple leaderboard table. Nothing special.
    public function leaders()
    {
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here
        
        $parts = Explode('/', $pageURL);
        $id    = $parts[count($parts) - 1];
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/contest/'><div id='returnButton'>To Contest Main Page</div></a><br>");
        
        $document->setTitle("Contest Leader Board ");
        $document->addlangvar("<div id='speciesInformation'> Here the winners of the last five contests that have run are proudly displayed, along with their respective trophy rewards! An interesting fact- creature trophies will be traded with the creature, meaning that they won't dissapear if sold!  </div>");
        
        $winnerTable = new TableBuilder("inventorytable", 750);
        $winnerTable->setAlign(new Align("center", "middle"));
        $winnerTable->buildHeaders("<center><b><span style='font-size:16px;'>Adoptable", "<b><center><span style='font-size:16px;'>Contest", "<b><center><span style='font-size:16px;'>Place", "<b><center><span style='font-size:16px;'>Day</b>");
        
        $stmt = $mysidia->db->select("winners", array(
            "id"
        ), "id > 0 ORDER BY id DESC LIMIT 15");
        while ($iid = $stmt->fetchColumn()) {
            $item  = $mysidia->db->select("winners", array(), "id='{$iid}'")->fetchObject();
            $adopt  = $mysidia->db->select("owned_adoptables", array(), "aid='{$item->aid}'")->fetchObject();
            $image = new TCell("<center><a href='http://forestofmirrors.x10.mx/levelup/click/{$item->aid}'><img src='http://forestofmirrors.x10.mx/levelup/siggy/{$item->aid}'></img></a><br>{$adopt->name} the {$adopt->type}");
            $name  = new TCell($item->race);
			$date =  date('m-d-Y', $item->day);
            $price = new TCell($date);
			if($item->class != NULL || $item->class != ''){
				$class = lcfirst($item->class);
			}
			else{
				$class = 'bronze';
			}
            $quant = new TCell("<img src='http://forestofmirrors.x10.mx/images/icons/{$class}{$item->place}.png'></img>");
            
            $winnerTable->buildRow(array(
                $image,
                $name,
                $quant,
                $price,
                $buy,
                $decline
            ));
        }
        $document->add($winnerTable);
        
    }
}
?>