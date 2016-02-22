<?php
session_start();
header("Content-type: image/png"); //type image

$longueur = 200; // longueur du cadre
$hauteur = 50; // largeur du cadre

$mots = ["mot a", "mot b", "mot c", "mot d"];
$polices = ["1.ttf", "2.ttf", "3.otf", "4.ttf"]; //extension des polices
$couleurs = ["0_0_0", "0_0_255", "255_0_0", "0_255_0"];

$font_size = 35;
$rand_polices = rand(0,count($polices) - 1);
$rand_mots = rand(0,count($mots) - 1);
$rand_couleurs = rand(0,count($couleurs) - 1);

$boite = imagettfbbox($font_size, 0, 'public/font/police' . $polices[$rand_polices] ,$mots[$rand_mots]); // police aléatoire

$l = $boite[2] - $boite[0];
$h = $boite[1] - $boite[7];
$marge = 10;

$image = imagecreate(200, 50); //taille image

$explode_couleur = explode("_", $couleurs[$rand_couleurs]); // récupère red_green_blue

$gris = imageColorallocate($image, 250, 250, 250); // couleur de fond
$noir = imageColorallocate($image, 0, 0, 0);
$couleur_rand = imageColorallocate($image, $explode_couleur[0], $explode_couleur[1], $explode_couleur[2]); // couleur aléatoire
// police aléatoire
imagettftext($image, $font_size, 0,$marge,$h+$marge, $couleur_rand, 'public/font/police' . $polices[$rand_polices], $mots[$rand_mots]);

//créer une chaîne de 4 caractères aléatoires
//afficher la chaîne dans l'image dans une police aléatoire : 4 polices sur dafont
//insérer au fond de l'image des figures géométriques
//stocker dans une variable la chaîne de caractères
//comparer avec ce qu'a saisi l'utilisateur


$rand20 = rand(20, 22);

imageline($image, $rand20,$rand20/2,$rand20/2,$rand20*2,$couleur_rand); // forme de P
imageline($image, $rand20,$rand20/2,$rand20*3,$rand20/2,$couleur_rand); //
imageline($image, $rand20,$rand20,$rand20*3,$rand20/2,$couleur_rand);   //

// Le fond hachuré
for($x = 5; $x < 200; $x+=6)
{	
	imageline($image, $x+rand(10, 20),$x+rand(10, 20),$x+rand(400, 500),$x+rand(140, 160),$couleur_rand);
	imageline($image, $x,rand(1, 5),$x-rand(1, 5),50,$couleur_rand);
	imageline($image, $x-rand(1, 2),rand(1, 5),$x-rand(1, 2)-rand(1, 5),50,$couleur_rand);
}

$_SESSION['captcha'] = $mots[$rand_mots];

imagepng($image); //affiche l'image



