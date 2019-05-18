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

<p>Bonjour <?=$users['prenom'].' '. $users['nom']?> </p>

<div>

    bouton qui add une resa avec id_u de session , nump aleatoire , met les date automatiquement <br>

    si pas de place alors changer l'etat du mec eet lui attribuer une date de resa <br>

    bouton pour fermer une reservation , donc mettre la date fin = now <br>

    afficher num p en cours <br>

    rang dans la file d'attente <br>

    modifier son mot de passe <br>


    <form action="compte/ajouterResa" method="post">
        <button type="button" class="btn btn-outline-primary">Primary</button>
    </form>


<?php /*
$m = 0;
if($nb > 0) {
    if($nb == 1) {
        echo 'Vous avez réservé une place, la voici :'; }
    else {  echo 'Vous avez reservé des places, les voici :';}

    echo '
    <table class="table table-borderless">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Place</th>
      <th scope="col">Date Résa</th>
      <th scope="col">Date Début</th>
      <th scope="col">Date Fin</th>
      <th scope="col">Temps Restant</th>
    </tr>
  </thead>
  <tbody>' ;

   foreach( $resa as $r )
  {

      $m += 1;
      ?><tr>
      <th scope="row"><?=$m?></th>
      <td><?=$r['num_p']?></td>
      <td><?=$r['date_resa']?></td>
      <td><?=$r['date_debut']?></td>
      <td><?=$r['date_fin']?></td>
      <td>A FAIRE</td>
      </tr><?php
  }
      '
  </tbody>
</table>
    ';
}
else { echo 'Vous n\'avez pas de réservation en cours.';}

  ?>
</div>
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
    <button type="button" class="btn btn-outline-primary">Primary</button>
</form>

<?php */