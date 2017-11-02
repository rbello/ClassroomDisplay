<?php
	//Inclusion des Fichiers de Configuration et Variables Global
	require_once("inc/fonctions.inc.php");
	require_once("inc/localvars.inc.php");
	
	$site = isset($_GET['site'])?$_GET['site']:"";
	var_dump($site);
	if(!empty($site)){
		echo "Generating Salles file for : ".$site.", date : ".date("dmY")."<br />";
		if(!generate_sallesfile($site)){
			exit("Cannot generate Salles file for : ".$site."<br />");
		}
	}
?>
