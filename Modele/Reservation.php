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

    public function getValidite($idResa) {
        $resa = $this->getReservation($idResa);
        if ($resa['date_debut'] < $resa['date_fin']) {
            $validite = true;
        }
        elseif ($resa['date_fin'] < $resa['date_debut'] ) {
            $validite = false;
        }
        else {
            throw new Exception("Aucune reservation ne correspond à l'identifiant '$idResa'");
        }
        return $validite;
    }



}