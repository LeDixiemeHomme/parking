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
    public function retTrue() {
        return 1 > 2;
    }


    public function index()
    {
        $reaaze = $this->retTrue();
        $resauser = $this->reservation->getReservations();
        $resaplace = $this->reservation->getPlacefromReservation(2);
        $resacours = $this->reservation->isEnAttente(16);
        $this->genererVue(array('resau' => $resauser , 'resap' => $resaplace , 'resae' => $resacours, 're' => $reaaze));
    }
}