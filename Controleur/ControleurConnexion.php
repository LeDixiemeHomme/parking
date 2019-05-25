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
        if ($this->requete->existeParametre("mail") && $this->requete->existeParametre("mdp_h")) {
            $mail = $this->requete->getParametre("mail");
            $mdp_h = $this->requete->getParametre("mdp_h");
            if ($this->utilisateur->connecter($mail, $mdp_h)) {
                $utilisateur = $this->utilisateur->confirmeUser($mail, $mdp_h);
                $this->requete->getSession()->setAttribut("connecte", true);
                $this->requete->getSession()->setAttribut("mail", $utilisateur['mail']);
                $this->requete->getSession()->setAttribut("id_u", $utilisateur['id_u']);
                $this->requete->getSession()->setAttribut("nom", $utilisateur['nom']);
                $this->requete->getSession()->setAttribut("prenom", $utilisateur['prenom']);
                $this->requete->getSession()->setAttribut("niveau", $utilisateur['niveau']);
                $this->requete->getSession()->setAttribut("etat_u", $utilisateur['etat_u']);
                $this->rediriger("accueil");
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