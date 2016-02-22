<?php

class routing{
	public static function setRouting(){
		$uri = trim($_SERVEUR["REQUEST_URI"], "/"); // fin d'une adresse url // trim pour enlever le / 
		$explode_uri = explode("?", $uri);
		$uri = $explode_uri[0];
		$uri = str_replace("3A/MVC_1/", "", $uri);
		$explode_uri = explode("/", $uri);
		$c = isset($explode_uri[0]) ? explode_uri[0] : "index";
		$a = isset($explode_uri[1]) ? explode_uri[1] : "index";
		unset($explode_uri[0]);
		unset($explode_uri[1]);
		$args = array_merge($explode_uri, $_REQUEST);
		
		return [ "c" => $c, "a" => $a, "args " => $args ];
		
		echo $uri;
	}
}
