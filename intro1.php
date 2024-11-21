<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<h1>Intro PHP1</h1>

<form>
	
	<?php
	# codi PHP per mostrar els errors al browser
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	

	$nom_usuari = "manolo";

	echo "Introdueix el teu nom: <input type ='text'
	name='nom' value='$nom_usuari'/>";
?>

<button>Envia</button>
</form>


<?php 

	if( isset($_GET['nom']) )
	for ($i=1; $i < 10 ; $i++) { 
		echo "<br>$i) ".$_GET["nom"];
	}
?>


</body>
</html>