<?php

require_once 'Framework/Controleur.php';

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 10/05/2019
 * Time: 02:23
 */

abstract class ControleurBloqueSecurise extends Controleur
{

    public function executerAction($action)
    {
        // Vérifie si les informations utilisateur sont présents dans la session
        // Si oui, l'utilisateur s'est déjà authentifié : l'exécution de l'action continue normalement
        // Si non, l'utilisateur est renvoyé vers le contrôleur de connection
        if ((isset($_SESSION['connecte'])) && $_SESSION['niveau'] == 0) {
            parent::executerAction($action);
        }
        else {
            $this->rediriger("connection");
        }
    }

}