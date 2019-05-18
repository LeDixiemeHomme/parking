<?php
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:25
 */

class Reservation extends Modele {

    /**
     * @return array avec toutes les reservations de la table reservation
     */
    public function getReservations() {
        $sql = 'select * from reservation';
        $resa = $this->executerRequete($sql);
        return $resa->fetchAll();
    }

    /**
     * @param $idResa
     * @return une reservation selon son id passé en parametre
     * @throws Exception
     */
    public function getReservation($idResa) {
        $sql = 'select * from reservation where id_r = ?';
        $resa = $this->executerRequete($sql, array($idResa));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idResa'");
    }

    /**
     * @param $idUser
     * @return une reservation en fonction de l'id d'un utilisateur passé en paramètre
     * @throws Exception
     */
    public function getReservationsUser($idUser) {
        $sql = 'select * from reservation where id_u = ?';
        $resa = $this->executerRequete($sql, array($idUser));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idUser'");
    }

    /**
     * @param $idPlace
     * @return une reservation en fonction de l'id d'une place passé en paramètre
     * @throws Exception
     */
    public function getReservationsPlace($idPlace) {
        $sql = 'select * from reservation where id_u = ?';
        $resa = $this->executerRequete($sql, array($idPlace));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idPlace'");
    }

    /**
     * @param $id_p
     * @return array
     * @throws Exception
     */
    public function getPlacefromReservation($id_p) {
        $sql = 'select p.id_p, p.num_p, p.etat_p
                from reservation r, place p where r.id_r = ? && r.id_p = p.id_p';
        $resa = $this->executerRequete($sql, array($id_p));
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$id_p'");
    }

    public function getAllByReservation($id_r) {
        $sql = 'select * from reservation r, users u, place p where r.id_r = ? AND r.id_u = u.id_u AND p.id_p = r.id_p';
        $resa = $this->executerRequete($sql, array($id_r));
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$id_r'");
    }

    public function getAllByUser($id_u) {
        $sql = 'select * from reservation r, users u, place p 
                where ? = r.id_u AND p.id_p = r.id_p AND r.id_u = u.id_u';
        $resa = $this->executerRequete($sql, array($id_u));
        if ($resa->rowCount() > 0)
            return $resa;
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$id_u'");
    }

    public function getAllByPlace($id_p) {
        $sql = 'select * from reservation r, users u, place p where r.id_u = u.id_u AND r.id_p = ? AND p.id_p = r.id_p';
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

    public function tempsRestant($id_r) {
        $sql = 'select datediff(date_debut, date_fin) from reservation where id_r = ?';
        $date = $this->executerRequete($sql, array($id_r));
        return $date;
    }
}