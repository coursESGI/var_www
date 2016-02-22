<form action="login.php" method="post">
	<input name="identifiant" type="text">
	<input name="mot_de_passe" type="password">
	<input type="submit">
</form>

<?php

if(isset($_POST["identifiant"]) && isset($_POST["mot_de_passe"]))
{
	if(!file_exists("dossier"))
		mkdir("dossier");
	$fichier = fopen("dossier/fichier.txt", "a");
	fputs($fichier, $_POST["identifiant"] . "\r\n");
	
	fclose($fichier);
	
}
