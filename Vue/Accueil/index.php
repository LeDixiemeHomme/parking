<?php $this->titre = "Accueil";
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */

function afficherS($valeur) {
    if ($valeur > 1)
        $s = 's';
    else
        $s = '';
    return $s;
}?>

<p class="p-accueil-1">
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
            echo "Vous n'êtes pas connecté. <br> Inscrivez vous ou connectez vous.<br>";
            break;
    }
    echo '<br>';
}
else echo "Vous n'êtes pas connecté. <br> Inscrivez vous ou connectez vous.<br>";
?>
</p>

<p class="p-accueil-1">Il reste <?=$pLibre?> place<?=afficherS($pLibre)?> libre<?=afficherS($pLibre)?></p>