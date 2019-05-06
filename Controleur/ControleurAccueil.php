<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Place.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

class ControleurAccueil extends Controleur {

    private $users;
    private $places;

    public function __construct() {
        $this->users = new Utilisateur();
        $this->places = new Place();
    }

    public function index()
    {
        $this->places->setEtat(2,1);
        $user = $this->users->getUsers();
        $places = $this->places->getPlacesOccupees();
        $this->genererVue(array('users' => $user , 'places' => $places));
    }

}