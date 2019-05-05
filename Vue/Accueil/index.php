<?php $this->titre = "Mon Parking";

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

?> <a href="connexion">Se connecter</a>

    <h1>
        <?php var_dump($_SESSION); ?>
    </h1>
<?php

foreach ($users as $user)
{
    var_dump($user['mdp']);
    echo '<br><br>';
    ?>
    <a href="<?= "test/index/" . $this->nettoyer($user['mdp']) ?>">
        <h1 class="titreBillet"><?= $this->nettoyer($user['nom']) ?></h1>
    </a>
    <a href="test/index">zdazd</a>
    <?php
}