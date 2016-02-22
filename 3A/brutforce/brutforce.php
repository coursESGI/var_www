<?php
 
$start = microtime(true);
$chaine = "abcd";
 
$min = 2;
$max = 4;
$list_of_possibilities = [];
 
repeat();
 
function repeat($position=0, $character = ""){
 
    global $chaine, $list_of_possibilities,$min,$max;
 
    for ($i = 0; $i < strlen($chaine); $i++)
    {        
        if ($position  < $max - 1)
        {    
            repeat($position + 1, $character . $chaine[$i]);
        }
             
        if(strlen($character . $chaine[$i])>=$min)
        $list_of_possibilities[] = $character . $chaine[$i];    
    }
}
 
//sort($list_of_possibilities);
 
echo "<h1>".(microtime(true) - $start)."</h1>";
echo "Chaine : ".$chaine."<br>";
echo "min : ".$min." max : ".$max."<br>";
echo "<pre>";
print_r($list_of_possibilities);
/*
$url = "http://127.0.0.1/3A/login.php";

foreach($liste_of_possibilities as $possibility){
	$_POST["login" => "admin", "pwd" => $possibility];
	
// oseox tutoriel curl remplir et valider un formulaire 
	
	$url = 'http://www.oseox.fr';
$timeout = 10;

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

if (preg_match('`^https://`i', $url))
{
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
}

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Utilisation de la méthode POST
curl_setopt($ch, CURLOPT_POST, true);

// Définition des champs et valeurs à envoyer
curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);

$page_content = curl_exec($ch);

curl_close($ch);

if(!preg_match("/Identifiants incorrects/i", $page_content){
	echo "mot de passe" . $possibiliy;
	die();
}



}
*/
