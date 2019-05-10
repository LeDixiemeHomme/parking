<?php

require_once 'ControleurAdminSecurise.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Place.php';
require_once 'Modele/Reservation.php';

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 10/05/2019
 * Time: 01:40
 */

class ControleurAdmin extends ControleurAdminSecurise {

    public function index()
    {
        $this->genererVue();
    }

}