<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Place.php';
require_once 'Modele/Reservation.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

class ControleurAccueil extends Controleur {

    private $users;
    private $place;
    private $reservation;

    public function __construct() {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
    }

    public function index()
    {
        $place = $this->place->getPlaces();
        $reservation = $this->reservation->getReservationsByPlace(6);
        if(isset($_SESSION['id_u'])) {
            $users = $this->users->getUser($_SESSION['id_u']);
        }
        if(isset($users['niveau']))$niveau = $users['niveau'];
        else $niveau = NULL;
        $this->genererVue(array('niv' => $niveau , 'pl' => $place, 're' => $reservation));
    }
}