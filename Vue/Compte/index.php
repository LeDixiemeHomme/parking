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

<ul class="list-group list-group-flush">
    <?php

    foreach ($reservations as $reservation)
    {
        echo '<li class="list-group-item disabled">'.$reservation['id_p'].'</li>';
        echo '<li class="list-group-item disabled">'.$reservation['id_r'].'</li>';
    }?>
</ul>

    <ul class="list-group list-group-flush">
<?php

foreach ($places as $place)
{
  echo '<li class="list-group-item disabled">'.$place['num_p'].'</li>';
}?>
    </ul>
