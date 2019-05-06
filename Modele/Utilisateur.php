<?php

require_once 'Framework/Modele.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:24
 */

class Utilisateur extends Modele {

    public function connecter($mail, $mdp) {
        $mdp_h = $this->hacher($mdp);
        $sql = 'select id_u from users where mail = ? and mdp = ?';
        $util = $this->executerRequete($sql, array($mail, $mdp_h));
        return ($util->rowCount() == 1);
    }

    public function inscription($nom, $prenom, $mail, $mdp) {
        $mdp_h = $this->hacher($mdp);
        $sql = 'insert into users(nom, prenom, mail, mdp) values(?, ?, ?, ?)';
        $this->executerRequete($sql, array($nom, $prenom, $mail, $mdp_h));
    }

    public function getUsers() {
        $sql = 'select * from users';
        $util = $this->executerRequete($sql);
        return $util;
    }

    public function getUser($idUser) {
        $sql = 'select * from users where id_u = ?';
        $user = $this->executerRequete($sql, array($idUser));
        if ($user->rowCount() > 0)
            return $user->fetch();
        else
            throw new Exception("Aucune place ne correspond à l'identifiant '$idUser'");
    }

    public function confirmeUser($mail, $mdp) {
        $mdp_h = $this->hacher($mdp);
        $sql = 'select id_u, nom, prenom, mail, mdp, niveau, etat_u 
                from users where mail=? and mdp=?';
        $util = $this->executerRequete($sql, array($mail, $mdp_h));
        if ($util->rowCount() == 1)
            return $util->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
    }

    private function hacher($mdp){
        $mdp_h = sha1($mdp);
        return $mdp_h;
    }

}