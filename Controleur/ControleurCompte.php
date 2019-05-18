<?php

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:07
 */

require_once 'Securite/ControleurSecurise.php';
require 'Modele/Utilisateur.php';
require 'Modele/Place.php';
require 'Modele/Reservation.php';

class ControleurCompte extends ControleurSecurise
{

    private $users;
    private $reservation;
    private $place;
    private $temps_resa = '2 hours';

    public function __construct()
    {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
        $this->dateNow = new Datetime('now');
        $this->dateFuture = new Datetime('now');
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

    function ajoutTemps($date,$temps_ajoute)
    {
        $date = date_add($date, date_interval_create_from_date_string($temps_ajoute));
        return $date;
    }

    /*public function ajouterResa()
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
    }*/

    public function ajouterResa()
    {
        if($_SESSION['etat_u'] == 1)
        {
            $nblibre = count($this->place->getPlacesLibres());
            if($nblibre)
            {
                $place = $this->place->getPlaceHasard();
                $date_debut = $this->dateNow->format('Y-m-d H:i:s');
                $date_fin = $this->ajoutTemps($this->dateFuture,$this->temps_resa)->format('Y-m-d H:i:s');
                $this->reservation->addReservation($date_debut, $date_fin, $_SESSION['id_u'], $place['id_p']);
                $this->rediriger("compte");
            }
            else
            {
                echo 'echec !';
            }
        }
    }

    public function index()
    {
        //$reservation = $this->ajouterResa();
        //$nb = count($reservation);
        $users = $this->users->getUser($_SESSION['id_u']);
        $this->genererVue(array('users' => $users));
    }

}