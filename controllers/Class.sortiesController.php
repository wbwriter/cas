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
		//$event = new Event(POST)
		//$event->Save();
    }

}