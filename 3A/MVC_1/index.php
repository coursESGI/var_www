<?php

require_once "conf.inc.php";

function autoloader($class){ // inclut les classes
	//vérifier s'il existe dans le dossier core un fichier $class.class.php
	// s'il existe, on l'inclut
	
	if(file_exists("core/".$class.".class.php"))
		include "core/".$class.".class.php";
}

spl_autoload_register("autoloader"); //appelle autoloader 

routing::setRouting();  //remplace new routing();  // appelle setRouting sans créer d'objet

$name_controller = $route["c"]."Controller";
$path_controller = "controllers/".$name_controller."class.php"

if( file_exists($path_controller) ){
	include $path_controller;
	$controller = new $name_controller;
}
else{
	die ("erreur, le contrôleur n'existe pas");
}
