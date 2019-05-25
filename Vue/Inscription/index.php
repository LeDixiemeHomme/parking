<?php
/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 06/05/2019
 * Time: 02:56
 */
?>

<form action="inscription/inscrire" method="post">
    <div class="form-group">
        <label for="nom">Nom de famille</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom de famille">
    </div>
    <div class="form-group">
        <label for="prenom">Prenom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prenom">
    </div>
    <div class="form-group">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp_h" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="email">Adresse mail</label>
        <input type="email" class="form-control" id="email" placeholder="vous@example.com" name="mail" required>
        <div class="invalid-feedback">
            Un e-mail valide est requis

        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>