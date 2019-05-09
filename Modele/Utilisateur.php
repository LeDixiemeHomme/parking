<?php

require_once 'Framework/Modele.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:24
 */

class Utilisateur extends Modele {

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

    public function setEtat($etat_u, $id_u){
        $sql = 'UPDATE users SET etat_u = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($etat_u, $id_u));
    }

    public function setNiveau($niveau, $id_u){
        $sql = 'UPDATE users SET niveau = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($niveau, $id_u));
    }

    public function setPrenom($prenom, $id_u){
        $sql = 'UPDATE users SET prenom = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($prenom, $id_u));
    }

    public function setNom($nom, $id_u){
        $sql = 'UPDATE users SET nom = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($nom, $id_u));
    }

    public function setMail($mail, $id_u){
        $sql = 'UPDATE users SET mail = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($mail, $id_u));
    }

    public function setMdp($mdp, $id_u){
        $mdp_h = $this->hacher($mdp);
        $sql = 'UPDATE users SET mdp = ? WHERE id_u = ?';
        $util = $this->executerRequete($sql, array($mdp_h, $id_u));
    }

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