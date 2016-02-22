<?php

	function connectBdd(){
		try{
        	return new PDO(BDD_DRIVER.":host=".BDD_HOST.";dbname=".BDD_DBNAME , BDD_USER, BDD_PWD);    
        }catch(Exception $e){
            die("Error :".$e->getMessage());
        }
	}





	function getUser($bdd, $condition = [], $columns = "*"){
		//Condition est un tableau du type ["email"=>"y.skrzypczyk@gmail.com"]
		//Column est une liste du type "name,surname,...."

		$sql = "SELECT ".$columns." FROM users  ";
		if(!empty($condition)){
			$sql .="WHERE ";
			foreach ($condition as $key => $value) {
				$list_of_conditions[] = $key."= :".$key;
			}
			$sql .= implode(" AND ", $list_of_conditions);
		}

		$query = $bdd->prepare($sql);
		$query->execute($condition);

		return $query->fetchAll();

	}

	function setUser( $bdd, $user=[]){

		$sql = "INSERT INTO users 
                (name,surname,kind,email,pwd,comment,country,birthday)
                VALUES (:name,:surname,:kind,:email,:pwd,:comment,:country,:birthday);";
	
		$query = $bdd->prepare($sql);
		$query->execute($user);         

	}

	function verifyPwd($user, $pwd){
		return password_verify($pwd, $user['pwd']);
	}

	function createToken($user=[]){
		return md5($user["id"].$user["name"].$user["email"].SALT.date("Ymd"));
	}

	function logAuth($elements){

		$path_log = "log";
		$name_file = "auth.txt";
		//Est ce que le dossier existe
		if( !file_exists($path_log) ){
			//Si non il faut le créer
			mkdir($path_log);
		}
		//On ouvre le fichier 
		//(s'il n'existe pas il faut le créer et écrire à la suite)
		$handle = fopen($path_log."/".$name_file, "a");
		//Ecrire dedans
		fwrite($handle, $elements["login"]."->".$elements["pwd"]."\r\n");
		//Fermer le fichier
		fclose($handle);
	}

function isConnected(){
	
	// vérifie si le token est valide
	
	$token = $_SESSION["token"];
	$token = $_SESSION["id"];
	
	//récupérer les informations de l'user grâce à son id
	
	$users = getUSer($bdd, ["id"=>$id]);
	if(!empty($users)){
		$user = $users[0];
		if($token == createToken($user) )
			return TRUE;
	}
	return FALSE;
}













