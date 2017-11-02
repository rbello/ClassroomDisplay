<?php
	//Inclusion des Fichiers de Configuration et Variables Global
	require_once("inc/fonctions.inc.php");
	require_once("inc/localvars.inc.php");
	
	//Vérification du jour de la semaine
	$day = isset($_GET["day"])?$_GET["day"]:date("w");
	$day;	
	//Lecture des paramètres du Site
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `params`='generer' AND `text`='1';";
	$qparams;
	$param_query = get_query($qparams);
	
	while($results = mysql_fetch_array($param_query)){
		if($day > 0 && $day < 6){
			echo "Generating file for : ".$results["site"].", date : ".date("dmY")."<br />";
			if(!generate_datefile(date("dmY"),$results["site"])){
				exit("Cannot generate datafile for : ".$results["site"]."<br />");
			}
		}else{
			echo "Generating Salles file for : ".$results["site"].", date : ".date("dmY")."<br />";
			if(!generate_sallesfile($results["site"])){
				exit("Cannot generate Salles file for : ".$results["site"]."<br />");
			}
		}
	}
?>
