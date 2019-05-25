<?php $this->titre = "Admin";
/**
 * Created by PhpStorm.
 * Utilisateur: benoi
 * Date: 17/04/2019
 * Time: 23:12
 */
?>

<h1>Admin</h1>

réinitialisation de mdp <br>

consulter liste d'attente <br>

donner une place a un utilisateur <br>

editer liste d'attente

<?= '<br>'; ?>
<?= '<br>'; ?>

<?= '<br><h2>Panneau de gestion des paramètres :</h2>' ?>


<?= '<br><p>Gestion du nombres des places :</p>' ?>
<?= '<p>Nombre de places actives : '.$placeDispo.'</p>' ?>

<form class="form-inline" action="admin/modificationNombrePlace" method="post">
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="nb" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Changer nombre de place</button>
</form>

<?= '<br><p>Gestion du temps d\'une reservation :</p>' ?>
<?= '<p> Durée actuelle des réservations : '.$dfo.' heure(s).</p>' ?>

<form class="form-inline" action="admin/ModifierDuree" method="post">
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="duree" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Changer la durée des réservations</button>
</form>

<?= '<br>'; ?>
<?php $n = 1; ?>
<?= '<br><h2>Panneau de gestion des utilisateurs :</h2><br>' ?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id_u</th>
        <th scope="col">Nom</th>
        <th scope="col">Prenom</th>
        <th scope="col">Mail</th>
        <th scope="col">Niv</th>
        <th scope="col">Etat_u</th>
        <th scope="col">Action</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user) {
        echo '        
        <tr>
        <td>'.$user['id_u'].'</td>
        <td>'.$user['nom'].'</td>
        <td>'.$user['prenom'].'</td>
        <td>'.$user['mail'].'</td>
        <td>'.$user['niveau'].'</td>
        <td>'.$user['etat_u'].'</td>';
        switch ($user['niveau'])
        {
            case 0: echo '<td></td>
                              <form action="admin/gracier" method="post">
                              <td><button type="submit" value="'.$user['id_u'].'" name="bouton" class="btn btn-primary">Gracier</button></td>
                              </form>';
                break;
            case 1: echo '<td><form action="admin/approuver" method="post">
                              <button type="submit"  value="'.$user['id_u'].'" name="bouton" class="btn btn-success">Approuver</button>
                              </form></td>
                              <td><form action="admin/bannir" method="post">
                              <button type="submit" value="'.$user['id_u'].'" name="bouton" class="btn btn-danger">Bannir</button>
                              </form></td>';
                break;
            case 2: echo '<form action="admin/bannir" method="post">
                              <td><button type="submit" value="'.$user['id_u'].'" name="bouton" class="btn btn-success">Réserver</button></td>
                              </form>
                              <form action="admin/bannir" method="post">
                              <td><button type="submit" value="'.$user['id_u'].'" name="bouton" class="btn btn-danger">Bannir</button></td>
                              </form>';
                break;
            default:echo '<td></td><td></td>'; break;
        }
        echo '</tr> ';
        $n += 1; } ?>
    </tbody>
</table>


<?php $n = 1; ?>
<?= '<br><h2>Panneau de gestion des réservations :</h2><br>' ?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id_r</th>
        <th scope="col">Date_Resa</th>
        <th scope="col">Date_Début</th>
        <th scope="col">Date_Fin</th>
        <th scope="col">id_u</th>
        <th scope="col">id_p</th>
        <th scope="col">Action</th>
        <th scope="col">Etat</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($reservations as $reservation) {
        echo '        
        <tr>
        <td>'.$reservation['id_r'].'</td>
        <td>'.$reservation['date_resa'].'</td>
        <td>'.$reservation['date_debut'].'</td>
        <td>'.$reservation['date_fin'].'</td>
        <td>'.$reservation['id_u'].'</td>
        <td>'.$reservation['id_p'].'</td>';
        if ($now > $reservation['date_debut'] && $now < $reservation['date_fin'])
            $val = 1;
        elseif ($now < $reservation['date_debut'] && $now < $reservation['date_fin'])
            $val = 2;
        elseif ($now > $reservation['date_debut'] && $now > $reservation['date_fin'])
            $val = 0;
        switch ($val)
        {
            case 1: echo '    <td><form action="admin/mettreFin" method="post">
                              <button type="submit" value="'.$reservation['id_r'].'" name="bouton" class="btn btn-danger">Mettre fin</button>
                              </form></td><td>Active</td>';
                break;
            case 2: echo '
                              <td></td><td>Attente</td>';
                break;
            case 0:echo '<td></td><td>Finie</td>'; break;
        }
        echo '</tr> ';
        $n += 1; } ?>
    </tbody>
</table>


<?= '<br>'; ?>
<?php $n = 1; ?>

<div class="container">

    <div class="row">

        <div class="col-md-7">
            <h2>Panneau de gestion des places :</h2>
        </div>
        <div class="col-md-5">
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6" action="admin" method="post">
                        <button type="submit" name="trierPlaces" class="btn btn-primary">Trier par</button>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control">
                            <option value="1">Tous</option>
                            <option value="4" selected>Disponible</option>
                            <option value="0">Indisponible</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id_p</th>
        <th scope="col">Num_p</th>
        <th scope="col">Etat_p</th>
        <th scope="col">Action</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($places as $place) {
        if ($place['etat_p'] <> 4) {
            echo '        
        <tr>
        <td>' . $place['id_p'] . '</td>
        <td>' . $place['num_p'] . '</td>
        <td>' . $place['etat_p'] . '</td>';
            switch ($place['id_p']) {
                case 0:
                    echo '<td></td>
                              <form action="admin/gracier" method="post">
                              <td><button type="submit" value="' . $place['id_p'] . '" name="bouton" class="btn btn-primary">indispo</button></td>
                              </form>';
                    break;
                case 1:
                    echo '<td><form action="admin/approuver" method="post">
                              <button type="submit"  value="' . $place['id_p'] . '" name="bouton" class="btn btn-primary">Approuver</button>
                              </form></td>
                              <td><form action="admin/bannir" method="post">
                              <button type="submit" value="' . $place['id_p'] . '" name="bouton" class="btn btn-primary">Bannir</button>
                              </form></td>';
                    break;
                case 2:
                    echo '<td></td>
                              <form action="admin/bannir" method="post">
                              <td><button type="submit" value="' . $place['id_p'] . '" name="bouton" class="btn btn-primary">Bannir</button></td>
                              </form>';
                    break;
                default:
                    echo '<td></td><td></td>';
                    break;
            }
        }
        echo '</tr> ';
        $n += 1; } ?>
    </tbody>
</table>