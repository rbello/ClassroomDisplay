<?php
	//Inclusion des Fichiers de Configuration et Variables Global
	require_once("inc/fonctions.inc.php");
	require_once("inc/localvars.inc.php");
	
	//Definition des Variables
	$site = isset($_GET["site"])?strtolower($_GET["site"]):"bordeaux";
	
	$pquery = "SELECT * FROM ".$SqlVar["Tables"]["Publicite"]." WHERE `site`='".$site."' AND `debut` <= '".date("Y-m-d H:i:s")."' AND `fin` >= '".date("Y-m-d H:i:s")."' ORDER BY `nbaffichage` ASC LIMIT 0,1;";
	$pub = get_query($pquery);
	$results = mysql_fetch_array($pub);
	
	if(file_exists($results["srcpub"])){
		$uquery = "UPDATE ".$SqlVar["Tables"]["Publicite"]." SET `nbaffichage`='".($results["nbaffichage"]+1)."' WHERE `id`='".$results["id"]."';";
		get_query($uquery);

		echo "<center><img src=\"".$results["srcpub"]."\" border=\"0\" /></center>";
	}
?>