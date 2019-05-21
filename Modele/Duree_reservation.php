<?php

require_once 'Framework/Modele.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:25
 */

class Duree_reservation extends Modele {

    public function getDuree() {
        $sql = 'select duree from duree_reservation';
        $places = $this->executerRequete($sql);
        return $places->fetch();
    }

    public function setDuree($duree) {
        $sql = 'UPDATE duree_reservation SET duree = ?';
        $place = $this->executerRequete($sql, array($duree));
    }

}