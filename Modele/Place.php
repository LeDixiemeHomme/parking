<?php

require_once 'Framework/Modele.php';

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 18/04/2019
 * Time: 01:25
 */

class Place extends Modele {

    public function getPlaces() {
        $sql = 'select * from place';
        $places = $this->executerRequete($sql);
        return $places;
    }

}