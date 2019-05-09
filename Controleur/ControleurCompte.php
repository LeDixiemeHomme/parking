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

class ControleurCompte extends Controleur
{

    private $users;

    public function __construct()
    {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
    }

    public function ajoutTemps($date, $temps_ajoute)
    {
        date_add($date, date_interval_create_from_date_string($temps_ajoute));
        return $date;
    }

    public function getValidite($idResa) {
        $resa = $this->reservation->getReservation($idResa);
        return ($resa['date_debut'] < $resa['date_fin']);
    }

    public function creerDate($date)
    {
        $date = new Datetime($date);
        $newDate = $date->format('Y-m-d H:i:s');
        return $newDate;
    }

    public function ajouterResa()
    {
        if ($this->requete->existeParametre("date_debut")
            && $this->requete->existeParametre("date_fin")
            && $this->requete->existeParametre("id_p")
            && $this->requete->existeParametre("id_u")) {

            $date_debut = $this->requete->getParametre("date_debut");
            $date_fin = $this->requete->getParametre("date_fin");
            $id_p = $this->requete->getParametre("id_p");
            $id_u = $this->requete->getParametre("id_u");

            $this->reservation->addReservation($date_debut, $date_fin, $id_p, $id_u);
            $this->rediriger("compte");
        } else
            throw new Exception("Action impossible : Informations non définies");
    }


    public function index()
    {
        $resa = //$this->reservation->addReservation($this->creerDate('now'), $this->creerDate('now'), 1, 1);
        $places = $this->place->getPlaces();
        $utilisateur = $this->users->getUser($_SESSION['id_u']);
        $uss = $this->reservation->getUserfromReservation(1);
        $vali = $this->getValidite(2);
        $this->genererVue(array('places' => $places , 'val' => $vali , 'uti' => $utilisateur, 'resa' => $resa, 'uss' => $uss));
    }

}