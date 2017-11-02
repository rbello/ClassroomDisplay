<?php
session_start();

$a = isset($_GET["a"])?$_GET["a"]:"";
$currentsitename = "";

?>
<HTML>
		<HEAD>
		  <TITLE>Planning CESI : Zone d'administration</TITLE>
			<base href="http://soafficheur/" />
			<link href="inc/Style.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="inc/javascript.js"></script>
			<script language="javascript" src="calendar/calendar.js"></script>
			<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
			<div class="conteneur">
				<div class="Zone2"></div>
				<div class="Zone3"><img align="left" src="img/HautGauche.png" border="0" hspace="0"><img src="img/HautDroit.png" align="right" hspace="0"></div>
				<div class="Zone4"><span class="horloge" id="Time"></span></div>
				<div class="frame" id="frame">
<?php
//Inclusion des Fichiers de Configuration et Variables Global
require_once("inc/fonctions.inc.php");
require_once("inc/localvars.inc.php");
require_once('calendar/classes/tc_calendar.php');

$loguser = isset($_SESSION["userlog"])?$_SESSION["userlog"]:"";
$logpass = isset($_SESSION["userpass"])?$_SESSION["userpass"]:"";

$postusername = isset($_POST["username"])?$_POST["username"]:"";
$postpassword = isset($_POST["password"])?$_POST["password"]:"";
$username ="";

if(!empty($postusername)){
	$username = $postusername;
}elseif(!empty($loguser)){
	$username = $loguser;
}

$qlogin = "SELECT * FROM `".$SqlVar["Tables"]["Admins"]."` WHERE `username`='".$username."'";
$login_query = get_query($qlogin);
$results = mysql_fetch_array($login_query);

if(isset($results['id'])){ 
	$dbuser = $results['username']; 
	$dbpass = $results['password'];
	if(!empty($postusername) && !empty($postpassword)){
		if($dbuser == $postusername && $dbpass == md5($postpassword)){
			$loguser = $postusername;
			$_SESSION["userlog"] = $loguser;
			
			$logpass = md5($postpassword);
			$_SESSION["userpass"] = $logpass;
			
			$_SESSION["autorisation"] = $results['autorisation'];
			$_SESSION["droits"] = explode(",",$results['droits']);
			$_SESSION["userid"] = $results['id'];
		}
	}
}

