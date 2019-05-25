<?php
require_once 'Securite/ControleurSecurise.php';
require 'Modele/Utilisateur.php';
require 'Modele/Place.php';
require 'Modele/Reservation.php';
/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 19/04/2019
 * Time: 12:38
 */
class ControleurTest extends ControleurSecurise {
    private $users;
    private $place;
    private $reservation;
    private $temps_resa = '2 hours';
    public function __construct() {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
        $this->dateNow = new Datetime('now');
        $this->dateFuture = new Datetime('now');
    }
    public function ajouterPlace() {
        if ($this->requete->existeParametre("nbAjout")) {
            $nbAjout = $this->requete->getParametre("nbAjout");
            $nbPlaces = count($this->place->getPlaces());
            $nbLibres = count($this->place->getPlacesLibres());
            $nbOccupees = count($this->place->getPlacesOccupees());
            $nbAttentes = count($this->place->getPlacesAttentes());
            $nbIndisponibles = $nbAttentes + $nbOccupees;
            //tester si ce nombre de place est inferieur au nombre de place reservées
            if($nbAjout < $nbIndisponibles)
            {
                $nbPlaceNecessaire = $nbAjout - $nbPlaces;
                $nbPlaceLibreNecessaire = $nbPlaceNecessaire - $nbIndisponibles;
            }
            else
                throw new Exception("Ce nombre de place est inférieur au nombre de place réservées.");
        }
        else
            throw new Exception("Action impossible : nombre de place non défini.");
    }
    public function index()
    {
        $n = 3;
        $p = 3;
        $p *= -1;
        //$this->place->setIndisponibleOuDisponible(2);
        $places = $this->place->getPlaces();
        $nbPlaces = count($this->place->getPlaces());
        $nbLibres = count($this->place->getPlacesLibres());
        $nbOccupees = count($this->place->getPlacesOccupees());
        $nbAttentes = count($this->place->getPlacesAttentes());
        $nbIndisponibles = $nbAttentes + $nbOccupees;
        $resaCours = count($this->reservation->getReservationsEnCours());
        $resaU = count($this->reservation->getReservationEnCoursByUser($_SESSION['id_u']));
        $this->genererVue(
            array('places' => $places,
                'nbPlaces' => $nbPlaces,
                'nbLibres' => $nbLibres,
                'nbOccupees' => $nbOccupees,
                'nbAttentes' => $nbAttentes,
                'nbIndisponibles' => $nbIndisponibles,
                'resaCours' => $resaCours,
                'resaU' => $resaU,
                'p' => $p,
                'n' =>$n));
    }
}