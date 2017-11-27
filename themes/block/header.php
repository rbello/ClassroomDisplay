<!DOCTYPE html>
<html>
<head>
	<title>Afficheur Cesi</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="themes/block/style.css">
	<link rel="stylesheet" type="text/css" href="themes/block/materialize/css/materialize.min.css">


	<script type="text/javascript" src="themes/block/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="themes/block/javascript.js"></script>
	<script type="text/javascript" src="themes/block/monkeecreate-jquery.simpleWeather-0d95e82/jquery.simpleWeather.min.js"></script>

</head>
<body profile="<?php echo $_PROFILE['name']; ?>">
<main>
	<nav class="brown darken-2">
    <div class="nav-wrapper">
    	<div class="row">
	      <img src="themes/block/image/logo-groupeCesi.png" class="col s2" id="logo">
	      <div class="col s7 center"><h2>Bienvenue au Cesi <?php echo $_PROFILE['name']; ?></h2></div>
	      <div class="Zone4 col s3 center" style="margin-top: -0.5%;"><h2 id="horloge"><span class="horloge" id="Time"></span></h2><h4 id="date"></h4></div>
	      <!---->
      </div>
    </div>
  </nav>
  <script type="text/javascript">
  	var loc = "<?php echo $_PROFILE['name']; ?>";
	console.log(loc);
  </script>