if(empty($loguser)){
	include "inc/login.inc";
}elseif($loguser == $dbuser && $logpass == $dbpass){
?>
<table cellspacing="0" cellpadding="0" class="admintable" width="100%">
	<tr>
		<?php
			switch($a){
				default:
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "promo":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenuselected"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "salles":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "pub":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "addsite":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "users":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
				
				case "addafficheur":
				if(in_array("site",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php">Gestion de Sites</a></span></td>
					<?php
				}
				if(in_array("promo",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
				?>
				<td class="adminmenu"><span><a href="admin.php?a=promo">Nom des Promotions</a></span></td>
					<?php
				}
				if(in_array("salle",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=salles">Nom des Salles</a></span></td>
					<?php
				}
				if(in_array("pub",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=pub">Publicité</a></span></td>
					<?php
				}
				if(in_array("addsite",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=addsite">Ajouter un Site</a></span></td>
					<?php
				}
					if(in_array("afficheur",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenuselected"><span><a href="admin.php?a=addafficheur">Ajouter un Afficheur</a></span></td>
					<?php
				}
					if(in_array("users",$_SESSION["droits"]) or in_array("admin",$_SESSION["droits"])){
					?>
					<td class="adminmenu"><span><a href="admin.php?a=users">Utilisateurs</a></span></td>
					<?php
				}
				?>
				<td class="adminmenu"><span><a href="admin.php?a=deconnect">Deconnexion</a></span></td>
				<?php
				break;
			}
		?>
	</tr>
	<tr>
		<td colspan="8" class="admintbbody">
			<?php
				$msg = isset($_GET["msg"])?$_GET["msg"]:"";
				$error = isset($_GET["error"])?$_GET["error"]:false;
				
				if(!empty($msg)){
					if($error){ $class="msgerror"; }else{ $class="msginfo"; }
					?>
					<div class="<?php echo $class; ?>">
					<?php echo stripslashes(urldecode($msg)); ?>
					</div>
					<?php
				}
			?>
			<p><br /></p>
			<?php
			switch($a){
				default:
				?>
				<form method="post" action="admin.php?a=update">
				<table class="adminfont" width="90%">
					<tr>
						<td class="tbtitle"><label for="site">Site :</label></td>
						<td><select name="site" id="site" onChange="javascript:changePage(this.options[this.selectedIndex].value);">
							<?php
								$site = explode(",",$_SESSION["autorisation"]);
								$autorised_sites = " WHERE `id`=''";
								
								foreach($site as $key => $value){
									$autorised_sites .= " OR `id`='".$value."'";
								}
								
								$currentsite = isset($_GET["site"])?$_GET["site"]:$site[0];
								
								$qsite = "SELECT * FROM ".$SqlVar["Tables"]["Sites"].$autorised_sites;
								$site_query = get_query($qsite);
								
								while($results = mysql_fetch_array($site_query)){
									echo "<option value=\"".$results["id"]."\"";
									if($results["id"] == $currentsite){
										echo " selected";
									}
									echo ">".ucfirst($results["site"])."</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="nbafficheur">Afficheur N° :</label></td>
						<td>
							<select name="afficheur" id="afficheur" onChange="javascript:changeAfficheur(<?php echo $currentsite; ?>,this.options[this.selectedIndex].value);">
							<?php
								$aquery = "SELECT DISTINCT `afficheur` FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".site_name($currentsite)."' ";
								$afficheur_query = get_query($aquery);

								$currentafficheur = isset($_GET["afficheur"])?$_GET["afficheur"]:"1";
								
								while($afficheurresults = mysql_fetch_array($afficheur_query)){
									echo "<option value=\"".$afficheurresults["afficheur"]."\"";
									
									if($afficheurresults["afficheur"] === $currentafficheur){
											echo " selected";
									}
									
									echo ">".$afficheurresults["afficheur"]."</option>";
								}
								
								$qparams = "SELECT sites.id,sites.site,params.id,params.site,params.params,params.afficheur,params.text FROM ".$SqlVar["Tables"]["Parametres"].",".$SqlVar["Tables"]["Sites"]." WHERE sites.id='".$currentsite."' AND ".$SqlVar["Tables"]["Parametres"].".site=".$SqlVar["Tables"]["Sites"].".site AND params.afficheur='".$currentafficheur."'";
								$params_query = get_query($qparams);
								
								$params = Array();
								while($results = mysql_fetch_array($params_query)){
									$params[$results["params"]] = $results["text"];
								}
								
								if(!empty($params["salles"])){
									$params["salles"] = unserialize($params["salles"]);
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="codesite">Code Site FNG :</label></td>
						<td><input type="text" value="<?php echo $params["codesite"]; ?>" name="codesite" id="codesite" size="1" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="perpage">Réservation par page :</label></td>
						<td><input type="text" value="<?php echo $params["par_page"]; ?>" name="perpage" id="perpage" size="2" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="color">Couleur 1 ligne sur 2 :</label></td>
						<td><input type="text" value="<?php echo $params["couleur"]; ?>" name="color" id="color" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="time">Temps entre les rotations :</label></td>
						<td><input type="text" value="<?php echo $params["time_change"]; ?>" name="time" id="time" size="5" /> ms</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="heurelimite">Heure de basculement au jour suivant :</label></td>
						<td><input type="text" value="<?php echo $params["heure_limite"]; ?>" name="heurelimite" id="heurelimite" size="2" /> h</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="debut_pub">Heure de début des pub :</label></td>
						<?php
							$heure = explode(":",$params["debut_pub"]);
						?>
						<td><input type="text" value="<?php echo $heure[0]; ?>" name="debuth" id="debut_pub" size="2" /> : <input type="text" value="<?php echo $heure[1]; ?>" name="debutm" size="2" /></td>
					</tr>
					<tr>
						<td class="tbtitle">Salles à afficher :</td>
						<td>
						<?php
							$qsalles = "SELECT * FROM ".$SqlVar["Tables"]["Salles"]." WHERE `codesite`='".site_id(site_name($currentsite))."' ORDER BY `nomsalle` ASC;";
							$sallesres = get_query($qsalles);
							
							while($salresults = mysql_fetch_array($sallesres)){
								echo "<input type=\"checkbox\" value=\"".$salresults["codesalle"]."\" name=\"salles[]\" ";
								if(!empty($params["salles"])){
									if(in_array($salresults["codesalle"],$params["salles"])){
										echo "checked ";
									}
								}
								echo "/>".$salresults["nomsalle"]."<br />";
							}	
						?>
						</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="generate">Génération du fichier :</label></td>
						<td><input type="checkbox" name="generate" id="generate" value="1" <?php if($params["generer"]=="1"){ echo "checked"; }?>/></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Mettre à jour" /></td>
					</tr>
				</table>
				</form>
				<?php
				break;
				
				case "update":
					$nomsite = isset($_POST["site"])?$_POST["site"]:"";
					$afficheur = isset($_POST["afficheur"])?$_POST["afficheur"]:"";
					$codesite = isset($_POST["codesite"])?$_POST["codesite"]:"";
					$perpage = isset($_POST["perpage"])?$_POST["perpage"]:"";
					$color = isset($_POST["color"])?$_POST["color"]:"";
					$time = isset($_POST["time"])?$_POST["time"]:"";
					$heurelimite = isset($_POST["heurelimite"])?$_POST["heurelimite"]:"";
					$generate = isset($_POST["generate"])?$_POST["generate"]:"";
					$salles = isset($_POST["salles"])?serialize($_POST["salles"]):"";
					$heureh = isset($_POST["debuth"])?$_POST["debuth"]:"";
					$heurem = isset($_POST["debutm"])?$_POST["debutm"]:"";
					
					$heure = $heureh.":".$heurem;
					
					$sitequery = "SELECT * FROM `".$SqlVar["Tables"]["Sites"]."` WHERE `id`='".$nomsite."'";
					$query = get_query($sitequery);
					$results = mysql_fetch_array($query);
					$nomsite = $results["site"];
					
					if(!empty($nomsite) && !empty($codesite) && !empty($perpage) && !empty($color) && !empty($time) && !empty($heurelimite)){
						$cquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$codesite."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='codesite'";
						$ppquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$perpage."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='par_page'";
						$colquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$color."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='couleur'";
						$tquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$time."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='time_change'";
						$hquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$heurelimite."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='heure_limite'";
						$gquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$generate."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='generer'";
						$squery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$salles."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='salles'";
						$xquery = "UPDATE ".$SqlVar["Tables"]["Parametres"]." SET `text`='".$heure."' WHERE `site`='".$nomsite."' AND `afficheur`='".$afficheur."' AND `params`='debut_pub'";
						
						get_query($cquery);
						get_query($ppquery);
						get_query($colquery);
						get_query($tquery);
						get_query($hquery);
						get_query($gquery);
						get_query($squery);
						get_query($xquery);
						// echo $squery;
						redirect("admin.php","Mise à jour effectuée");
					}
				break;
				
				case "promo":
				?>
				<form method="post" action="admin.php?a=updatepromo">
				<table class="adminfont" width="100%">
					<tr>
						<td colspan="3" style="text-align: center; border-bottom: 1px solid black; padding-bottom: 15px;"><label for="site">Site :</label> <select name="site" id="site" onChange="javascript:PromoChangeSite(this.options[this.selectedIndex].value);">
							<?php
								$site = explode(",",$_SESSION["autorisation"]);
								$autorised_sites = " WHERE `id`=''";
								
								foreach($site as $key => $value){
									$autorised_sites .= " OR `id`='".$value."'";
								}
								
								$currentsite = isset($_GET["site"])?$_GET["site"]:$site[0];
								
								$qsite = "SELECT * FROM ".$SqlVar["Tables"]["Sites"].$autorised_sites;
								$site_query = get_query($qsite);
								
								while($results = mysql_fetch_array($site_query)){
									echo "<option value=\"".$results["id"]."\"";
									if($results["id"] == $currentsite){
										echo " selected";
									}
									echo ">".ucfirst($results["site"])."</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<?php
					$afficheur = xmlreadfile(site_name($currentsite),date("dmY"));
					$promo = Array();
					
					for( $y = 0; $y < count($afficheur); $y++ ){
						if(!in_array($afficheur[$y]["Session"],$promo)){
							$promo[] = $afficheur[$y]["Session"];
						}
					}
					
					foreach( $promo as $value ){
						if(!empty($value)){
							$value = trim(str_ireplace(site_name($currentsite),"",$value));
							echo "<tr>\n";
							echo "	<td>".$value."<td>\n";
							echo "	<td><input type=\"text\" size=\"50\" name=\"".$value."\" value=\"".corres_promo(site_name($currentsite), $value)."\" /></td>\n";
							echo "</tr>\n";
						}
					}
				?>
					<tr>
						<td colspan="3" style="text-align:center; padding-top: 15px; border-top: 1px solid black;">
							<input type="hidden" name="site" value="<?php echo site_name($currentsite); ?>" />
							<input type="submit" name="submit" value="Mettre à jour" />
						</td>
					</tr>
				</table>
				</form>
				<?php
				break;
				
				case "updatepromo":
					if(isset($_POST["submit"])){
						if(!empty($_POST["submit"]) && !empty($_POST["site"])){
							$msg = "";
							foreach( $_POST as $key => $value ){
								$key = stripslashes(str_ireplace("_"," ",$key));
								if( $key <> "submit" && $key <> "site" ){
									if( $key <> $value ){
										if(updatepromo($_POST["site"], $key, $value)){
											$msg .= "Mise à jour de ".$key." vers ".$value."<br >";
										}
									}
								}
							}
							redirect("admin.php?a=promo",$msg);
						}
					}
				break;

				case "salles":
				?>
				<form method="post" action="admin.php?a=updatesalles">
				<table class="adminfont" width="100%">
					<tr>
						<td colspan="3" style="text-align: center; border-bottom: 1px solid black; padding-bottom: 15px;"><label for="site">Site :</label> <select name="site" id="site" onChange="javascript:SallesChangeSite(this.options[this.selectedIndex].value);">
							<?php
								$site = explode(",",$_SESSION["autorisation"]);
								$autorised_sites = " WHERE `id`=''";
								
								foreach($site as $key => $value){
									$autorised_sites .= " OR `id`='".$value."'";
								}
								
								$currentsite = isset($_GET["site"])?$_GET["site"]:$site[0];
								
								$qsite = "SELECT * FROM ".$SqlVar["Tables"]["Sites"].$autorised_sites;
								$site_query = get_query($qsite);
								
								while($results = mysql_fetch_array($site_query)){
									echo "<option value=\"".$results["id"]."\"";
									if($results["id"] == $currentsite){
										echo " selected";
									}
									echo ">".ucfirst($results["site"])."</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<?php
					$qsalles = "SELECT * FROM ".$SqlVar["Tables"]["Salles"]." WHERE `codesite`='".site_id(site_name($currentsite))."' ORDER BY `nomsalle` ASC;";
					$sallesres = get_query($qsalles);
					
					while($results = mysql_fetch_array($sallesres)){
						echo "<tr>\n";
						echo "	<td>".$results["nomsalle"]."<td>\n";
						echo "	<td><input type=\"text\" size=\"50\" name=\"".$results["nomsalle"]."\" value=\"".corres_salles(site_name($currentsite), $results["nomsalle"])."\" /></td>\n";
						echo "</tr>\n";
					}	
					?>
					<tr>
						<td colspan="3" style="text-align:center; padding-top: 15px; border-top: 1px solid black;">
							<input type="hidden" name="site" value="<?php echo site_name($currentsite); ?>" />
							<input type="submit" name="submit" value="Mettre à jour" />
						</td>
					</tr>
				</table>
				</form>
				<?php
				break;
				
				case "updatesalles":
					if(isset($_POST["submit"])){
						if(!empty($_POST["submit"]) && !empty($_POST["site"])){
							$msg = "";
							foreach( $_POST as $key => $value ){
								$key = stripslashes(str_ireplace("_"," ",$key));
								if( $key <> "submit" && $key <> "site" ){
									if( $key <> $value ){
										if(updatesalles($_POST["site"], $key, $value)){
											$msg .= "Mise à jour de ".$key." vers ".$value."<br >";
										}
									}
								}
							}
							redirect("admin.php?a=salles",$msg);
						}
					}
				break;
				
				case "pub":
				?>
				<form name="newad" action="admin.php?a=addpub" method="post" enctype="multipart/form-data">
				<table class="adminfont" width="100%">
					<tr>
						<td colspan="3" style="text-align: center; border-bottom: 1px solid black; padding-bottom: 15px;"><label for="site">Site :</label> <select name="site" id="site" onChange="javascript:PubChangeSite(this.options[this.selectedIndex].value);">
							<?php
								$site = explode(",",$_SESSION["autorisation"]);
								$autorised_sites = " WHERE `id`=''";
								
								foreach($site as $key => $value){
									$autorised_sites .= " OR `id`='".$value."'";
								}
								
								$currentsite = isset($_GET["site"])?$_GET["site"]:$site[0];
								
								$qsite = "SELECT * FROM ".$SqlVar["Tables"]["Sites"].$autorised_sites;
								$site_query = get_query($qsite);
								
								while($results = mysql_fetch_array($site_query)){
									echo "<option value=\"".$results["id"]."\"";
									if($results["id"] == $currentsite){
										echo " selected";
									}
									echo ">".ucfirst($results["site"])."</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<?php
					$pquery = "SELECT * FROM ".$SqlVar["Tables"]["Publicite"]." WHERE `site`='".site_name($currentsite)."';";
					$pubres = get_query($pquery);
					?>
					<tr>
						<td colspan="3">
							<table class="tbpub" cellspacing="0">
								<?php
								echo "<tr>\n";
								echo "	<th>Nom de la publicité</td>\n";
								echo "	<th>Début</td>\n";
								echo "	<th>Fin</td>\n";
								echo "	<th>Auteur</td>\n";
								echo "	<th>&nbsp;</td>\n";
								echo "</tr>\n";
								
								$style="1";
								while($results = mysql_fetch_array($pubres)){
									echo "<tr class=\"d".$style."\">\n";
									echo "	<td><a href=\"".$results["srcpub"]."\" target=\"_blank\">".$results["nompub"]."</a></td>\n";
									echo "	<td>".$results["debut"]."</td>\n";
									echo "	<td>".$results["fin"]."</td>\n";
									echo "	<td>".username($results["auteurid"])."</td>\n";
									echo "	<td>\n";
									echo "		<a href=\"admin.php?a=delpub&id=".$results["id"]."\"><img src=\"img/b_drop.png\" border=\"0\" /></a>\n";
									echo "	</td>\n";
									echo "</tr>\n";
									$style = "2";
								}
								?>
							</table>
							<h3>Ajouter une publicité</h3>
							<table class="tbaddpub">
								<tr>
									<td class="tbaddpubhead">Nom de la publicité :</td>
									<td><input type="text" name="nompub" id="nompub" size="50" /></td>
								</tr>
								<tr>
									<td class="tbaddpubhead">Image de la publicité :</td>
									<td><input type="file" name="srcpub" id="srcpub" size="50" /></td>
								</tr>
								<tr>
									<td class="tbaddpubhead">Date de Début d'affichage :</td>
									<td>
									<?php
										$myCalendar = new tc_calendar("datedebut");	  
										$myCalendar->setIcon("calendar/images/iconCalendar.gif");	  
										$myCalendar->setDate(date('d'), date('m'), date('Y'));
										$myCalendar->setPath("calendar/");	  
										$myCalendar->setYearInterval(2010, 2020);	  
										$myCalendar->startMonday(true);	  
										$myCalendar->disabledDay("Sat");	  
										$myCalendar->disabledDay("Sun");
										$myCalendar->writeScript();	  	  
 
									?>
									</td>
								</tr>
								<tr>
									<td class="tbaddpubhead">Date de Fin d'affichage :</td>
									<td>
									<?php						  
										$myCalendar = new tc_calendar("datefin");	  
										$myCalendar->setIcon("calendar/images/iconCalendar.gif");	  
										$myCalendar->setDate(date('d')+7, date('m'), date('Y'));
										$myCalendar->setPath("calendar/");	  
										$myCalendar->setYearInterval(2010, 2020);	  
										$myCalendar->startMonday(true);	  
										$myCalendar->disabledDay("Sat");	  
										$myCalendar->disabledDay("Sun");
										$myCalendar->writeScript();	  	  
 
									?>
									</td>
								</tr>
								<tr><td colspan="2"><input type="submit" name="Ajouter" value="Ajouter" /></td></tr>
							</table>
							</form>
						</td>
					</tr>
					<?php
				break;
				
				case "addpub":
					$site = isset($_POST["site"])?$_POST["site"]:"";
					$nompub = isset($_POST["nompub"])?$_POST["nompub"]:"";
					$debut = isset($_POST["datedebut"])?$_POST["datedebut"]:"";
					$fin = isset($_POST["datefin"])?$_POST["datefin"]:"";
					$srcpub="";
					
					$tquery = "SELECT `nbaffichage` FROM ".$SqlVar["Tables"]["Publicite"]." ORDER BY `nbaffichage` DESC LIMIT 0,1;";
					$topsql = get_query($tquery);
					$topaff = mysql_fetch_array($topsql);
					
					//  5MB maximum file size 
					$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
					//  Valid file extensions (images, word, excel, powerpoint) 
					$rEFileTypes = 
					  "/^\.(jpg|jpeg|gif|png){1}$/i"; 
					$dir_base = "pub/".date("U")."_"; 

					$isFile = is_uploaded_file($_FILES['srcpub']['tmp_name']); 
					if ($isFile){    //  do we have a file? 
						//  sanatize file name 
						//     - remove extra spaces/convert to _, 
						//     - remove non 0-9a-Z._- characters, 
						//     - remove leading/trailing spaces 
						//  check if under 5MB, 
						//  check file extension for legal file types 
						
						$safe_filename = preg_replace(
										 array("/\s+/", "/[^-\.\w]+/"), 
										 array("_", ""), 
										 trim($_FILES['srcpub']['name'])); 
										 
						if ($_FILES['srcpub']['size'] <= $MAXIMUM_FILESIZE && 
							preg_match($rEFileTypes, strrchr($safe_filename, '.'))){
							
							$isMove = move_uploaded_file ( 
									 $_FILES['srcpub']['tmp_name'], 
									 $dir_base.$safe_filename);
							
							if($isMove){
								$srcpub = $dir_base.$safe_filename;
							}
						}else{
								redirect("admin.php?a=pub","Le fichier ne répond pas aux exigences du CDC.",true);
						} 
					} 
					
					if(!empty($nompub) && !empty($debut) && !empty($fin) && !empty($srcpub)){
						$pquery = "INSERT INTO ".$SqlVar["Tables"]["Publicite"]." VALUES('','".site_name($site)."','".$nompub."','".$srcpub."','".$debut."','".$fin."','".$topaff["nbaffichage"]."','".$_SESSION["userid"]."');";
						get_query($pquery);
						
						redirect("admin.php?a=pub","La publicité \"".$nompub."\" vient d'être ajouté à la base.");
					}
				break;
				
				case "delpub":
					$pubid = isset($_GET["id"])?$_GET["id"]:"";
					$ok = isset($_GET["ok"])?$_GET["ok"]:"";
					
					if(!empty($pubid)){
						if(!empty($ok)){
							$dquery = "DELETE FROM ".$SqlVar["Tables"]["Publicite"]." WHERE `id`='".$pubid."';";
							get_query($dquery);

							redirect("admin.php?a=pub","La publicité id : ".$pubid." a été supprimé");
						}else{
							confirm("Êtes vous sur de vouloir supprimer la publicité id : ".$pubid."","admin.php?a=delpub&id=".$pubid."&ok=yes","admin.php?a=pub");
						}
					}
				break;
				
				case "addsite":
				?>
				<form method="post" action="admin.php?a=add">
				<table class="adminfont" width="90%">
					<tr>
						<td class="tbtitle"><label for="site">Site :</label></td>
						<td><input type="text" value="" name="nomsite" id="nomsite" size="20" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="codesite">Code Site FNG :</label></td>
						<td><input type="text" value="" name="codesite" id="codesite" size="1" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="perpage">Réservation par page :</label></td>
						<td><input type="text" value="" name="perpage" id="perpage" size="2" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="color">Couleur 1 ligne sur 2 :</label></td>
						<td><input type="text" value="" name="color" id="color" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="time">Temps entre les rotations :</label></td>
						<td><input type="text" value="" name="time" id="time" size="5" /> ms</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="heurelimite">Heure de basculement au jour suivant :</label></td>
						<td><input type="text" value="" name="heurelimite" id="heurelimite" size="2" /> h</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Ajouter" /></td>
					</tr>
				</table>
				</form>
				<?php
				break;
				
				case "addafficheur":
				?>
				<form method="post" action="admin.php?a=goafficheur">
				<table class="adminfont" width="100%">
					<tr>
						<td colspan="2" style="text-align: center; border-bottom: 1px solid black; padding-bottom: 15px;"><label for="site">Site :</label> <select name="site" id="site" onChange="javascript:AfficheurChangeSite(this.options[this.selectedIndex].value);">
							<?php
								$site = explode(",",$_SESSION["autorisation"]);
								$autorised_sites = " WHERE `id`=''";
								
								foreach($site as $key => $value){
									$autorised_sites .= " OR `id`='".$value."'";
								}
								
								$currentsite = isset($_GET["site"])?$_GET["site"]:$site[0];
								
								$qsite = "SELECT * FROM ".$SqlVar["Tables"]["Sites"].$autorised_sites;
								$site_query = get_query($qsite);
								
								while($results = mysql_fetch_array($site_query)){
									echo "<option value=\"".$results["id"]."\"";
									if($results["id"] == $currentsite){
										echo " selected";
										$currentsitename = $results["site"];
									}
									echo ">".ucfirst($results["site"])."</option>";
								}
								
								$qafficheur = "SELECT DISTINCT `afficheur` FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$currentsitename."' ORDER BY `afficheur` DESC LIMIT 0,1";
								$afficheur_query = get_query($qafficheur);
								$affres = mysql_fetch_array($afficheur_query);

								$qcodesite = "SELECT `site`,`params`,`text` FROM ".$SqlVar["Tables"]["Parametres"]." WHERE `site`='".$currentsitename."' AND `params`='codesite' LIMIT 0,1;";
								$codesite_query = get_query($qcodesite);
								$codres = mysql_fetch_array($codesite_query);
								
								echo $qcodesite;
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;" width="50%">N° Afficheur :</td>
						<td><input type="text" name="affnum" id="affnum" value="<?php echo $affres["afficheur"]+1; ?>" size="1" readonly /></td>
					</tr>
					<tr>
						<td style="text-align: right;" width="50%">Code Site FNG :</td>
						<td><input type="text" name="codesite" id="codesite" value="<?php echo $codres["text"]; ?>" size="1" readonly /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="perpage">Réservation par page :</label></td>
						<td><input type="text" value="" name="perpage" id="perpage" size="2" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="color">Couleur 1 ligne sur 2 :</label></td>
						<td><input type="text" value="" name="color" id="color" /></td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="time">Temps entre les rotations :</label></td>
						<td><input type="text" value="" name="time" id="time" size="5" /> ms</td>
					</tr>
					<tr>
						<td class="tbtitle"><label for="heurelimite">Heure de basculement au jour suivant :</label></td>
						<td><input type="text" value="" name="heurelimite" id="heurelimite" size="2" /> h</td>
					</tr>
					<tr>
						<td class="tbtitle">Salles à afficher :</td>
						<td>
						<?php 
							$qsalles = "SELECT * FROM ".$SqlVar["Tables"]["Salles"]." WHERE `codesite`='".$codres["text"]."' ORDER BY `nomsalle` ASC;";
							$sallesres = get_query($qsalles);
							
							while($results = mysql_fetch_array($sallesres)){
								echo "<input type=\"checkbox\" value=\"".$results["codesalle"]."\" name=\"salles[]\" checked />".$results["nomsalle"]."<br />";
							}							
						?>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Ajouter" /></td>
					</tr>
				</table>
				</form>
				<?php
				break;
				
				case "goafficheur":
					$nomsite = isset($_POST["site"])?site_name($_POST["site"]):"";
					$afficheur = isset($_POST["affnum"])?$_POST["affnum"]:"";
					$perpage = isset($_POST["perpage"])?$_POST["perpage"]:"";
					$codesite = isset($_POST["codesite"])?$_POST["codesite"]:"";
					$coulour = isset($_POST["color"])?$_POST["color"]:"";
					$time = isset($_POST["time"])?$_POST["time"]:"";
					$heure = isset($_POST["heurelimite"])?$_POST["heurelimite"]:"";
					$salles = isset($_POST["salles"])?serialize($_POST["salles"]):"";
					
					$pquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','par_page','".$afficheur."','".$perpage."')";
					$cquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','codesite','".$afficheur."','".$codesite."')";
					$colquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','couleur','".$afficheur."','".$coulour."')";
					$tquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','time_change','".$afficheur."','".$time."')";
					$hquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','heure_limite','".$afficheur."','".$heure."')";
					$gquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','generer','".$afficheur."','0')";
					$squery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','salles','".$afficheur."','".$salles."')";
					
					get_query($pquery);
					get_query($cquery);
					get_query($colquery);
					get_query($tquery);
					get_query($hquery);
					get_query($gquery);
					get_query($squery);
					
					echo "Afficheur ajouté";
				break;
				
				case "users":
					$uquery = "SELECT * FROM `".$SqlVar["Tables"]["Admins"]."`;";
					$usql = get_query($uquery);
					?>
					<p>
					<a href="admin.php?a=adduser">Ajouter un utilisateur</a>
					</p>
						<table class="tbusers" cellspacing="0">
							<th>Username</th>
							<th>Sites autorisés</th>
							<th>Droits</th>
							<th>&nbsp;</th>
					<?php
					while($results = mysql_fetch_array($usql)){
					?>
						<tr>
							<td><?php echo $results["username"]; ?></td>
							<td>
							<?php
								$sites = explode(",",$results["autorisation"]);
								foreach($sites as $site){
									if(!empty($site)){
										echo ucfirst(site_name($site))."<br />";
									}
								}
							?>
							</td>
							<td>
							<?php
								$droits = explode(',',$results["droits"]);
								if(!empty($droits)){
									foreach($droits as $right){
										echo ucfirst($right)."<br />";
									}
								}
							?>
							</td>
							<td>
								<a href="admin.php?a=deluser&id=<?php echo $results["id"]; ?>"><img src="img/b_drop.png" border="0" /></a>
								<a href="admin.php?a=edituser&id=<?php echo $results["id"]; ?>"><img src="img/b_edit.png" border="0" /></a>
							</td>
						</tr>
					<?php
					}
				break;
				
				case "edituser":
					$userid = isset($_GET["id"])?$_GET["id"]:"";
					
					if(!empty($userid)){
						$uquery = "SELECT * FROM `".$SqlVar["Tables"]["Admins"]."` WHERE `id`='".$userid."';";
						$usql = get_query($uquery);
						
						$userinfo = mysql_fetch_array($usql);
						$autorisations = explode(",",$userinfo["autorisation"]);
						$droits = explode(",",$userinfo["droits"]);
						?>
						<form action="admin.php?a=saveuser" method="post" onsubmit="return checkForm2(this)">
						<input type="hidden" name="userid" value="<?php echo $userid; ?>" id="userid" />
						<table class="tbedituser">
							<tr>
								<td>Username :</td>
								<td><input type="text" name="user" id="user" value="<?php echo $userinfo["username"]; ?>" /></td>
							</tr>
							<tr>
								<td>Password :</td>
								<td><input type="password" name="pass1" id="pass1" value="" /></td>
							</tr>
							<tr>
								<td>Confirmer Password :</td>
								<td><input type="password" name="pass2" id="pass2" value="" /></td>
							</tr>
							<tr>
								<td>Autorisations :</td>
								<td>
								<?php
								$aquery = "SELECT * FROM `".$SqlVar["Tables"]["Sites"]."`";
								$asql = get_query($aquery);
								
								while($results = mysql_fetch_array($asql)){
									echo "<input type=\"checkbox\" name=\"autorisation[]\" value=\"".$results["id"]."\" ";
									if(in_array($results["id"],$autorisations)){
										echo "checked";
									}
									echo " /> ".ucfirst($results["site"])."<br />";
								}
								?>
								</td>
								<td>Droits :</td>
								<td>
								<input type="checkbox" name="droits[]" value="site" <?php if(in_array("site",$droits)) echo "checked"; ?> />Gestion de Sites<br />
								<input type="checkbox" name="droits[]" value="promo" <?php if(in_array("promo",$droits)) echo "checked"; ?> />Noms des Promotions<br />
								<input type="checkbox" name="droits[]" value="salle" <?php if(in_array("salle",$droits)) echo "checked"; ?> />Nom des Salles<br />
								<input type="checkbox" name="droits[]" value="pub" <?php if(in_array("pub",$droits)) echo "checked"; ?> />Publicité<br />
								<input type="checkbox" name="droits[]" value="addsite" <?php if(in_array("addsite",$droits)) echo "checked"; ?> />Ajouter un Site<br />
								<input type="checkbox" name="droits[]" value="afficheur" <?php if(in_array("afficheur",$droits)) echo "checked"; ?> />Ajouter un Afficheur<br />
								<input type="checkbox" name="droits[]" value="users" <?php if(in_array("users",$droits)) echo "checked"; ?> />Utilisateurs<br />
								</td>
							</tr>
							<tr><td colspan="2"><input type="submit" value="Mettre à jour" /></td></tr>
						</table>
						</form>
						<?php
					}
				break;
				
				case "saveuser":
					$userid = isset($_POST["userid"])?$_POST["userid"]:"";
					$username = strtolower(isset($_POST["user"])?$_POST["user"]:"");
					$password = !empty($_POST["pass1"])?md5($_POST["pass1"]):"";
					$autorisations = isset($_POST["autorisation"])?implode(",",$_POST["autorisation"]):"";
					$droits = isset($_POST["droits"])?implode(",",$_POST["droits"]):"";
					if(!empty($userid)){
						$nquery = "UPDATE `".$SqlVar["Tables"]["Admins"]."` SET `username`='".$username."' WHERE `id`='".$userid."';";
						$aquery = "UPDATE `".$SqlVar["Tables"]["Admins"]."` SET `autorisation`='".$autorisations."' WHERE `id`='".$userid."';";
						$dquery = "UPDATE `".$SqlVar["Tables"]["Admins"]."` SET `droits`='".$droits."' WHERE `id`='".$userid."';";
						
						get_query($nquery);
						get_query($aquery);
						get_query($dquery);
						
						if(!empty($password)){
							$pquery = "UPDATE `".$SqlVar["Tables"]["Admins"]."` SET `password`='".$password."' WHERE `id`='".$userid."';";
							get_query($pquery);
						}
						$msg="L'utilisateur ".$username." vient d'être modifié";
						redirect("admin.php?a=users",$msg);
					}
						
				break;
				
				case "adduser":
					?>
					<form action="admin.php?a=createuser" method="post" onsubmit="return checkForm(this)">
						<table class="tbedituser">
								<tr>
									<td>Username :</td>
									<td><input type="text" name="newuser" id="newuser" value="" /></td>
								</tr>
								<tr>
									<td>Password :</td>
									<td><input type="password" name="pwd1" id="pwd1" value="" /></td>
								</tr>
								<tr>
									<td>Confirmer Password :</td>
									<td><input type="password" name="pwd2" id="pwd2" value="" /></td>
								</tr>
								<tr>
									<td>Autorisations :</td>
									<td>
									<?php
									$aquery = "SELECT * FROM `".$SqlVar["Tables"]["Sites"]."`";
									$asql = get_query($aquery);
									
									while($results = mysql_fetch_array($asql)){
										echo "<input type=\"checkbox\" name=\"autorisation[]\" value=\"".$results["id"]."\" ";
										echo " /> ".ucfirst($results["site"])."<br />";
									}
									?>
									</td>
									<td>Droits :</td>
									<td>
									<input type="checkbox" name="droits[]" value="site" />Gestion de Sites<br />
									<input type="checkbox" name="droits[]" value="promo" />Noms des Promotions<br />
									<input type="checkbox" name="droits[]" value="salle" />Nom des Salles<br />
									<input type="checkbox" name="droits[]" value="pub" />Publicité<br />
									<input type="checkbox" name="droits[]" value="addsite" />Ajouter un Site<br />
									<input type="checkbox" name="droits[]" value="afficheur" />Ajouter un Afficheur<br />
									<input type="checkbox" name="droits[]" value="users" />Utilisateurs<br />
									</td>
								</tr>
								<tr><td colspan="2"><input type="submit" value="Créer l'utilisateur" /></td></tr>
							</table>
						</form>
						<?php
				break;
				
				case "createuser":
					$username = strtolower(isset($_POST["newuser"])?$_POST["newuser"]:"");
					$password = isset($_POST["pwd1"])?md5($_POST["pwd1"]):"";
					$autorisations = isset($_POST["autorisation"])?implode(",",$_POST["autorisation"]):"";
					$droits = isset($_POST["droits"])?implode(",",$_POST["droits"]):"";
					
					if(!empty($username) && !empty($password) && !empty($autorisations) && !empty($droits)){
						$query = "INSERT INTO `".$SqlVar["Tables"]["Admins"]."` VALUES('','".$username."','".$password."','".$autorisations."','".$droits."');";
						get_query($query);
						
						$msg="L'utilisateur ".$username." vient d'être créé";
						redirect("admin.php?a=users",$msg);
					}
				break;
				
				case "deconnect":
					$_SESSION["userlog"] = "";
					$_SESSION["userpass"] = "";
					$_SESSION["autorisation"] = "";
					include "inc/login.inc";
				break;
				
				case "add":
					$nomsite = strtolower(isset($_POST["nomsite"])?$_POST["nomsite"]:"");
					$codesite = isset($_POST["codesite"])?$_POST["codesite"]:"";
					$perpage = isset($_POST["perpage"])?$_POST["perpage"]:"";
					$color = isset($_POST["color"])?$_POST["color"]:"";
					$time = isset($_POST["time"])?$_POST["time"]:"";
					$heurelimite = isset($_POST["heurelimite"])?$_POST["heurelimite"]:"";
					
					if(!empty($nomsite) && !empty($codesite) && !empty($perpage) && !empty($color) && !empty($time) && !empty($heurelimite)){
						$ppquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','par_page','1','".$perpage."')";
						$cquery  = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','codesite','1','".$codesite."')";
						$colquery  = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','couleur','1','".$color."')";
						$tquery  = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','time_change','1','".$time."')";
						$hquery  = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','heure_limite','1','".$heurelimite."')";
						$squery = "INSERT INTO ".$SqlVar["Tables"]["Sites"]." VALUES('','".$nomsite."')";
						$pubquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','debut_pub','1','09:30')";
						$gquery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','generer','1','0')";
						$sallequery = "INSERT INTO ".$SqlVar["Tables"]["Parametres"]." VALUES('','".$nomsite."','salles','1','')";
						
						get_query($ppquery);
						get_query($cquery);
						get_query($colquery);
						get_query($tquery);
						get_query($hquery);
						get_query($squery);
						get_query($pubquery);
						get_query($gquery);
						get_query($sallequery);
						
						$sitequery = "SELECT * FROM `".$SqlVar["Tables"]["Sites"]."` WHERE `site`='".$nomsite."'";
						$query = get_query($sitequery);
						$results = mysql_fetch_array($query);
						$siteid = $results["id"];

						//Ajouter les autorisations à l'utilisateur actuel pour le site
						$adquery = "UPDATE `".$SqlVar["Tables"]["Admins"]."` SET `autorisation`='".$_SESSION['autorisation'].",".$siteid."' WHERE `id`=".$_SESSION["userid"].";";
						get_query($adquery);
						
						echo "Le site ".$nomsite." a été créé.";
					}
				break;
			}
			?>
			<p><br /></p>
		</td>
	</td>
</table>
<?php
}
?>
<pre>
<!--<?php
print_r($GLOBALS);
?>-->
</pre>
				</div>
			</div>
		</BODY>
</HTML>