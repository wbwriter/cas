<?php
/**
 * Created by PhpStorm.
 * User: andreasfi
 * Date: 26.09.16
 * Time: 01:00
 */


class sortiesController extends Controller{

    function sorties(){
        $this->vars['pageTitle'] = "Planning";
        $this->vars['pageMessage'] = "";
        $this->vars['propositions'] = json_encode(Event::fetch_all_events());
    }


    function details(){

        $this->checkUser(0, "/error/http404");
        $this->checkParam($GLOBALS['value'], "/home");

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


        if(isset($_POST['numParticipants'])){

            $_SESSION['user']->addUserToEvent($this->vars['eventId'], $_POST['numParticipants']);

            $this->vars['msg'] = "VOUS AVEZ ETE INSCRIT";
        }
        $userId = null;
        if(isset($_SESSION['user'])){
            $userId = $_SESSION['user']->getId();
        }

        $participating = false;
        if($userLevel >= 0){
            $userByEvent = User::getUserByEventId($GLOBALS['value']);
            $this->vars['allParticipants'] = $userByEvent;

            foreach ($userByEvent as $item){
                foreach ($item as $it) {
                    if($it->getId() == $userId){
                        $participating = true;
                        break 2;
                    }
                }
            }
        }
        $this->vars['participating'] = $participating;


        //if($userLevel >= 0){
            //$userByEvent = User::getUserByEventId(2);
            //$this->vars['allParticipants'] = $userByEvent;
        //}


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

        $this->vars['pageTitle'] = "Inscription";
        $this->vars['pageMessage'] = "";

        if(!isset($_Session['user'])){
            $_SESSION['msg'] = '<span class="error">Vous devez vous connecter pour vous inscrire a une sortie</span>';
            $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
            //$this->redirect('../../login'); //too many redirects

        }
        // Get infos
        $result = Event::fetch_event_by_id($GLOBALS['value']);

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

<<<<<<< HEAD
=======
		$_SESSION['difficulty'] = $result->getDifficulty();

		if(isset($_POST['numPeople'])){
			var_dump($_POST);
		}

>>>>>>> origin/master

        $_SESSION['difficulty'] = $result->getDifficulty();

        if(isset($_POST['numPeople'])){
            var_dump($_POST);
        }

<<<<<<< HEAD
        $this->checkUser(2, "/cas/error/http404");
=======


        $this->checkUser(2, "/error/http404");
>>>>>>> origin/master
    }
    function ajoutsortie(){

        $this->checkUser(3, "/error/http404");
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
			if(isset($_POST['id'])){
				//pour charger l'event dans le mode édition. on charge un objet event dans la session.
				$result = Event::fetch_event_by_id($_POST['id']);
				$_SESSION['event'] = $result;
				
			}else if(isset($_POST['delete_event'])){
					$event = Event::fetch_event_by_id($_POST['delete_event']);
					$event->delete();
					
					$_SESSION['msg'] = '<span class="success">Evenement suprimmé</span>';
					$this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
					
					$this->redirect('/home'.$_POST['edit_event']);
			}else{
				
				echo('create mode');
				//sinon on est en mode submit. décoder l'info.
				$description = $_POST['description'];
				$start_date = DateTime::createFromFormat('Y/m/d H:i:s', $_POST['startDate'].':00');
				// j'ai supprime cette ligne pour que $start_date soit un DATETIME
				//$start_date = $start_date->format('Y-m-d H:i:s');
				$end_date = DateTime::createFromFormat('Y/m/d H:i:s', $_POST['endDate'].':00');
				// j'ai supprime cette ligne pour que $start_date soit un DATETIME
				//$end_date = $end_date->format('Y-m-d H:i:s');
				$max_participants = $_POST['maxParticipants'];
				$event_type = 1;
				$owner = $_SESSION['user']->getId();
				$title = $_POST['title'];
				$event_cat = $_POST['category'];
				$difficulty = $_POST['difficulty'];
				$path = $_POST['JSON'];


				//TODO check ajoutsortie quel event type c'est
				if($start_date->format('i') != $end_date->format('i'))
					$event_type = 1;
				else
					$event_type = 2;
				
				if(isset($_POST['edit_event'])){
					$event = Event::fetch_event_by_id($_POST['edit_event']);
					//si on était en mode édition, on fait un update, et non pas un insert
					$event->update($description, $start_date, $end_date, $max_participants, $title, $event_cat, $difficulty, $path);
					
					$_SESSION['msg'] = '<span class="success">Evenement modifié</span>';
					$this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
					
					$this->redirect('/sorties/details/'.$_POST['edit_event']);
				}else{
					//si on était en mode création, on insert l'event.
					$event = new Event($id = null, $description, $start_date, $end_date, $max_participants, $event_type, $owner, $title, $event_cat, $difficulty, $path, null);
					$event->save();

					$_SESSION['msg'] = '<span class="success">Evenement cree</span>';
					$this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';

					$this->redirect('/login/welcome');
				}
			}

        }
        function alreadyParticipating(){
            $userId = $_SESSION['user']->getId();


        }
    }
}