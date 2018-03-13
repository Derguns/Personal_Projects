<?php

class reportController extends AppController{

    const PARAM = "confirm";
    private $view;
	private $subController;
	private $adopt;

    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->input->action == 'user'){
		      $this->user    = new Member($mysidia->input->get("user")); 
			  if($mysidia->input->get("user") == $mysidia->user->username) throw new NoPermissionException("You cannot report yourself.");
		}
    }
	
	
public function user(){
	 $document->setTitle("Reporting {$user->username}!");
        $document->addLangvar("Please select a reason for your report below. You will not be notified of the results of this report.");
       
	}
}
	?>