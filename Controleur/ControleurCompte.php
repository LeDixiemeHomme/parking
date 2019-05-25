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
require_once 'Modele/Duree_reservation.php';

class ControleurCompte extends ControleurSecurise
{

    private $users;
    private $reservation;
    private $place;
    private $temps_resa = '2 hours';
    private $duree;

    public function __construct()
    {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
        $this->dateNow = new Datetime('now');
        $this->dateFuture = new Datetime('now');
        $this->duree = new Duree_reservation();
    }

    public function getValidite($idResa) {
        $resa = $this->reservation->getReservation($idResa);
        return ($resa['date_debut'] < $resa['date_fin']);
    }

    function ajoutTemps($date,$temps_ajoute)
    {
        $date = date_add($date, date_interval_create_from_date_string($temps_ajoute));
        return $date;
    }

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
                $this->place->setEtat(2, $place['id_p']);
                $this->users->setEtat(2, $_SESSION['id_u']);
                $this->requete->getSession()->setAttribut("etat_u", 2);
                $this->rediriger("compte");
            }
            else
            {
                $place = $this->reservation->getProchainePlaceLibre();
                $date_debut = new Datetime($place['date_fin']);
                //$date_debut = $place['date_fin'];
                $date_fin = $this->ajoutTemps($date_debut,$this->temps_resa)->format('Y-m-d H:i:s');
                $date_debut = new Datetime($place['date_fin']);
                $date_debut = $date_debut->format('Y-m-d H:i:s');
                $this->reservation->addReservation($date_debut, $date_fin, $_SESSION['id_u'], $place['id_p']);
                $this->place->setEtat(3, $place['id_p']);
                $this->users->setEtat(3, $_SESSION['id_u']);
                $this->requete->getSession()->setAttribut("etat_u", 3);
                $this->rediriger("compte");
            }
        }
        else throw new Exception("Vous avez deja une place !");
    }

    public function finirResa(){
        //$resaPartant est la resa du mec qui clique pour finir sa reservation
        $resaPartant = $this->reservation->getReservationEnCoursByUser($_SESSION['id_u']);
        //met l'etat_u a 1
        $this->users->setEtat(1, $_SESSION['id_u']);
        $this->requete->getSession()->setAttribut("etat_u", 1);
        //$resaPretentant est la resa de celui dans la file d'attente qui devait avoir la place de celui qui part
        $resaPretendant = $this->reservation->getReservationEnAttenteByPlace($resaPartant['id_p']);
        //$resaMouvant est la liste des resa en attente avant celle de celui qui devait bouger
        $resaMouvant = $this->reservation->getReservationsMouvant($resaPretendant['date_resa']);
        //$resaPremierListeAttente est la resa du premier de la liste d'attente
        $ListeAttente = $this->reservation->getListeAttente();
        $resaPremierListeAttente = $ListeAttente[0];
        //attribu l'id de la place appartenant a celui qui part a la resa du premier de la liste d'attente
        $this->reservation->setIdPlace($resaPartant['id_p'], $resaPremierListeAttente['id_r']);
        //creation d'une date_r = now()
        $date_debut = new Datetime('now');
        $date_r = $date_debut->format('Y-m-d H:i:s');
        //met la date_r a la resa du premier de la liste d'attente
        $this->reservation->setDateDebut($date_r, $resaPremierListeAttente['id_r']);
        //creation d'une date date_2 = now() + 2 heures
        $date_2 = $this->ajoutTemps($this->dateFuture,$this->temps_resa)->format('Y-m-d H:i:s');
        //met la date_2 a la resa du premier de la liste d'attente
        $this->reservation->setDateFin($date_2, $resaPremierListeAttente['id_r']);
        //met l'etat_u du premier de la liste a 2
        $this->users->setEtat(2, $resaPremierListeAttente['id_u']);
        $temp = $resaPremierListeAttente;

        foreach ($resaMouvant as $mouv) {
            if($mouv['id_r'] <> $resaPremierListeAttente['id_r'])
            {
                $this->reservation->setIdPlace($temp['id_p'], $mouv['id_r']);
                $this->reservation->setDateDebut($temp['date_debut'], $mouv['id_r']);
                $this->reservation->setDateFin($temp['date_fin'], $mouv['id_r']);
                $temp = $mouv;
            }

        }
        $date_debut = new Datetime('now');
        $date_p = $date_debut->format('Y-m-d H:i:s');
        $this->reservation->setDateFin($date_p, $resaPartant['id_r']);
        $this->rediriger("compte");
    }

    public function index()
    {
        $place = $this->reservation->getProchainePlaceLibre();
        $users = $this->users->getUser($_SESSION['id_u']);
        $resaUser = $this->reservation->getReservationEnCoursByUser($_SESSION['id_u']);
        $placeattente = $this->reservation->getReservationsMouvant($resaUser['date_resa']);

        $resaUAttente = $this->reservation->getReservationEnAttenteByUser($_SESSION['id_u']);
        if (isset($this->reservation->getReservationsMouvant($resaUAttente['date_resa'])))
        $rang = count($this->reservation->getReservationsMouvant($resaUAttente['date_resa']));
        else
            $rang = 0;

        $this->genererVue(array('users' => $users , 'place' => $place, 'resaU' => $resaUser, 'rang' => $rang));
        //$this->place->addPlace(rand(1, 60), 2);
    }

}