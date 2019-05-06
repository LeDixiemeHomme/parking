<?php
/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 23:59
 */

?>
<!doctype html>
<html lang="fr">
    <head>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

        <meta charset="UTF-8" />
        <base href="<?= $racineWeb ?>" >
        <link rel="stylesheet" href="Contenu/style.css" />
        <title><?= $titre ?></title>
</head>
<body>
<div id="global">
    <header>
        <a href=""><h1>Site de gestion de parking</h1></a>
        <nav>
            <ul>
                <?php
                    if(isset($_SESSION['connecte']))
                        {
                            echo '<li><p><a href="compte">Acceder à mon compte</a></p></li>';
                            echo '<li><p><a href="connexion/deconnecter">Se déconnecter</a></p></li>';
                        }
                    else
                        {
                            echo '<li><p><a href="connexion">Se connecter</a></p></li>';
                            echo '<li><p><a href="inscription">S\'inscrire</a></p></li>';
                        }
                ?>
            </ul>
        </nav>
    </header>


