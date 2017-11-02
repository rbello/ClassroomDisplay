<?php
function getsalle($site){
	if(!is_site($site)){
		exit("Le site renseigné n'existe pas dans la base.");
	}
	
	//Construction du chemin du fichier
	$foldername = "sites/".$site."/";
	$filename = $foldername."salles.xml";
	
	//Vérification de l'existance du dossier
	//Création du dossier s'il n'éxiste pas
	if(!is_dir($foldername)){
		mkdir($foldername) or exit("Unable to Generate folder : ".$foldername);
	}
	
	//Vérification de l'éxistance du fichier
	if(!is_file($filename)){
		echo "File has not yet been generated : ".$filename;
		return Array();
	}
	
	$salles = Array();
	//Open the file for reading or exit execution on fail
	$file = fopen($filename, "r") or exit("Unable to open file : ".$filename);
	
	//Read the file line by line until we reach the end of the file
	$line="";
	$i=0;
	while(!feof($file)){
			$line = fgets($file);
			if(strpos(strtolower($line), "<table>")){
				$salles[$i] = Array();
				while(!strpos(strtolower($line),"</table>")){
					$line = fgets($file);
					if(preg_match_all("|<([^>]+)>(.*)</[^>]+>|U",$line,$out)){
						$balise = $out[1][0];
						$valeur = normalize($out[2][0]);

						$balise = preg_replace("/è/","e",$balise);
						$balise = preg_replace("/é/","e",$balise);
						$balise = preg_replace("/ë/","e",$balise);
						$balise = preg_replace("/â/","a",$balise);
						
						$salles[$i][$balise] = $valeur;
					}
				}
			}
			$i = $i + 1;
	}
	fclose($file);
	return $salles;
}

function xmlreadfile($site,$date){
	if(!is_site($site)){
		exit("Le site renseigné n'existe pas dans la base.");
	}
	
	//Construction du chemin du fichier
	$foldername = "sites/".$site."/";
	$filename = $foldername.$date.".xml";
	
	//Vérification de l'existance du dossier
	//Création du dossier s'il n'éxiste pas
	if(!is_dir($foldername)){
		mkdir($foldername) or exit("Unable to Generate folder : ".$foldername);
	}
	
	//Vérification de l'éxistance du fichier
	if(!is_file($filename)){
		echo "File has not yet been generated : ".$filename;
		return Array();
	}
	
	$afficheur = Array();
	//Open the file for reading or exit execution on fail
	$file = fopen($filename, "r") or exit("Unable to open file : ".$filename);
	
	//Read the file line by line until we reach the end of the file
	$line="";
	$i=0;
	while(!feof($file)){
			$line = fgets($file);
			if(strpos(strtolower($line), "<table>")){
				$afficheur[$i] = Array();
				while(!strpos(strtolower($line),"</table>")){
					$line = fgets($file);
					if(preg_match_all("|<([^>]+)>(.*)</[^>]+>|U",$line,$out)){
						$balise = $out[1][0];
						$valeur = normalize($out[2][0]);

						$balise = preg_replace("/è/","e",$balise);
						$balise = preg_replace("/é/","e",$balise);
						$balise = preg_replace("/ë/","e",$balise);
						$balise = preg_replace("/â/","a",$balise);
						
						$afficheur[$i][$balise] = $valeur;
					}
				}
			}
			$i = $i + 1;
	}
	fclose($file);
	return $afficheur;
}

function normalize($string){
	$string = preg_replace('/À/','&Agrave;', $string);
	$string = preg_replace('/Ç/','&Ccedil;', $string);
	$string = preg_replace('/È/','&Egrave;', $string);
	$string = preg_replace('/É/','&Eacute;',$string);
	$string = preg_replace('/Ê/','&Ecirc;', $string);
	$string = preg_replace('/Ë/','&Euml;', $string);
	$string = preg_replace('/Î/','&Icirc;', $string);
	$string = preg_replace('/Ï/','&Iuml;', $string);
	$string = preg_replace('/Ô/','&Ocirc;', $string);
	$string = preg_replace('/Ù/','&Ugrave;',$string);
	$string = preg_replace('/Ú/','&Uacute;',$string);
	$string = preg_replace('/Û/','&Ucirc;', $string);	
	$string = preg_replace('/Ü/','&Uuml;', $string);
	$string = preg_replace('/à/','&agrave;',$string);
	$string = preg_replace('/â/','&acirc;', $string);
	$string = preg_replace('/ä/','&auml;', $string);
	$string = preg_replace('/ç/','&ccedil;',$string);
	$string = preg_replace('/è/','&egrave;',$string);
	$string = preg_replace('/é/','&eacute;',$string);
	$string = preg_replace('/ê/','&ecirc;', $string);
	$string = preg_replace('/ë/','&euml;', $string);
	$string = preg_replace('/î/','&icirc;', $string);
	$string = preg_replace('/ï/','&iuml;', $string);	
	$string = preg_replace('/ò/','&ograve;',$string);
	$string = preg_replace('/ó/','&oacute;',$string);
	$string = preg_replace('/ô/','&ocirc;', $string);
	$string = preg_replace('/ö/','&ouml;', $string);
	$string = preg_replace('/ù/','&ugrave;', $string);
	$string = preg_replace('/ú/','&uacute;', $string);
	$string = preg_replace('/û/','&ucirc;', $string);
	$string = preg_replace('/ÿ/','&yuml;', $string);
	
	return $string;
}

