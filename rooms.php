<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Création de profile</title>
    <link href="inc/bootstrap.css" rel="stylesheet">
    <link href="inc/cover.css" rel="stylesheet">
  </head>

  <body>
    <h1>Assistant création de profile</h1>
  <?php

if (array_key_exists('room', $_GET)) {
    echo '<code style="display:block;text-align:left;">';
    echo '&lt;?php<br>
<br>
return array(<br>
    "nomEtablissement" => "A COMPLETER",<br>
    "codeEtablissement" => "A COMPLETER",<br>
    "salles" => "'.implode(' ', $_GET['room']).'"<br>
);';
    echo '</code>';
}

include 'inc/init.php';

if (is_null($_CAD)) {
    echo "Error : CAD is not initialized";
    exit();
}

$data = $_CAD->getClassRoomsList();

echo '<form>';
echo '<input type="submit" style="position:fixed;top:10px;right:10px" value="Create profile" />';
echo '<table>';
echo '<tr><th>NomEtablissement</th><th>NomSalle</th><th>CodeSalle</th></tr>';

foreach ($data as $room) {
	echo '<tr><td>'.htmlentities($room['NomEtablissement']).'</td><td>'.htmlentities($room['NomSalle']).'</td><td>'.htmlentities($room['CodeSalle']).' <input type="checkbox" name="room[]" value="'.$room['CodeSalle'].'" /></td></tr>';
}

echo '</table>';
echo '</form>';

?>
</body>
</html>