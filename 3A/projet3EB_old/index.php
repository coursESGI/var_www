<?php
	include "template/header.php";

    define("BDD_DRIVER", "mysql");
    define("BDD_HOST", "localhost");
    define("BDD_DBNAME", "projet3web");
    define("BDD_USER", "root");
    //define("BDD_PWD", "");
    require "private/functions.php";
?>

<?php
	require "user.class.php";
?>

<h1>Welcome</h1>

<?php if (isConnected()):?>
<a href="logout.php"> Se déconnecter </a>
<?php else:?>
<a href="subscribe.php">S'inscrire</a>
<a href="login.php">Se connecter</a>
<?php endif;?>

<?php
	/*$utilisateur = new user();
	
	$utilisateur->name = "nom";
	$utilisateur->surname = "prénom";
	$utilisateur->birthday = "14/02/1995";
	$utilisateur->country = "ville";
	$utilisateur->email = "email";
	$utilisateur->pwd = "mot de passe";
	$utilisateur->kind = "genre";
	$utilisateur->cgu = true;
	
	if($utilisateur->verify())
		$utilisateur->save();
	
	echo "<pre>";
	var_dump($utilisateur);
	echo "</pre>";*/
?>

<?php
	include "template/footer.php";
?>

<?php

/*for($i = 1; $i<= 2; $i++){
	$url = "https://www.leboncoin.fr/annonces/offres/ile_de_france/?o=" . $i;
	
	$timeout = 10;
	
	$ch = curl_init($url);
	
	curl_setopt ($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt ($ch, CURLOPT_TIMEOUT, true);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	
	if(preg_match('`^https://`i', $url)){
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	}
	
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	
	// récupération du contenu suivi par la requête
	
	$page_content = curl_exec($ch);
	
	curl_close($ch);
	$contenu = strip_tags($page_content, "<div>,<h2>"); // enlève toutes les balises html de $page_content sauf div et h2
	
	$results = [];
	preg_match_all('`<h2 class=\"title\">([^<]*)</h2>`', $contenu, $results);
	$liste_of_desc = $results[1];
	
	preg_match_all('`<div class=\"price\">([^<]*)</div>`', $contenu, $results);
	$liste_of_desc = $results[1];
	
	foreach($liste_of_desc as 
}
*/
