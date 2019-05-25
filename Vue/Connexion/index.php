<?php $this->titre = "Mon Blog - Connexion"?>

    <form action="connexion/connecter" method="post">
        <div class="form-group">
            <label for="email">Adresse mail</label>
            <input type="email" class="form-control" id="email" placeholder="vous@example.com" name="mail" required>
            <div class="invalid-feedback">
                Un e-mail valide est requis

            </div>
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp_h" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php if (isset($msgErreur)): ?>
    <p><?= $msgErreur ?></p>
<?php endif; ?>