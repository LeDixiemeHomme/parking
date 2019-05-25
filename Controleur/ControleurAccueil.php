<?php
require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Place.php';
require_once 'Modele/Reservation.php';
require_once 'Modele/Duree_reservation.php';
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
    private $duree;
    public function __construct() {
        $this->users = new Utilisateur();
        $this->place = new Place();
        $this->reservation = new Reservation();
        $this->duree = new Duree_reservation();
    }
    public function index()
    {
        $ALL_RESA_FINIES = $this->reservation->getReservationsFinies();
        $ALL_RESA_EN_COURS = $this->reservation->getReservationsEnCours();
        $ALL_RESA_ATTENTES = $this->reservation->getReservationsEnAttentes();
        if($ALL_RESA_FINIES) {
            foreach ($ALL_RESA_FINIES as $resa) {
                if ($resa['etat_p'] <> 4){
                    $this->users->setEtat(1, $resa['id_u']);
                    $this->place->setEtat(1, $resa['id_p']);
                    if (isset($_SESSION['id_u']) && $_SESSION['id_u'] == $resa['id_u']) {
                        $this->requete->getSession()->setAttribut("etat_u", 1);
                    }}
            }
        }
        if($ALL_RESA_EN_COURS) {
            foreach ($ALL_RESA_EN_COURS as $resa) {
                if ($resa['etat_p'] <> 4){
                    $this->users->setEtat(2, $resa['id_u']);
                    $this->place->setEtat(2, $resa['id_p']);
                    if (isset($_SESSION['id_u']) && $_SESSION['id_u'] == $resa['id_u']) {
                        $this->requete->getSession()->setAttribut("etat_u", 2);
                    }}
            }
        }
        if($ALL_RESA_ATTENTES) {
            foreach ($ALL_RESA_ATTENTES as $resa) {
                if ($resa['etat_p'] <> 4){
                    $this->users->setEtat(3, $resa['id_u']);
                    $this->place->setEtat(3, $resa['id_p']);
                    if (isset($_SESSION['id_u']) && $_SESSION['id_u'] == $resa['id_u']) {
                        $this->requete->getSession()->setAttribut("etat_u", 3);
                    }}
            }
        }
        if(isset($_SESSION['id_u'])) {
            $users = $this->users->getUser($_SESSION['id_u']);
        }
        if(isset($users['niveau']))$niveau = $users['niveau'];
        else $niveau = NULL;
        $nbPlacesLibres = count($this->place->getPlacesLibres());
        $this->genererVue(array('niv' => $niveau, 'pLibre' => $nbPlacesLibres));
    }
}