<?php $this->titre = "Mon compte";

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:27
 */

?>

<h1>Le compte de <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?>.</h1>

<p>Sur cette page vous trouverez des informations utiles vous concernant.</p>

<?php

    if($resaU)
    {        echo '<h2>Votre place est la place n°'.$resaU['num_p'].'.</h2>';    }
    else
    {        echo '<h2>Vous n\'avez pas de reservation.</h2>';    }

    switch ($rang) {
        case 0:
            echo '<h2>Vous n\'êtes pas dans la file d\'attente.</h2>';
            break;
        case 1:
            echo '<h2>Vous êtes 1 er dans la file d\'attente.</h2>';
            break;
        default:
            echo '<h2>Vous êtes '.$rang.' eme dans la file d\'attente.</h2>';
            break;
        }

    if((isset($_SESSION['etat_u'])) && ($_SESSION['etat_u'] == 1)) {
            echo '<br><br>
    <form action="compte/ajouterResa" method="post">
        <button type="submit" class="btn btn-outline-primary">Réserver une place !</button>
    </form>' ; } ?>

    <?php if((isset($_SESSION['etat_u'])) && ($_SESSION['etat_u'] == 1 && ($place == false))) {
            echo '<br><br>
    <form action="compte/ajouterResa" method="post">
        <button type="submit" class="btn btn-outline-primary">Prendre une place dans la file d\'attente !</button>
    </form>' ; } ?>

    <?php if((isset($_SESSION['etat_u'])) && ($_SESSION['etat_u'] == 2)) {
            echo '<br><br>
    <form action = "compte/finirResa" method = "post" >
        <button type = "submit" class="btn btn-outline-danger" > Mettre fin à sa reservation !</button >
    </form >' ; }
