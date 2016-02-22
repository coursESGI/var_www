<?php

function connect_bdd(){
	try{
		$bdd = new PDO("mysql:host=localhost;dbname=exercice_3A", "root", "doudou");
			echo "ok";
	}
	catch(Exception $e){
		die("Error : " . $e->getMessage());
	}
	return $bdd;
}

function get_user($condition, $bdd, $user="*"){
	
}

function set_user($user){
	
}

function create_token(){
	
}

function verif_field_not_empty($field){ //fonction qui vérifie si tous les champs sont remplis
	foreach($field as $value)
	{
		if(!isset($_POST[$value]))
			return false;
	}
	return true;
}

function verif_not_equal($a, $b){  //fontion qui renvoie false si a égal à b
	if($_POST[$a] == $_POST[$b])
		return false;
	else
		return true;
}

function length_interval($string, $min, $max){ //taille maximale et minimale de $string
	if( strlen($_POST[$string]) >= $min && strlen($_POST[$string]) <= $max )
		return true;
	else
		return false;
}

function verif_equal($a, $b){  //fontion qui renvoie true si a égal à b
	if($_POST[$a] == $_POST[$b])
		return true;
	else
		return false;
}

function verif_date($field){ //fonction qui vérifie la date au format jj/mm/aaaa
	$explode = explode("/", $_POST[$field]);
	
	if(count($explode) == 3) //pour éviter warning, vérifie qu'il y a bien trois
	{
		for($i=0; $i<3; $i++) //pour éviter warning, vérifie que la chaîne ne contient que des entiers is_numeric et non is_int car le champ est vu comme une chaîne dans un formulaire
		{
			if(!is_numeric($explode[$i]))
			{
				return false;				
			}
		}
		
		$date = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
		$today = date("d-m-Y");
		if(strtotime($date) > strtotime($today) ) // vérifie date inférieure à la date actuelle
			return false;

		if(checkdate($explode[1], $explode[0], $explode[2]) && $explode[2] > 1900) //vérifie format date
			return true;
	}
	else
		return false;
}

