<?php

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:07
 */

require 'Framework/Controleur.php';
//require 'Modele/Utilisateur.php';
require 'Modele/Place.php';

class ControleurCompte extends Controleur {

    private $users;

    public function __construct() {
        //$this->users = new Utilisateur();
        $this->place = new Place();

    }

    public function index()
    {
        $places = $this->places->getPlaces();
        $this->genererVue(array('places' => $places));
    }

}