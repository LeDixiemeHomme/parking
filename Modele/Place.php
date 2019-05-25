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
        return $places->fetchAll();
    }

    public function getPlace($idPlace) {
        $sql = 'select * from place where id_p=?';
        $place = $this->executerRequete($sql, array($idPlace));
        if ($place->rowCount() > 0)
            return $place->fetch();
        else
            throw new Exception("Aucune place ne correspond à l'identifiant '$idPlace'");
    }

    public function getPlacesLibres() {
        $sql = 'select * from place where etat_p = 1';
        $places = $this->executerRequete($sql);
        return $places->fetchAll();
    }

    public function getPlacesOccupees() {
        $sql = 'select * from place where etat_p = 2';
        $places = $this->executerRequete($sql);
        return $places->fetchAll();
    }

    public function getPlacesAttentes() {
        $sql = 'select * from place where etat_p = 3';
        $places = $this->executerRequete($sql);
        return $places->fetchAll();
    }

    public function getPlacesIndisponibles() {
        $sql = 'select * from place where etat_p = 4';
        $places = $this->executerRequete($sql);
        return $places->fetchAll();
    }

    public function getNbPlaces() {
        $sql = 'select count(*) as nbPlaces from place';
        $resultat = $this->executerRequete($sql);
        $ligne = $resultat->fetch();
        return $ligne['nbPlaces'];
    }

    public function getPlaceHasard() {
        $sql = 'select id_p from place where etat_p = 1 order by RAND ( ) LIMIT 1';
        $places = $this->executerRequete($sql);
        return $places->fetch();
    }

    public function setDisponibleWHEREIndisponible() {
        $sql = 'UPDATE place SET etat_p = 1 WHERE etat_p = 4';
        $place = $this->executerRequete($sql);
    }

    public function setIndisponibleWHEREDisponible() {
        $sql = 'UPDATE place SET etat_p = 4 WHERE etat_p = 1 LIMIT 1';
        $place = $this->executerRequete($sql);
    }

    public function setEtat($etat_p, $id_p) {
        $sql = 'UPDATE place SET etat_p = ? WHERE id_p = ?';
        $place = $this->executerRequete($sql, array($etat_p, $id_p));
    }

    public function setNum($id_p, $id) {
        $sql = 'UPDATE place SET num_p = "n°"? where id_p = ?';
        $place = $this->executerRequete($sql, array($id_p, $id));
    }

    public function addPlace($etat_p) {
        $sql = 'insert into place(etat_p) values (?)';
        $this->executerRequete($sql, array($etat_p));
    }
}