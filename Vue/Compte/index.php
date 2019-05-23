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
    {        echo '<h2>Votre place est la place '.$resaU['num_p'].'.</h2>';    }
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

    if(($_SESSION['etat_u'] == 1) && ($placeL)) {
            echo '<br><br>
    <form action="compte/ajouterResa" method="post">
        <button type="submit" class="btn btn-outline-primary">Réserver une place !</button>
    </form>' ; }
    elseif (($_SESSION['etat_u'] == 1 && ($placeL == false) && ($placeO))) {
            echo '<br><br>
    <form action="compte/ajouterResa" method="post">
        <button type="submit" class="btn btn-outline-primary">Prendre une place dans la file d\'attente !</button>
    </form>' ; }
    elseif((isset($_SESSION['etat_u'])) && ($_SESSION['etat_u'] == 2)) {
            echo '<br><br>
    <form action = "compte/finirResa" method = "post">
        <button type = "submit" class="btn btn-outline-danger"> Mettre fin à sa reservation !</button >
    </form >' ; }
    elseif (($_SESSION['etat_u'] == 1 && ($placeL == false) && ($placeO == false)))
    {
        echo 'Malheureuement il n\'y a plus de place et la liste d\'attente est pleine !';
    }
    ?>
<br><br><br>
<p>Vous pouvez changer de mot de passe ici :</p>

<form class="form-inline" action="compte/changerMdp" method="post">
    <div class="form-group mx-sm-2 mb-2">
        <input type="email" class="form-control" name="mail" placeholder="Votre email">
    </div>
    <div class="form-group mx-sm-2 mb-2">
        <input type="password" class="form-control" name="an_mdp" placeholder="Ancien mot de passe">
    </div>
    <div class="form-group mx-sm-2 mb-2">
        <input type="password" class="form-control" name="nv_mdp" placeholder="Nouveau mot de passe">
    </div>
    <button type="submit" class="btn btn-primary mx-sm-3 mb-2">Changer de mot de passe</button>
</form>
