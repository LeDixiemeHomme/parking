<?php $this->titre = "Accueil";

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

?>
    <h3>
        <?php var_dump($_SESSION);?>
    </h3>


<?php foreach ($places as $place)
{
    echo $place['num_p'];
    echo "<br>";
}