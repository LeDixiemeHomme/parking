<?php

require_once 'Securite/ControleurAdminSecurise.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Place.php';
require_once 'Modele/Reservation.php';
require_once 'Modele/Duree_reservation.php';

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 10/05/2019
 * Time: 01:40
 */

class ControleurAdmin extends ControleurAdminSecurise
{
    private $users;
    private $reservation;
    private $place;
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

    public function approuver(){
        if ($this->requete->existeParametre("bouton")) {
            $id_u = $this->requete->getParametre("bouton");
            $this->users->setNiveau(2, $id_u);
        }
        $this->rediriger("admin");
    }

    public function gracier(){
        if ($this->requete->existeParametre("bouton")) {
            $id_u = $this->requete->getParametre("bouton");
            $this->users->setNiveau(2, $id_u);
        }
        $this->rediriger("admin");
    }

    public function bannir(){
        if ($this->requete->existeParametre("bouton")) {
            $id_u = $this->requete->getParametre("bouton");
            $this->users->setNiveau(0, $id_u);
        }
        $this->rediriger("admin");
    }

    public function modificationNombrePlace() {

        if ($this->requete->existeParametre("nb")){
            $nbVoulu = $this->requete->getParametre("nb");
            $nbPlaces = count($this->place->getPlaces());
            $nbPlacesLibres = count($this->place->getPlacesLibres());
            $nbPlacesOccupees = count($this->place->getPlacesOccupees());
            $nbPlacesAttentes = count($this->place->getPlacesAttentes());
            $nbPlacesIndisponibles = count($this->place->getPlacesIndisponibles());

            $resultat = $nbVoulu - $nbPlaces;
            $placesReservees = $nbPlacesAttentes + $nbPlacesOccupees;
            if( $nbVoulu >= $placesReservees)
            {
                $this->place->setDisponibleOuIndisponible();
                if($resultat > 0)
                {
                    while ($resultat > 0)
                    {
                        $resultat--;
                        $this->place->addPlace(1);
                    }
                }
                elseif ($resultat < 0)
                {
                    $resultat *= -1;
                    while ($resultat > 0)
                    {
                        $resultat--;
                        $this->place->setIndisponibleOuDisponible();
                    }
                }
            }
            else
                throw new Exception("Le nombre de place désiré est inférieur au nombre de places réservées actuellement.");

        }
        foreach ($this->place->getPlaces() as $place)
        {
            $this->place->setNum($place['id_p'], $place['id_p']);
        }
        $this->rediriger("admin");
    }

    public function ModifierDuree() {
        if ($this->requete->existeParametre("duree")){
            $duree = intval($this->requete->getParametre("duree"));
            if ($duree > 0 && $duree < 100)
            $this->duree->setDuree('PT'.$duree.'H');
            else
                throw new Exception("La valeur saisie est aberrante.");
        }
        $this->rediriger("admin");
    }

