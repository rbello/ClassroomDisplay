<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Planning CESI</title>
	<link href="themes/classic/styles.css" rel="stylesheet" />
	<script type="text/javascript" src="themes/classic/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="themes/classic/javascript.js"></script>
</head>
<body profile="<?php echo $_PROFILE['name']; ?>">
	<div class="container">
		<div class="header">
			<img align="left" src="themes/classic/HautGauche.png" border="0" hspace="0">
			<img src="themes/classic/HautDroit.png" align="right" hspace="0">
		</div>
		<div class="Zone4"><span class="horloge" id="Time"></span></div>
		<div class="frame" id="frame">

			<table cellspacing="0" cellpadding="0" id="table-header" class="calendar" width="100%">
				<tr>
					<th>Sessions</th>
					<th>Salles</th>
					<th>Mati&egrave;res</th>
					<th>Intervenants</th>
					<th>P&eacute;riode</th>
				</tr>
			</table>
			<div id="viewport">
				<table cellspacing="0" cellpadding="0" id="table-body" class="calendar" width="100%">
				</table>
			</div>
		</div>
	</div>
	<div id="error"></div>
	<div id="loading"><img src="themes/classic/loading.gif" /></div>
</body>
</html>