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
    public function ajouterResa()
    {
        if($_SESSION['etat_u'] == 1)
        {
            $nblibre = count($this->place->getPlacesLibres());
            $nbOccupee = count($this->place->getPlacesOccupees());
            if($nblibre)
            {
                $place = $this->place->getPlaceHasard();
                $this->dateFuture->add(new DateInterval($this->duree->getDuree()['duree']));
                $date_debut = $this->dateNow->format('Y-m-d H:i:s');
                $date_fin = $this->dateFuture->format('Y-m-d H:i:s');
                $this->reservation->addReservation($date_debut, $date_fin, $_SESSION['id_u'], $place['id_p']);
                $this->place->setEtat(2, $place['id_p']);
                $this->users->setEtat(2, $_SESSION['id_u']);
                $this->requete->getSession()->setAttribut("etat_u", 2);
                $this->rediriger("compte");
            }
            elseif($nbOccupee)
            {
                $place = $this->reservation->getProchainePlaceLibre();
                $this->dateNow = new Datetime($place['date_fin']);
                $this->dateFuture = new Datetime($place['date_fin']);
                $this->dateFuture->add(new DateInterval($this->duree->getDuree()['duree']));
                $date_debut = $this->dateNow->format('Y-m-d H:i:s');
                $date_fin = $this->dateFuture->format('Y-m-d H:i:s');
                $this->reservation->addReservation($date_debut, $date_fin, $_SESSION['id_u'], $place['id_p']);
                $this->place->setEtat(3, $place['id_p']);
                $this->users->setEtat(3, $_SESSION['id_u']);
                $this->requete->getSession()->setAttribut("etat_u", 3);
                $this->rediriger("compte");
            }
            else throw new Exception("Le file d'attente est pleine");
        }
        else throw new Exception("Vous avez deja une place !");

        $this->rediriger("compte");
    }

    public function finirResa(){
        if($_SESSION['etat_u'] == 2) {
            //$resaPartant est la resa du mec qui clique pour finir sa reservation
            $resaPartant = $this->reservation->getReservationEnCoursByUser($_SESSION['id_u']);
            //met l'etat_u a 1
            $this->users->setEtat(1, $_SESSION['id_u']);
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
                $this->dateFuture->add(new DateInterval($this->duree->getDuree()['duree']));
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
            $this->rediriger("compte");
        }
    }
    public function changerMdp() {
        if ($this->requete->existeParametre("an_mdp") && $this->requete->existeParametre("nv_mdp") && $this->requete->existeParametre("mail"))
        {
            $ANmdp = $this->requete->getParametre("an_mdp");
            $NVmdp = $this->requete->getParametre("nv_mdp");
            $mail = $this->requete->getParametre("mail");
            if($userTrouve = $this->users->confirmeUser($mail, $ANmdp))
            {
                $this->users->setMdp($NVmdp, $userTrouve['id_u']);
            }
            else
                throw new Exception("Aucune correspondance avec les éléments de la base de données trouvée !");
        }
        else
            throw new Exception("Tous les éléments n'ont pas été renseignés !");
        $this->rediriger("compte");
    }
    public function index()
    {

        //requis
        $placeL = $this->place->getPlacesLibres();
        $placeO = $this->place->getPlacesOccupees();
        $users = $this->users->getUser($_SESSION['id_u']);
        $resaUser = $this->reservation->getReservationEnCoursByUser($_SESSION['id_u']);
        //$placeattente = $this->reservation->getReservationsMouvant($resaUser['date_resa']);
        $resaUAttente = $this->reservation->getReservationEnAttenteByUser($_SESSION['id_u']);

        $test = $this->reservation->getReservationsMouvant($resaUAttente['date_resa']);

        if (null !== $this->reservation->getReservationsMouvant($resaUAttente['date_resa']))
            $rang = count($this->reservation->getReservationsMouvant($resaUAttente['date_resa']));
        else
            $rang = 0;
        $this->genererVue(array('users' => $users,
            'placeL' => $placeL,
            'placeO' => $placeO,
            'resaU' => $resaUser,
            'rang' => $rang,
            'test' => $test));
    }
}