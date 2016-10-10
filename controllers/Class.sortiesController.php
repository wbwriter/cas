<?php
/**
 * Created by PhpStorm.
 * User: andreasfi
 * Date: 26.09.16
 * Time: 01:00
 */


class sortiesController extends Controller{
    function sorties(){

    }
    function propositions(){

        $this->vars['propositions'] = json_encode(Event::fetch_all_events());

    }
    function details(){
        $this->checkUser(0, "/cas/error/http404");
        $this->checkParam($GLOBALS['value'], "/cas/home");

        // Get infos
        $result = Event::fetch_event_by_id($GLOBALS['value']);

        // Variables depuis BD

        $description = "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.";

        $this->vars['eventId'] = $result->getId();
        $this->vars['title'] = $result->getTitle();
        $this->vars['startDate'] = $result->getStartDate();
        $this->vars['endDate'] = $result->getEndDate();
        $this->vars['maxParticipants'] = $result->getMaxParticipants();
        $this->vars['owner'] = $result->getOwner();
        $this->vars['eventCategory'] = $result->getEventCategory();
        $this->vars['difficulty'] = $result->getDifficulty();
        $this->vars['path'] = $result->getPath();
        $this->vars['description'] = $result->getDescription();
        $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
        $this->vars['pageTitle'] = $result->getTitle();
        $this->vars['pageMessage'] = $result->getStartDate();


        // Calcul de la distance
        $path = $result->getPath();
        // Faire un json valide
        $json = preg_replace('/([{,])(\s*)([A-Za-z0-9_\-]+?)\s*:/','$1"$3":',$path);
        $pathArrays = json_decode($json);
        $pathDistance = 0;
        // incrementer la distance entre tous les points
        for($i = 0; $i < count($pathArrays)-1; $i++){
            $pathDistance += $this->distance($pathArrays[$i]->lat, $pathArrays[$i]->lng, $pathArrays[$i+1]->lat, $pathArrays[$i+1]->lng);
        }
        $this->vars['distance'] = $pathDistance;

        // Calcul du denivele



        // api transport

        $from = isset($_POST['from']) ? $_POST['from'] : false;
        $response = isset($_POST['response']) ? $_POST['response'] : false;
        $to = isset($_POST['to']) ? $_POST['to'] : false;
        $via = isset($_POST['via']) ? $_POST['via'] : false;
        $datetime = isset($_POST['datetime']) ? $_POST['datetime'] : '';
        $page = isset($_POST['page']) ? ((int) $_POST['page']) - 1 : 0;
        $c = isset($_POST['c']) ? (int) $_POST['c'] : false;
        $stationsFrom = [];
        $stationsTo = [];
        $search = $from && $to;
        $userLevel = isset($_SESSION['user']) ? $_SESSION['user']->getMemberType() : false;

        if ($search) {
            $query = [
                'from'  => $from,
                'to'    => $to,
                'page'  => $page,
                'limit' => 6,
            ];
            if ($datetime) {
                $query['date'] = date('Y-m-d', strtotime($datetime));
                $query['time'] = date('H:i', strtotime($datetime));
            }
            if ($via) {
                $query['via'] = $via;
            }
            $url = 'http://transport.opendata.ch/v1/connections?'.http_build_query($query);
            $url = filter_var($url, FILTER_VALIDATE_URL);
            $response = json_decode(file_get_contents($url));
            if ($response->from) {
                $from = $response->from->name;
            }
            if ($response->to) {
                $to = $response->to->name;
            }
            if (isset($response->stations->from[0])) {
                if ($response->stations->from[0]->score < 101) {
                    foreach (array_slice($response->stations->from, 1, 3) as $station) {
                        if ($station->score > 97) {
                            $stationsFrom[] = $station->name;
                        }
                    }
                }
            }
            if (isset($response->stations->to[0])) {
                if ($response->stations->to[0]->score < 101) {
                    foreach (array_slice($response->stations->to, 1, 3) as $station) {
                        if ($station->score > 97) {
                            $stationsTo[] = $station->name;
                        }
                    }
                }
            }
        }

        if(isset($response)){$this->vars['response'] = $response;}else {$response = null;}
        $this->vars['from'] = $from;
        $this->vars['to'] = $to;
        $this->vars['via'] = $via;
        $this->vars['datetime'] = $datetime;
        $this->vars['c'] = $c;
        $this->vars['stationsFrom'] = $stationsFrom;
        $this->vars['stationsTo'] = $stationsTo;
        $this->vars['search'] = $search;
        $this->vars['userLevel'] = $userLevel;
    }
    function distance($lat1, $lon1, $lat2, $lon2) {
        // function de calcul de la distance entre deux points
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $km = $dist * 60 * 1.1515;

        return ($km * 1.609344);
    }
    function inscription(){

        if(!isset($_Session['user'])){
            $_SESSION['msg'] = '<span class="error">Vous devez vous connecter pour vous inscrire a une sortie</span>';
            $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            $this->redirect('../../login');
        }

        $this->checkUser(2, "/cas/error/http404");
    }
    function ajoutsortie()
    {

        if(!isset($_SESSION['user']) ){
            $_SESSION['msg'] = '<span class="error">Vous devez vous connecter pour créer un évenement</span>';
            $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

            $this->redirect('../login');
        }
        else if(($_SESSION['user']->getMemberType()) != 3){
            $_SESSION['msg'] = '<span class="error">Vous ne possedez pas les droits pour creer un evenement</span>';
            $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

            $this->redirect('../login/welcome');

        }
    /*
         else if($_SESSION['user']->getMemberType !=2){
             var_dump("hello");
            $_SESSION['msg'] = '<span class="error">Vous ne possédez pas les droits pour créer un évenement</span>';
            $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            $this->redirect('/login/welcome');
        }

*/

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
