<?php $this->titre = "Mon compte";

/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:27
 */

?>

<h1>Le compte de <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?>.</h1>

<h2>Vous trouverez des informations utiles vous concernant.</h2>

<h3>Votre historique de réservation :</h3>

<ul class="list-group list-group-flush">
    <?php

  /*  foreach ($reservations as $reservation)
    {
        echo '<li class="list-group-item disabled">Ici le numéro de la place : '.$reservation['id_p'].'</li>';
        echo '<li class="list-group-item disabled">'.$reservation['id_r'].'</li>';
        echo '<br>';
    }

  */
  ?>

</ul>

<form action="compte/ajouterResa" method="post">
    <div class="form-group">
        <label for="nom">Nom de famille</label>
        <input type="date" class="form-control" id="nom" name="date_debut">
    </div>
    <div class="form-group">
        <label for="nom">Nom de famille</label>
        <input type="date" class="form-control" id="nom" name="date_fin">
    </div>
    <div class="form-group">
        <label for="prenom">Prenom</label>
        <input type="text" class="form-control" id="prenom" name="id_p" placeholder="Entrez votre prenom">
    </div>
    <div class="form-group">
        <label for="prenom">Prenom</label>
        <input type="text" class="form-control" id="prenom" name="id_u" placeholder="Entrez votre prenom">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