    public function mettreFin() {

        if ($this->requete->existeParametre("bouton")) {
            $id_r = $this->requete->getParametre("bouton");

            $resa = $this->reservation->getReservation($id_r);
            $user = $this->users->getUser($resa['id_u']);
            $place = $this->place->getPlace($resa['id_p']);
            if($user['etat_u'] == 2) {

                //$resaPartant est la resa du mec qui clique pour finir sa reservation
                $resaPartant = $this->reservation->getReservationEnCoursByUser($user['id_u']);
                //met l'etat_u a 1
                $this->users->setEtat(1, $user['id_u']);
                $this->requete->getSession()->setAttribut("etat_u", 1);
                //$resaPretentant est la resa de celui dans la file d'attente qui devait avoir la place de celui qui part
                $resaPretendant = $this->reservation->getReservationEnAttenteByPlace($resaPartant['id_p']);
                if($resaPretendant)
                {
                    //$resaMouvant est la liste des resa en attente avant celle de celui qui devait bouger
                    $resaMouvant = $this->reservation->getReservationsMouvant($resaPretendant['date_resa']);
                    //$resaPremierListeAttente est la resa du premier de la liste d'attente
                    $ListeAttente = $this->reservation->getListeAttente();
                    $resaPremierListeAttente = $ListeAttente[0];
                    //attribu l'id de la place appartenant a celui qui part a la resa du premier de la liste d'attente
                    $this->reservation->setIdPlace($resaPartant['id_p'], $resaPremierListeAttente['id_r']);
                    //creation d'une date_r = now()
                    $this->dateNow = new Datetime('now');
                    $date_r = $this->dateNow->format('Y-m-d H:i:s');
                    //met la date_r a la resa du premier de la liste d'attente
                    $this->reservation->setDateDebut($date_r, $resaPremierListeAttente['id_r']);
                    //creation d'une date date_2 = now() + duree
                    $this->dateFuture->add(new DateInterval('PT2H'));
                    $date_fin = $this->dateFuture->format('Y-m-d H:i:s');
                    $this->reservation->setDateFin($date_fin, $resaPremierListeAttente['id_r']);
                    //met l'etat_u du premier de la liste a 2
                    $this->users->setEtat(2, $resaPremierListeAttente['id_u']);
                    $temp = $resaPremierListeAttente;

                    foreach ($resaMouvant as $mouv) {
                        if ($mouv['id_r'] <> $resaPremierListeAttente['id_r']) {
                            $this->reservation->setIdPlace($temp['id_p'], $mouv['id_r']);
                            $this->reservation->setDateDebut($temp['date_debut'], $mouv['id_r']);
                            $this->reservation->setDateFin($temp['date_fin'], $mouv['id_r']);
                            $temp = $mouv;
                        }
                    }

                    $this->dateNow = new Datetime('now');
                    $date_p = $this->dateNow->format('Y-m-d H:i:s');
                    $this->reservation->setDateFin($date_p, $resaPartant['id_r']);
                }
                else
                {
                    $this->place->setEtat(1, $resaPartant['id_p']);
                    $this->dateNow = new Datetime('now');
                    $date_p = $this->dateNow->format('Y-m-d H:i:s');
                    $this->reservation->setDateFin($date_p, $resaPartant['id_r']);
                }
            }
            else
                throw new Exception("L'utilisateur n'a pas de réservation en cours !");
        }
        else
            throw new Exception("Mauvais chemin pour utiliser cette fonction !");

        $this->rediriger("admin");
    }

    public function donnerPlace() {

        if ($this->requete->existeParametre("bouton")) {
            $id_u = $this->requete->getParametre("bouton");

            $user = $this->users->getUser($id_u);

            if($user['etat_u'] == 1)
            {
                $nblibre = count($this->place->getPlacesLibres());
                if($nblibre)
                {
                    $place = $this->place->getPlaceHasard();
                    $this->dateFuture->add(new DateInterval('PT2H'));
                    $date_debut = $this->dateNow->format('Y-m-d H:i:s');
                    $date_fin = $this->dateFuture->format('Y-m-d H:i:s');
                    $this->reservation->addReservation($date_debut, $date_fin, $user['id_u'], $place['id_p']);
                    $this->place->setEtat(2, $place['id_p']);
                    $this->users->setEtat(2, $user['id_u']);
                    $this->requete->getSession()->setAttribut("etat_u", 2);
                    $this->rediriger("compte");
                }
                else
                {
                    $place = $this->reservation->getProchainePlaceLibre();
                    $this->dateNow = new Datetime($place['date_fin']);
                    $this->dateFuture = new Datetime($place['date_fin']);
                    $this->dateFuture->add(new DateInterval('PT2H'));
                    $date_debut = $this->dateNow->format('Y-m-d H:i:s');
                    $date_fin = $this->dateFuture->format('Y-m-d H:i:s');
                    $this->reservation->addReservation($date_debut, $date_fin, $user['id_u'], $place['id_p']);
                    $this->place->setEtat(3, $place['id_p']);
                    $this->users->setEtat(3, $user['id_u']);
                    $this->requete->getSession()->setAttribut("etat_u", 3);
                    $this->rediriger("compte");
                }
            }
            else throw new Exception("Cet utilisateur a deja une place !");
        }
        else
            throw new Exception("Mauvais chemin pour utiliser cette fonction !");

        $this->rediriger("admin");
    }

    public function index()
    {

        //requis
        $now = $this->dateNow->format('Y-m-d H:i:s');

        $duree_format = substr($this->duree->getDuree()['duree'], 2, strlen($this->duree->getDuree()['duree']) - 3);

        $users = $this->users->getUsers();
        $reservations = $this->reservation->getReservations();
        $places = $this->place->getPlaces();

        $nbPlace = count($places);
        $nbPlaceIndispo = count($this->place->getPlacesIndisponibles());
        $placeDispo = $nbPlace - $nbPlaceIndispo;

        $this->genererVue(array('users' => $users,
            'reservations' => $reservations,
            'places' => $places,
            'placeDispo' => $placeDispo,
            'dfo' => $duree_format,
            'now' => $now));
    }
}