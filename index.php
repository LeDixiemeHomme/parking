<?php
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 22:58
 */

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante



require 'Framework/Routeur.php';
$routeur = new Routeur();
$routeur->routerRequete();

