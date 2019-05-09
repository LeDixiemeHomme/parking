<?php $this->titre = "Accueil";

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

?>

<h1>Accueil</h1>

<?php var_dump($resae);

echo '<br><br>';

foreach ($resae as $e )
{
    var_dump($e['id_r']);
    var_dump($e['date_fin']);
    echo '<br><br>';
}