function corres_salles($site, $string){
	require("localvars.inc.php");
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["NomsSalles"]." WHERE `site`='".$site."' AND `salle`='".addslashes(trim(normalize($string)))."';";
	$param_query = get_query($qparams);
	$nbresults = mysql_num_rows($param_query);
	
	if($nbresults > 0){
		$results = mysql_fetch_array($param_query);
		return stripslashes($results["nouveaunom"]);
	}else{
		return stripslashes($string);
	}
}

function updatesalles($site, $oldname, $newname){
	require("localvars.inc.php");
	if( corres_salles( $site, htmlentities($oldname) ) == $newname ){
		return false;
	}else{
		$query = "INSERT INTO ".$SqlVar["Tables"]["NomsSalles"]." VALUES('','".$site."','".addslashes(trim(htmlentities($oldname)))."','".addslashes(trim(htmlentities($newname)))."')";
		$sendquery = get_query($query);
		return true;
	}
}

function corres_promo($site, $string){
	require("localvars.inc.php");
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["NomsPromotions"]." WHERE `site`='".$site."' AND `promo`='".addslashes(trim(normalize($string)))."';";
	$param_query = get_query($qparams);
	$nbresults = mysql_num_rows($param_query);
	
	if($nbresults > 0){
		$results = mysql_fetch_array($param_query);
		return stripslashes($results["nouveaunom"]);
	}else{
		return stripslashes($string);
	}
}

function updatepromo($site, $oldname, $newname){
	require("localvars.inc.php");
	if( corres_promo( $site, htmlentities($oldname) ) == $newname ){
		return false;
	} else {
		// JADT 11/01/2012
		// tentative de modification de la requête pour que les modifications soient prises en comptes
		// Il faut finir le boulot
		$query = "SELECT * FROM ".$SqlVar["Tables"]["NomsPromotions"]." WHERE `nompromo`.`site` LIKE '".$site."' AND `nompromo`.`promo` LIKE '".addslashes(trim(htmlentities($oldname)))."'";
		$nbresults = mysql_num_rows(get_query($query));
		if ($nbresults == 0) {
			$query = "INSERT INTO ".$SqlVar["Tables"]["NomsPromotions"]." VALUES('','".$site."','".addslashes(trim(htmlentities($oldname)))."','".addslashes(trim(htmlentities($newname)))."')";
		} else {
			$query = "UPDATE ".$SqlVar["Tables"]["NomsPromotions"]." SET `nouveaunom` = '".addslashes(trim(htmlentities($newname)))."' WHERE `nompromo`.`site` LIKE '".$site."' AND `nompromo`.`promo` LIKE '".addslashes(trim(htmlentities($oldname)))."'";
		}
		
		$sendquery = get_query($query);
		return $sendquery;
	}
}

function generate_datefile($date, $site){
	echo "Starting Generation<br />";
	require("localvars.inc.php");
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$site."' AND `params`='codesite';";
	$param_query = get_query($qparams);
	$results = mysql_fetch_array($param_query);
	echo "Code site : ".$results["text"]."<br />";
	echo "Site : ".$site."<br />";
	echo "Date : ".$date."<br />";
	
	$pwspath = "mono sql.exe";
	$pwscript = format_date_iso($date,"-")." ".$results["text"]." \"sites/".$site."/".$date.".xml\"";
		
	$exec = $pwspath." ".$pwscript;
	echo "Path : ".$exec."<br />";
	
	system("set MONO_SHARED_DIR=\"/tmp\"");
	exec($exec);
	
	//Construction du chemin du fichier
	$foldername = "sites/".$site."/";
	$filename = $foldername.$date.".xml";
	
	if(is_file($filename)){
		return true;
	}else{
		return false;
	}
}

