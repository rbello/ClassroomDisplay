<?php

include 'inc/init.php';

$data = $_CAD->getClassRoomsList();

echo '<table>';
echo '<tr><th>NomEtablissement</th><th>NomSalle</th><th>CodeSalle</th></tr>';

foreach ($data as $room) {
	echo '<tr><td>'.htmlentities($room['NomEtablissement']).'</td><td>'.htmlentities($room['NomSalle']).'</td><td>'.htmlentities($room['CodeSalle']).'</td></tr>';
}

echo '</table>';