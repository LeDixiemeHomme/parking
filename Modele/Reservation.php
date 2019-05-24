<?php
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:25
 */

class Reservation extends Modele {

    /**
     * @return array avec toutes les infos des reservations des tables reservation users et place
     */
    public function getReservations() {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p';
        $resa = $this->executerRequete($sql);
        return $resa->fetchAll();
    }

    /**
     * @param $idResa
     * @return une reservation selon son id passé en parametre
     * @throws Exception
     */
    public function getReservation($idResa) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_r = ?';
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
    public function getReservationsByUser($idUser) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_u = ?';
        $resa = $this->executerRequete($sql, array($idUser));
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idUser'");
    }

    /**
     * @param $idPlace
     * @return une reservation en fonction de l'id d'une place passé en paramètre
     * @throws Exception
     */
    public function getReservationsByPlace($idPlace) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_p = ?';
        $resa = $this->executerRequete($sql, array($idPlace));
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
        else
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idPlace'");
    }

    /**
     * @return array des reservation qui ne sont pas encore terminées
     */
    public function getReservationsEnCours() {
        $sql = 'select r.id_r, r.id_u, r.id_p, r.date_resa, r.date_debut, r.date_fin,
                u.nom, u.prenom, u.mail, u.niveau, u.etat_u,
                p.num_p, p.etat_p  
                from reservation r, users u, place p
                where u.id_u = r.id_u and p.id_p = r.id_p and date_debut < NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
    }

    public function getReservationEnCoursByUser($idUser) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_u = ? and date_debut < NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql, array($idUser));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
    }

    public function getReservationEnCoursByPlace($idPlace) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_p = ? and date_debut < NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql, array($idPlace));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
    }

    public function getReservationsEnAttentes() {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and date_debut > NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
    }

    public function getReservationEnAttenteByUser($idUser) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_u = ?  and date_debut > NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql, array($idUser));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
    }

    public function getReservationEnAttenteByPlace($idPlace) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and r.id_p = ?  and date_debut > NOW() and date_fin > NOW()';
        $resa = $this->executerRequete($sql, array($idPlace));
        if ($resa->rowCount() > 0)
            return $resa->fetch();
    }

    public function getReservationsMouvant($date_resa) {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and etat_u = 3 and date_resa <= ?';
        $resa = $this->executerRequete($sql, array($date_resa));
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();

    }

    /**
     * @return array des reservation qui sont terminées
     */
    public function getReservationsFinies() {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u
                where u.id_u = r.id_u and p.id_p = r.id_p and date_fin < NOW()';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
    }

    public function getProchainePlaceLibre() {
        $sql = 'select r.id_p, date_resa, date_debut, date_fin 
                from place p, reservation r 
                where p.etat_p = 2 and p.id_p = r.id_p
                order by (date_resa) LIMIT 1';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa->fetch();
    }

    public function getListeAttente() {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and u.etat_u = 3 and p.etat_p = 3
                order by (date_resa)';
        $resa = $this->executerRequete($sql);
        if ($resa->rowCount() > 0)
            return $resa->fetchAll();
    }

    public function getReservationPlace4() {
        $sql = 'select id_r, r.id_u, r.id_p, date_resa, date_debut, date_fin, nom, prenom, mail, niveau, etat_u, num_p, etat_p  
                from reservation r, place p, users u 
                where u.id_u = r.id_u and p.id_p = r.id_p and etat_p = 4';
        $places = $this->executerRequete($sql);
        return $places->fetch();
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

    public function setIdUser($id_u, $id_r){
        $sql = 'UPDATE reservation SET id_u = ? WHERE id_r = ?';
        $util = $this->executerRequete($sql, array($id_u, $id_r));
    }

    public function setIdPlace($id_p, $id_r){
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