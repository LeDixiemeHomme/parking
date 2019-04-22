<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

class ControleurConnexion extends Controleur
{
    private $utilisateur;

    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
    }

    public function index()
    {
        $this->genererVue();
    }

    public function connecter()
    {
        if ($this->requete->existeParametre("mail") && $this->requete->existeParametre("mdp")) {
            $mail = $this->requete->getParametre("mail");
            $mdp = $this->requete->getParametre("mdp");
            if ($this->utilisateur->connecter($mail, $mdp)) {
                $utilisateur = $this->utilisateur->getUtilisateur($mail, $mdp);
                $this->requete->getSession()->setAttribut("idUtilisateur",
                        $utilisateur['idUtilisateur']);
                $this->requete->getSession()->setAttribut("mail",
                        $utilisateur['mail']);
                $this->rediriger("test");
            }
            else
                $this->genererVue(array('msgErreur' => 'Login ou mot de passe incorrects'),
                        "index");
        }
        else
            throw new Exception("Action impossible : login ou mot de passe non défini");
    }

    public function deconnecter()
    {
        $this->requete->getSession()->detruire();
        $this->rediriger("accueil");
    }

}
