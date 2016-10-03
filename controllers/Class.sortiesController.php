<?php

/**
 * Created by PhpStorm.
 * User: andreasfi
 * Date: 26.09.16
 * Time: 01:00
 */
class sortiesController extends Controller
{
    function sorties()
    {

    }

    function propositions()
    {
        $result = Event::fetch_all_events();
        $this->vars['propositions'] = $result;
    }
    
    function details()
    {

    }

    function inscription()
    {

    }

    function ajoutsortie()
    {
		$this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = "Ajouter une course";
        $this->vars['pageMessage'] = "";
			
			
		if(!empty($_POST)){
			
			$description = $_POST['description'];
			$start_date = $_POST['startDate'].' '.$_POST['startTime'].':00';
			$end_date = $_POST['endDate'].' '.$_POST['endTime'].':00';
			$max_participants = $_POST['maxParticipants'];
			$event_type = 1;
			$owner = 1;//$_SESSION['user']->getId();
			$title = $_POST['title'];
			$event_cat = $_POST['category'];
			$difficulty = $_POST['difficulty'];
			$path = $_POST['JSON'];
			
			$event = new Event($id = null, $description, $start_date, $end_date, $max_participants, $event_type, $owner, $title, $event_cat, $difficulty, $path);
			$event->save();
		}
    }

}
