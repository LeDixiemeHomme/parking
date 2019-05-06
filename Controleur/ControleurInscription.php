<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 06/05/2019
 * Time: 02:52
 */

class ControleurInscription extends Controleur {

    private $utilisateur;

    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
    }

    public function index() {
        $this->genererVue();
    }

    public function inscrire() {

        if ($this->requete->existeParametre("mail")
            && $this->requete->existeParametre("mdp_h")
            && $this->requete->existeParametre("nom")
            && $this->requete->existeParametre("prenom")) {

                $mail = $this->requete->getParametre("mail");
                $mdp_h = $this->requete->getParametre("mdp_h");
                $nom = $this->requete->getParametre("nom");
                $prenom = $this->requete->getParametre("prenom");

                $this->utilisateur->inscription($nom, $prenom, $mail, $mdp_h);
                $this->rediriger("accueil");

        }
        else
            throw new Exception("Action impossible : Informations non définies");
    }

}