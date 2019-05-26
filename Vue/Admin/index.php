<?php $this->titre = "Admin";
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

<p class="p-admin">Panneau de gestion des paramètres :</p>

<p class="p-admin-1">Gestion du nombres des places :</p>
<p>Nombre de places actives : <?=$placeDispo?> place<?= afficherS($placeDispo)?>.</p>
<form class="form-inline" action="admin/modificationNombrePlace" method="post">
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="nb" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Changer nombre de place</button>
</form>

<p class="p-admin-1">Gestion du temps d'une reservation :</p>
<p> Durée actuelle des réservations : <?=$dfo?> heure<?php echo afficherS($dfo);?>.</p>

<form class="form-inline" action="admin/ModifierDuree" method="post">
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="duree" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Changer la durée des réservations</button>
</form>

<div class="t-admin-trier">
<div class="container">

    <div class="row">

        <div class="col-md-7">
            <h2>Panneau de gestion des utilisateurs :</h2>
        </div>
        <div class="col-md-5">
            <form action="admin" method="post">
                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-secondary">Trier par</button>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="choix_u" class="form-control">
                            <option value="5">Tous</option>
                            <option value="0">Banni</option>
                            <option value="1">Non approuvé</option>
                            <option value="2">Approuvé</option>
                            <option value="3">Admin</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>

<div class="tableau">
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
    <tbody> <?php $u = 0;

if (isset($_POST['choix_u']))
    $choix_u = $_POST['choix_u'];
else
    $choix_u = 5;

foreach($users as $user) {

    if ($choix_u == $user['niveau'] || $choix_u == 5) {
        $u++;
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
            case 0: echo '    <form action="admin/gracier" method="post">
                              <td colspan="2"><button type="submit" value="'.$user['id_u'].'" name="bouton" class="btn btn-primary">Gracier</button></td>
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
            default:echo '<td colspan="2"></td>'; break;
            }
        }
        echo '</tr> ';
    }
    if ($u == 0) {
        echo 'Aucun utilisateur ne correspond.';
    }
    ?>
    </tbody>
</table>
</div>


<div class="t-admin-trier">
<div class="container">

    <div class="row">

        <div class="col-md-7">
            <h2>Panneau de gestion des réservations :</h2>
        </div>
        <div class="col-md-5">
            <form action="admin" method="post">
                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-secondary">Trier par</button>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="choix_r" class="form-control">
                            <option value="0">Toutes</option>
                            <option value="1">En cours</option>
                            <option value="2">En attente</option>
                            <option value="3">Terminée</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
<div class="tableau">
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

    <?php $r = 0;

    foreach($reservations as $reservation) {

        if ($reservation['date_debut'] < $now && $reservation['date_fin'] > $now)
            $etat = 1;
        elseif ($reservation['date_debut'] > $now && $reservation['date_fin'] > $now)
            $etat = 2;
        elseif ($reservation['date_debut'] < $now && $reservation['date_fin'] < $now)
            $etat = 3;
        else
            $etat = 0;

        if (isset($_POST['choix_r']))
            $choix_r = $_POST['choix_r'];
        else
            $choix_r = 0;

    if ($choix_r == $etat || $choix_r == 0) {
            $r++;
            echo '        
            <tr>
            <td>' . $reservation['id_r'] . '</td>
            <td>' . $reservation['date_resa'] . '</td>
            <td>' . $reservation['date_debut'] . '</td>
            <td>' . $reservation['date_fin'] . '</td>
            <td>' . $reservation['id_u'] . '</td>
            <td>' . $reservation['id_p'] . '</td>';
            if ($now > $reservation['date_debut'] && $now < $reservation['date_fin'])
                $val = 1;
            elseif ($now < $reservation['date_debut'] && $now < $reservation['date_fin'])
                $val = 2;
            elseif ($now > $reservation['date_debut'] && $now > $reservation['date_fin'])
                $val = 0;
            switch ($val) {
                case 1:
                    echo '    <td><form action="admin/mettreFin" method="post">
                                  <button type="submit" value="' . $reservation['id_r'] . '" name="bouton" class="btn btn-danger">Mettre fin</button>
                                  </form></td><td>Active</td>';
                    break;
                case 2:
                    echo '<td></td><td>Attente</td>';
                    break;
                case 0:
                    echo '<td></td><td>Finie</td>';
                    break;
            }
        }
        echo '</tr> ';
    }
    if ($r == 0) {
        echo 'Aucune réservation ne correspond.';
    }
    ?>
    </tbody>
</table>
</div>


<div class="t-admin-trier">
<div class="container">

    <div class="row">

        <div class="col-md-7">
            <h2>Panneau de gestion des places :</h2>
        </div>
        <div class="col-md-5">
            <form action="admin" method="post">
                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-secondary">Trier par</button>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="choix_p" class="form-control">
                            <option value="0">Toutes</option>
                            <option value="1">Disponible</option>
                            <option value="2">Réservée</option>
                            <option value="3">En attente</option>
                            <option value="4">Indisponible</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
<div class="tableau">
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

    <?php $p = 0;

    if (isset($_POST['choix_p']))
        $choix_p = $_POST['choix_p'];
    else
        $choix_p = 0;

    foreach($places as $place) {

        if ($choix_p == $place['etat_p'] || $choix_p == 0) {
            $p++;
            echo '        
        <tr>
        <td>' . $place['id_p'] . '</td>
        <td>' . $place['num_p'] . '</td>
        <td>' . $place['etat_p'] . '</td>';
            switch ($place['etat_p']) {
                case 1:
                    echo '
                              <form action="admin/rendreIndisponible" method="post">
                              <td colspan="2"><button type="submit" value="' . $place['id_p'] . '" name="bouton" class="btn btn-danger btn-sm">Rendre indisponible</button></td>
                              </form>';
                    break;
                case 2:
                    echo '<td colspan="2"></td>';
                    break;
                case 3:
                    echo '<td colspan="2"></td>';
                    break;
                case 4:
                    echo '<form action="admin/rendreDisponible" method="post">
                          <td colspan="2"><button type="submit" value="' . $place['id_p'] . '" name="bouton" class="btn btn-success btn-sm">Rendre disponible</button></td>
                          </form>';
                    break;
                default:
                    echo '<td colspan="2"><td/>';
                    break;
            }
        }
        echo '</tr> ';
    }
    if ($p == 0) {
        echo 'Aucune place ne correspond.';
    }
    ?>
    </tbody>
</table>
</div>