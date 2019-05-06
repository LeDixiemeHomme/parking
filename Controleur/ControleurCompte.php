<?php

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:07
 */

//require 'Framework/Controleur.php';
require 'Modele/Utilisateur.php';
require 'Modele/Place.php';
require 'Modele/Reservation.php';

class ControleurCompte extends Controleur {

    private $users;

    public function __construct() {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
    }

    public function index()
    {
        $places = $this->place->getPlaces();
        $utilisateur = $this->users->getUser($_SESSION['id_u']);
        $reservation = $this->reservation->getReservationsUser($_SESSION['id_u']);
        $vali = $this->reservation->getValidite(2);
        $this->genererVue(array('places' => $places , 'reservations' => $reservation , 'val' => $vali , 'uti' => $utilisateur));
    }

}