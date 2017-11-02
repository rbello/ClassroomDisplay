<?php

include 'inc/init.php';

// No profile, display an information page
if (!array_key_exists('profile', $_GET)) {
	include 'inc/welcome.html';
	return;
}

// Extract profile name
$profileFile = 'config/' . str_replace('.', '', $_GET['profile']) . '.profile.php';
if (!file_exists($profileFile)) {
	$_ERROR = 'Profile non configuré';
	include 'inc/error.html';
	return;
}

// Setup profile
$_PROFILE = include $profileFile;
$_PROFILE['name'] = str_replace('.', '', $_GET['profile']);

// Include theme index
include 'themes/' . $_CONFIG['theme'] . '/index.php';

return;

	//Inclusion des Fichiers de Configuration et Variables Global
	require_once("inc/fonctions.inc.php");
	require_once("inc/localvars.inc.php");
	
	//Definition des Variables Local
	$debug = isset($_GET["debug"])?$_GET["debug"]:false;
	$nohead = isset($_GET["nohead"])?$_GET["nohead"]:"";
	$site = isset($_GET["site"])?strtolower($_GET["site"]):"bordeaux";
	$promo = isset($_GET["promo"])?$_GET["promo"]:"";
	$page = isset($_GET["page"])?$_GET["page"]:"1";
	$date = isset($_GET["date"])?$_GET["date"]:date("dmY");
	$full = isset($_GET["full"])?$_GET["full"]:false;
	$numaff = isset($_GET["afficheur"])?$_GET["afficheur"]:1; 
	$current_color = "#FFFFFF";
	$previous_color = "";
	
	//Lecture des param�tres du Site
	$qparams = "SELECT * FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$site."' AND `afficheur`='".$numaff."';";
	$param_query = get_query($qparams);
	if($debug){
		echo $qparams;
	}	

	$params = Array();
	
	while($results = mysql_fetch_array($param_query)){
		$params[$results[2]] = $results[4];
	}
	
	if(!empty($params["salles"])){
		$params["salles"] = unserialize($params["salles"]);
	}
	
	if($debug){
		print_r($params);
	}
	
	if(date("G") >= $params["heure_limite"]){
		$date = date("dmY", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
	}
	
	//Lecture du fichier du site dans le tableau afficheur
	$afficheur = xmlreadfile($site,$date);
	
	if(empty($nohead)){
	?>
		<HTML>
		<HEAD>
		  <TITLE>Planning CESI : Centre de <?php echo ucfirst($site); ?></TITLE>
			<base href="http://soafficheur/" />
			<link href="inc/Style.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="inc/javascript.js"></script>
		</HEAD>
		<BODY OnLoad="javascript:Horloge();javascript:pageChange();javascript:refreshpage('/<?php echo $site; ?>/<?php echo $date; ?>/<?php echo $numaff; ?>/',180000);">
			<div class="conteneur">
				<div class="Zone2"></div>
				<div class="Zone3"><img align="left" src="img/HautGauche.png" border="0" hspace="0"><img src="img/HautDroit.png" align="right" hspace="0"></div>
				<div class="Zone4"><span class="horloge" id="Time"></span></div>
		<div class="frame" id="frame">
		<?php
	}
			//Calcul des Offsets d'affichage
			if(!$full){
				//x Salles par page soit $params["par_page"] r�servations
				$nb_pages = ceil(count($afficheur)/$params["par_page"]);
				$startoffset = ($page=="1")?1:$params["par_page"]*($page-1);
				$endoffset = "";
				
				if($nb_pages == 1){ 
					$endoffset = count($afficheur)+1; 
				}elseif($page == $nb_pages){
					$endoffset = count($afficheur)+1; 
				}else{
					$endoffset = $page*$params["par_page"]; 
				}

				$pquery = "SELECT * FROM ".$SqlVar["Tables"]["Publicite"]." WHERE `site`='".$site."' AND `debut` <= '".date("Y-m-d H:i:s")."' AND `fin` >= '".date("Y-m-d H:i:s")."' ORDER BY `nbaffichage` ASC LIMIT 0,1;";
				$pub = get_query($pquery);
				$nbpub = mysql_num_rows($pub);
				
				echo '<script type="text/javascript">';
				echo 'var pages=new Array();';
				for($z=0; $z < $nb_pages; $z++){
					echo 'pages['.($z).']="?page='.($z+1).'&nohead=ok&date='.$date.'&site='.$site.'&afficheur='.$numaff.'";';
				}
				if($nbpub > 0){
					$debutpub = explode(":",$params["debut_pub"]);
					if(date("h") >= $debupub[0] && date("i") >= $debupub[1]){
						echo 'pages['.($z).']="pub.php?site='.$site.'";';
					}
				}
				echo 'var i=0;';
				echo 'var time='.$params["time_change"].';'; // this is set in milliseconds

				echo 'function pageChange() {';
				echo ' ajaxpage(pages[i],"frame");';
				echo ' i++;';
				echo 'if(i==pages.length) {';
				echo ' i=0;';
				echo '}';
				echo ' setTimeout("pageChange()",time);';
				echo '}';
				echo '</script>';
			}else{
				$startoffset = 0;
				$endoffset = count($afficheur)+1;
				echo '<script type="text/javascript">';
				echo 'function pageChange() {';
				echo '}';
				echo '</script>';
			}
			//Debugage
			// echo "Page : ".$page." / ".$nb_pages;
			// echo "<a href='javascript:ajaxpage(\"?page=2&nohead=ok&date=".$date."\",\"frame\");'> Suivante </a>"
			// echo "Nb Pages : ".$nb_pages."<br>";
			// echo "Start Offset : ".$startoffset."<br>"; 
			// echo "End Offset : ".$endoffset."<br>"; 
			// echo "Date : ".format_date($date,"-")."<br>"; 
		?>
		<table width="100%">
				<tr>
					<td><h2>Planning des salles de <?php echo ucfirst($site); ?> du <?php echo format_date($date,"-"); ?></h2></td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" class="tb_planning" width="100%">
							<th>Sessions</th>
							<th>Salles</th>
							<th>Mati&egrave;res</th>
							<th>Intervenants</th>
							<th>P&eacute;riode</th>
								
						<?php
						for($y = $startoffset; $y < $endoffset; $y++){
							//D�finition des noms de colonne
								//Netoyage des valeurs
							$promo_nc = $afficheur[$y]["Session"];
							$promo = corres_promo($site,str_ireplace($site,"",$promo_nc));
							
							if(!empty($promo) && $afficheur[$y]["Groupe"] > 0 && $afficheur[$y]["Groupe"] < 10){
								$promo .= " Grp ".$afficheur[$y]["Groupe"];
							}
							
							if(strtolower(substr($promo,0,6)) === "cifdim"){
								continue;
							}
							
							$salle = corres_salles($site,$afficheur[$y]["Salle"]);
							$codesalle = $afficheur[$y]["CodeSalle"];
							$matiere = $afficheur[$y]["Matiere"];
							$intervenant = isset($afficheur[$y]["Intervenant"])?$afficheur[$y]["Intervenant"]:"";
							$debut = $afficheur[$y]["Debut"];
							$fin = $afficheur[$y]["Fin"];
							$periode = $debut."-".$fin; 

							if(!in_array($codesalle,$params["salles"])){
								continue;
							}
							
							//Effacement des donn�es redondantes (M�me promo, m�me salle)
							$i =1;
							foreach($afficheur as $current_reza){
								if($current_reza["Salle"] == $salle && $current_reza["Session"] == $promo_nc && $current_reza["Groupe"] == $afficheur[$y]["Groupe"]){
									$afficheur[$i]["Session"] = "";
									$afficheur[$i]["Salle"] = "";
								}
							$i++;
							}
							
							
							//Changement des couleurs suivant les noms des salles
							//Ajout du padding au d�but de la r�za
							$style = 'style="';
							if($salle <> @$afficheur[$y-1]["Salle"]){
								if($current_color == "#FFFFFF"){
									$current_color = $params["couleur"];
								}else{
									$current_color = "#FFFFFF";
								}
								$style .= 'border-top: 1px solid black; padding-top: 5px;';
							}
							
							//Ajout du padding � la fin de la r�za
							if($salle <> @$afficheur[$y+1]["Salle"]){
								$style .= 'padding-bottom: 5px;';
							}
							
							$style .= 'background-color:'.$current_color.';"';
							
						?>	
							<tr>
								<td <?php echo $style; ?>><span class="session"><?php echo $promo; ?>&nbsp;</span></td>
								<td <?php echo $style; ?>><span class="salles"><?php echo $salle; ?>&nbsp;</td>
								<td <?php echo $style; ?>><span class="matiere"><?php echo $matiere; ?>&nbsp;</td>
								<td <?php echo $style; ?>><span class="intervenant"><?php echo $intervenant; ?>&nbsp;</td>
								<td <?php echo $style; ?>><span class="periode"><?php echo $periode; ?>&nbsp;</td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td colspan="5" class="end">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<?php
		if(empty($nohead)){
		?>
		</div>
	</div>
</body>
</html>
<?php
}
?>

<pre>
<!--<?php
print_r($GLOBALS);
?>-->
</pre>
