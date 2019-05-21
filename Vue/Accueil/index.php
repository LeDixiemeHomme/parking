<?php $this->titre = "Accueil";

/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

?>

<h1>Accueil</h1>

<?php
if(isset($_SESSION['connecte'])) {
    switch ($niv) {
        case 0:
            echo "Votre compte à été bloqué !";
            break;
        case 1:
            echo "Votre compte est en cours de validation, patience.";
            break;
        case 2:
            echo "Votre compte à été approuvé par un administrateur.";
            break;
        case 3:
            echo "Compte administrateur.";
            break;
        case NULL:
            echo "Vous n'êtes pas connecté. <br> Inscrivez vous ou connectez vous.";
            break;
    }
    echo '<br><br>';
}
else echo "Vous n'êtes pas connecté. <br> Inscrivez vous ou connectez vous.";
?>


<a href="test">TEST AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</a>

<?php

echo '<br><br>';
echo'finies';
echo '<br><br>';
foreach ($resaf as $r)
{
    var_dump($r['id_r']);
    echo '<br><br>';
}
echo '<br><br>';
echo 'en cours';
echo '<br><br>';
foreach ($resac as $r)
{
    var_dump($r['id_r']);
    echo '<br><br>';
}
echo '<br><br>';
echo 'en attente';
echo '<br><br>';
foreach ($resaa as $r)
{
    var_dump($r['id_r']);
    echo '<br><br>';
}