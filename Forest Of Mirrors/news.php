<?php

//This page and its databases:
// ADOPTS_NEWS
// Have been converted to the UID system.
class newsController extends AppController
{
    
    
    const PARAM = "user";
    private $view;
    private $subController;
    private $user;
    private $profile;
    private $adopt;
    
    public function __construct()
    {
        parent::__construct();
        $mysidia = Registry::get("mysidia");
		//Check if the user performing the actions to make new news for the newsfeed is an admin.
        if ($mysidia->input->action() == 'createNew' || $mysidia->input->action() == 'edit' || $mysidia->input->action() == 'delete') {
			if($mysidia->user->usergroup != 'rootadmins'){
                throw new NoPermissionException("You are no admin!");
            }
        }
    }
    public function edit()
    {
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
		//Pull the given Newspost ID from the editing URL and convert it to the database object.
        $pageURL  = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here
        
        $parts    = Explode('/', $pageURL);
        $males    = $parts[count($parts) - 1];
        $editpost = $mysidia->db->select("news", array(), "nid='{$males}'")->fetchObject();
        
        $document->setTitle("Editing a News Post");
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/news'><div id='returnButton'>Return to News</div></a>");
		//If they submited the newspost edit.
        if ($mysidia->input->post("submit")) {
            $date    = new DateTime;
            $content = "{$mysidia->input->post("message")}";
            $type = "{$mysidia->input->post("reason")}";
			//Minimal / Mock BBcode. 
            $content = strip_tags("{$content}", "<br>");
            $content = stripslashes($content);
            $content = str_replace("[url='", "<a href='", "{$content}");
            $content = str_replace("']", "'>", "{$content}");
            $content = str_replace("[/url]", "</a>", "{$content}");
            $content = str_replace("[br]", "<br>", "{$content}");
            $content = str_replace("[b]", "<b>", "{$content}");
            $content = str_replace("[/b]", "</b>", "{$content}");
            $content = str_replace("[img]", "<img src='", "{$content}");
            $content = str_replace("[/img]", "'></img>", "{$content}");
            $mysidia->db->update("news", array(
                "content" => $content
            ), "nid = '{$males}'");
            $mysidia->db->update("news", array(
                "type" => $type
            ), "nid = '{$males}'");
            $document->addlangvar("You have EDITED a news post with a designation of {$mysidia->input->post("reason")} (0 - Site Update; 1- Sidebar Post; 2- Creature News) with the content: <div id='potionsDiv'> {$content}</div>");

        } else {
			//Otherwise show edit normal and convert the BBcode back into HTML.
            $document->addLangvar("<br><br>Hello admin! Here you are editing a news post's content! Please use [url=''] [/url] and [br] and [b] [/b] as HTML tags.");
            $reportForm = new Form("reportForm", "", "post");
			$content = $editpost->content;
            $content = str_replace("<a href='", "[url='", "{$content}");
            $content = str_replace("'>", "']", "{$content}");
            $content = str_replace("</a>", "[/url]", "{$content}");
            $content = str_replace("<br>","[br]", "{$content}");
            $content = str_replace("<b>", "[b]", "{$content}");
            $content = str_replace("</b>","[/b]", "{$content}");
            $content = str_replace("<img src='","[img]", "{$content}");
            $content = str_replace("'></img>","[/img]", "{$content}");
            $reportForm->add(new Comment("<br><hr>Type of Newspost: <br>", FALSE, "b"));
            $genderList = new RadioList("reason");
            $genderList->add(new RadioButton("Main Site Update (Events, Things to do)", "reason", "0"));
            $genderList->add(new RadioButton("Changelog Update (Keep short)", "reason", "1"));
            $genderList->add(new RadioButton("Creature Release News", "reason", "2"));
            $genderList->add(new RadioButton("Hidden", "reason", "3"));
            $genderList->check("{$editpost->type}");
            $reportForm->add($genderList);
            $reportForm->add(new Comment("<br>Word Content:", FALSE, "b"));
            $reportForm->add(new TextArea("message", "{$content}", 10, 40));
            $reportForm->add(new Comment("<br>", FALSE, "b"));
            $reportForm->add(new Button("Edit Newspost", "submit", "submit"));
            $document->add($reportForm);
        }
    }
	//This is essentially the same as the edit post but with some minor differences. Could possibly be merged with some slight effort (such as count-checking any given urls)
	//For now is separate to keep things 'tidy'. 
	//To do?: Merge w//edit to make "manage" page.
    public function createNew()
    {
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        
        $document->setTitle("Create New News Post");
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/news'><div id='returnButton'>Return to News</div></a>");

        if ($mysidia->input->post("submit")) {
            $date    = new DateTime;
            $content = "{$mysidia->input->post("message")}";
            $type = "{$mysidia->input->post("reason")}";
            $content = strip_tags("{$content}", "<br>");
            $content = stripslashes($content);
            $content = str_replace("[url='", "<a href='", "{$content}");
            $content = str_replace("']", "'>", "{$content}");
            $content = str_replace("[/url]", "</a>", "{$content}");
            $content = str_replace("[br]", "<br>", "{$content}");
            $content = str_replace("[b]", "<b>", "{$content}");
            $content = str_replace("[/b]", "</b>", "{$content}");
            $content = str_replace("[img]", "<img src='", "{$content}");
            $content = str_replace("[/img]", "'></img>", "{$content}");
            $document->addlangvar("You have CREATED a news post with a designation of {$mysidia->input->post("reason")} (0 - Site Update; 1- Sidebar Post; 2- Creature News) with the content: <div id='potionsDiv'> {$content}</div>");
            
            $mysidia->db->insert("news", array(
                "nid" => NULL,
                "dated" => $date->getTimestamp(),
                "content" => $content,
                "postedby" => $mysidia->user->uid,
                "type" => $type
            ));
        } else {
            $document->addLangvar("<br><br>Hello admin! Here you can create a new newspost that will be posted to the index page. Please use [url=''] [/url] and [br] and [b] [/b] as HTML tags.");
            $reportForm = new Form("reportForm", "", "post");
            $reportForm->add(new Comment("<br><hr>Type of Newspost: <br>", FALSE, "b"));
            $genderList = new RadioList("reason");
            $genderList->add(new RadioButton("Main Site Update (Events, Things to do)", "reason", "0"));
            $genderList->add(new RadioButton("Changelog Update (Keep short)", "reason", "1"));
            $genderList->add(new RadioButton("Creature Release News", "reason", "2"));
            $genderList->add(new RadioButton("Hidden", "reason", "3"));
            $genderList->check("3");
            $reportForm->add($genderList);
            $reportForm->add(new Comment("<br>Word Content:", FALSE, "b"));
            $reportForm->add(new TextArea("message", "", 10, 40));
            $reportForm->add(new Comment("<br>", FALSE, "b"));
            $reportForm->add(new Button("Create Newspost", "submit", "submit"));
            $document->add($reportForm);
        }
    }
	//Our newspost display page.
    public function index()
    {
        $mysidia  = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        $document->setTitle("View All News Posts");
        
        $current = new DateTime;
        
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/'><div id='returnButton'>Return to Index</div></a>");
		//If admin, show all news, even hidden.
			if($mysidia->user->usergroup == 'rootadmins'){
        $document->addlangvar("<a href='http://forestofmirrors.x10.mx/news/createNew'><div id='returnButtonRight'>Create News Post</div></a>");
			$totalNews = $mysidia->db->select("news", array(
				"nid"
			), "nid > 0 ORDER BY dated DESC")->rowCount();
		}
		//if Not, only show normal posts.
		else{
			$totalNews = $mysidia->db->select("news", array(
				"nid"
			), "type = '0' || type ='2' || type ='1' ORDER BY dated DESC")->rowCount();	
		}
		
		//Pagination script to allow for pages to be clicked through to search news.
        $pagination = new Pagination($totalNews, 10, "news");
        $pagination->setPage($mysidia->input->get("page"));
        $document->addLangvar($pagination->showPage());
		
		//Pagination changes based upon admin / not admin.
		if($mysidia->user->usergroup == 'rootadmins'){
			$stmt      = $mysidia->db->select("news", array(
				"nid"
			), "nid > 0  ORDER BY dated DESC LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");
        }
		else{
			$stmt      = $mysidia->db->select("news", array(
				"nid"
			), "type = '0' || type ='2' || type ='1'  ORDER BY dated DESC LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");
        }
		
		//Our newspost content. Each post appends to this.
		$newsposts = "<div id='newsPostsDivs'>";
        while ($iid = $stmt->fetchColumn()) {
            $newsPost = $mysidia->db->select("news", array(), "nid='{$iid}'")->fetchObject();
            $newsdate = date('m-d-Y H:i:s', $newsPost->dated);
			$newPostEdit = '';
            if ($newsPost->type == '1') {
                $newsPosttype = 'Change Log Post';
            } else if ($newsPost->type == '2') {
                $newsPosttype = 'Creature Release';
            } else if ($newsPost->type == '0') {
                $newsPosttype = 'Site Update';
            }else{
				$newsPosttype = '***Hidden Post***';
			}
            $newsPoster = $mysidia->db->select("users", array(), "uid='{$newsPost->postedby}'")->fetchObject();
			$postedby = $newsPoster->username;
			if($mysidia->user->usergroup == 'rootadmins'){
				$newPostEdit= "<a href='http://forestofmirrors.x10.mx/news/edit/{$iid}'><img src='http://forestofmirrors.x10.mx/templates/icons/trade.gif'></img></a>";
			}
            $newsposts .= "<div id='newsView'><div id='newsTitle'>{$newsPosttype} {$newPostEdit}</div><div id='postedONNEWS'>Posted by <a href='http://forestofmirrors.x10.mx/profile/view/{$postedby}'>{$postedby}</a> on {$newsdate}</div><div id='newsPostContent'>{$newsPost->content}</div></div>";
        }
        
        $document->addLangvar("{$newsposts}</div>");
        
		//If more than 10 news posts, show the pagination buttons.
        if ($totalNews >= 10) {
            $document->addLangvar($pagination->showPage());
        }
    }
}
?>