function generate_sallesfile($site){
	echo "Starting Generation<br />";
	require("localvars.inc.php");
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$site."' AND `params`='codesite';";
	$param_query = get_query($qparams);
	$results = mysql_fetch_array($param_query);
	echo "Code site : ".$results["text"]."<br />";
	echo "Site : ".$site."<br />";
	echo "Date : ".$date."<br />";
	
		//Construction du chemin du fichier
	$foldername = "sites/".$site."/";
	$filename = $foldername."salles.xml";
	
	if(!is_dir($foldername)){
		mkdir($foldername);
		touch($filename);
	}

	$pwspath = "mono sql.exe";
	$pwscript = "Salle ".$results["text"]." \"sites/".$site."/salles.xml\"";
		
	$exec = $pwspath." ".$pwscript;
	echo "Path : ".$exec."<br />";
	
	system("set MONO_SHARED_DIR=\"/tmp\"");
	exec($exec);
	
	if(is_file($filename)){
		//Supression de toutes les salles du site
		echo "Deleting salles for ".$site."<br />";
		$qsalles = "DELETE FROM ".$SqlVar["Tables"]["Salles"]." WHERE `codesite`='".$results["text"]."';";
		get_query($qsalles);
		
		//Recréation des salles
		$newsalles = getsalle($site);
		foreach($newsalles as $salle){
			echo "Creating salle : ".$salle["NomSalle"]."<br />";
			$qsalle = "INSERT INTO ".$SqlVar["Tables"]["Salles"]." VALUES('','".$results["text"]."','".$salle["CodeSalle"]."','".addslashes($salle["NomSalle"])."');";
			get_query($qsalle);
		}
		return true;
	}else{
		return false;
	}
}

function format_date($date,$seperator){
	return substr($date,0,2).$seperator.substr($date,2,2).$seperator.substr($date,4,4);
}

function format_date_iso($date,$seperator){
	return substr($date,4,4).$seperator.substr($date,2,2).$seperator.substr($date,0,2);
}

function get_query( $query ) {
        require("localvars.inc.php");
        mysql_connect($SqlVar["host"],$SqlVar["Username"],$SqlVar["password"]);
        mysql_select_db($SqlVar["db"]);
        $result = mysql_query($query) or die("Error while processing, please email the webmaster<br /><small>".$query."</small>".mysql_error());
        return $result;
}

function is_site($site){
	require("localvars.inc.php");
	$query = "SELECT * FROM ".$SqlVar["Tables"]["Sites"]." WHERE `site`='".strtolower($site)."'";
	$sendq = get_query($query);
	$results = mysql_num_rows($sendq);
	
	if($results > 0){
		return true;
	}else{
		return false;
	}	
}

function site_name( $id ){
	require("localvars.inc.php");
	$query = "SELECT * FROM ".$SqlVar["Tables"]["Sites"]." WHERE `id`='".$id."' LIMIT 0,1";
	$sendq = get_query($query);
	$results = mysql_fetch_array($sendq);
	
	return $results["site"];
}

function username( $id ){
	require("localvars.inc.php");
	$query = "SELECT * FROM ".$SqlVar["Tables"]["Admins"]." WHERE `id`='".$id."' LIMIT 0,1";
	$sendq = get_query($query);
	$results = mysql_fetch_array($sendq);
	
	return $results["username"];
}

function site_id( $name ){
	require("localvars.inc.php");
	$query = "SELECT site,params,text FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$name."' AND `params`='codesite' LIMIT 0,1";
	$sendq = get_query($query);
	$results = mysql_fetch_array($sendq);
	
	return $results["text"];
}

function redirect($page, $msg="", $error=false){
	echo "<script type=\"text/javascript\">\n";
	$connector = "";
	if(strstr($page,"?")){
		$connector = "&";
	}else{
		$connector = "?";
	}
	$newpage = $page.$connector."msg=".urlencode($msg)."&error=".$error;
	echo "window.location.href=\"".$newpage."\";\n";
	echo "</script>\n";
}

function confirm($msg, $pageyes, $pageno){
	echo "<script type=\"text/javascript\">";
	echo "var answer = confirm (\"".$msg."\");\n";
	echo "if (answer)\n";
	echo "window.location.href=\"".$pageyes."\";\n";
	echo "else\n";
	echo "window.location.href=\"".$pageno."\";\n";
	echo "</script>\n";

}
?>
