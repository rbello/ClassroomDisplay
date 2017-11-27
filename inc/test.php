<table>
  <tr>
    <td style="text-align:right">Configuration de la base de données :</td>
    <td>
    <?php
    
    if (!class_exists('PDO')) {
        echo '<span class="failure">L\'extension PDO de PHP n\'est pas installée</span>';
    }
    else if (!in_array('sqlsrv', PDO::getAvailableDrivers())) {
        echo '<span class="failure">Le driver PDO_SQLSRV n\'est pas installé</span>';
    }
    else if (!isset($_CAD)) {
        echo '<span class="failure">La CAD n\'est pas initialisée</span>';
    }
    else {
        echo '<span class="success">OK</span>';
    }
    
    ?>
    </td>
  </tr>
  <tr>
    <td style="text-align:right">Thème :</td>
    <td>
    <?php
    
    if (!file_exists('themes/' . $_CONFIG['theme'] . '/index.php')) {
        echo '<span class="failure">Le thème <b>'. $_CONFIG['theme'] .'</b> n\'est pas installé.</span>';
    }
    else {
        echo '<span class="success">OK</span>';
    }
    
    ?>
    </td>
  </tr>
</table>