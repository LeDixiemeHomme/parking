<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

class ControleurAccueil extends Controleur {

    private $users;

    public function __construct() {
        $this->users = new Utilisateur();
    }

    public function index()
    {
        $user = $this->users->getUsers();
        $this->genererVue(array('users' => $user));
    }

}