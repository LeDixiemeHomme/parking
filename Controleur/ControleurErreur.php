<?php
require_once 'Framework/Controleur.php';
/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 10/05/2019
 * Time: 01:40
 */
class ControleurErreur extends Controleur {
    public function index()
    {
        $this->genererVue();
    }
}