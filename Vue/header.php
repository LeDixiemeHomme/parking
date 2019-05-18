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
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <?php
                    if(isset($_SESSION['connecte']))
                    {
                        switch ($_SESSION['niveau'])
                        {
                            case 1: echo '<li class="nav-item"><a class="nav-link" href="">En cours de validation</a></li>'; break;
                            case 2: echo '<li class="nav-item"><a class="nav-link" href="compte">Compte</a></li>'; break;
                            case 3: echo '<li class="nav-item"><a class="nav-link" href="admin">Compte Admin</a></li>';
                                    echo '<li class="nav-item"><a class="nav-link" href="compte">Compte</a></li>'; break;
                            default:echo '<li class="nav-item"><a class="nav-link" href="bloque">Compte bloqué</a></li>'; break;
                        }
                        echo '<li class="nav-item"><a class="nav-link" href="connection/deconnecter">Se déconnecter</a></li>';
                    }
                    else
                    {
                        echo '
                        <li class="nav-item"><a class="nav-link" href="connection">Se connecter</a></li>
                        <li class="nav-item"><a class="nav-link" href="inscription">S\'inscrire</a></li>
                        '; } ?>
                </div>
            </nav>

            <a href=""><h1>Site de gestion de parking</h1></a>

    </header>


