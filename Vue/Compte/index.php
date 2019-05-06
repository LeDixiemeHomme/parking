<?php $this->titre = "Mon compte";
/**
 * Created by PhpStorm.
 * User: benoi
 * Date: 05/05/2019
 * Time: 21:27
 */

foreach ($places as $place)
{
    echo $place['num_p'];
    echo '<br><br>';
}

foreach ($reservations as $reservation)
{
    echo $reservation.'<br>';
}

var_dump($val);