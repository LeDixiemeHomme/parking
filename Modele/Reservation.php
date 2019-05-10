<?php
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:25
 */

class Reservation extends Modele {

    public function getReservations() {
        $sql = 'select * from reservation';
        $resa = $this->executerRequete($sql);
        return $resa;
    }

    public function getReservation($idResa) {
        $sql = 'select * from reservation where id_r = ?';
        $resa = $this->executerRequete($sql, array($idResa));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idResa'");
    }

    public function getReservationsUser($idUser) {
        $sql = 'select * from reservation where id_u = ?';
        $resa = $this->executerRequete($sql, array($idUser));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idUser'");
    }

    public function getReservationsPlace($idPlace) {
        $sql = 'select * from reservation where id_u = ?';
        $resa = $this->executerRequete($sql, array($idPlace));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idPlace'");
    }

    public function getUserfromReservation($id_r) {
        $sql = 'select u.id_u, u.nom, u.prenom, u.mail, u.etat_u, u.niveau 
                from reservation r, users u where r.id_r = ? && r.id_u = u.id_u';
        $resa = $this->executerRequete($sql, array($id_r));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$id_r'");
    }

    public function getPlacefromReservation($id_p) {
        $sql = 'select p.id_p, p.num_p, p.etat_p
                from reservation r, place p where r.id_r = ? && r.id_p = p.id_p';
        $resa = $this->executerRequete($sql, array($id_p));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$id_p'");
    }

    public function getReservationEnCours() {
        $sql = 'select * from reservation 
                where NOW() < date_fin';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa;
    }

    public function getReservationFinies() {
        $sql = 'select * from reservation 
                where NOW() > date_fin';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa;
    }

    public function getReservationAttente() {
        $sql = 'select * from reservation 
                where date_resa is true AND date_debut IS NULL AND date_debut IS NULL';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa;
    }

    public function setDateFin($date_fin, $id_r){
        $sql = 'UPDATE reservation SET date_fin = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($date_fin, $id_r));
    }

    public function setDateDebut($date_debut, $id_r){
        $sql = 'UPDATE reservation SET date_debut = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($date_debut, $id_r));
    }

    public function setDateResa($date_resa, $id_r){
        $sql = 'UPDATE reservation SET date_resa = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($date_resa, $id_r));
    }

    public function setIdPlace($id_u, $id_r){
        $sql = 'UPDATE reservation SET id_u = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($id_u, $id_r));
    }

    public function setIdUser($id_p, $id_r){
        $sql = 'UPDATE reservation SET id_p = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($id_p, $id_r));
    }

    public function addReservation($date_debut, $date_fin, $id_u, $id_p) {
        $sql = 'insert into reservation(date_resa, date_debut, date_fin, id_u, id_p) values (NOW(),?,?,?,?)';
        $this->executerRequete($sql, array($date_debut, $date_fin, $id_u, $id_p));
    }

    public function isEnAttente($id_r) {
        $sql = 'select * from reservation 
                where id_r = ? AND date_resa is true AND date_debut IS NULL AND date_debut IS NULL';
        $resa = $this->executerRequete($sql, array($id_r));
            return $resa->rowCount() > 0;
    }

    public function isEnCours($id_r) {
        $sql = 'select * from reservation 
                where id_r = ? AND NOW() < date_fin';
        $resa = $this->executerRequete($sql, array($id_r));
        return $resa->rowCount() > 0;
    }

    public function isFinies($id_r) {
        $sql = 'select * from reservation 
                where id_r = ? AND NOW() > date_fin';
        $resa = $this->executerRequete($sql, array($id_r));
        return $resa->rowCount() > 0;
    }

}