<?php

require_once 'Securite/ControleurBloqueSecurise.php';

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 10/05/2019
 * Time: 02:20
 */

class ControleurBloque extends ControleurBloqueSecurise {


    public function index()
    {
        $this->genererVue();
    }

}
