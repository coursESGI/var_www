<?php
	session_start();
	require "private/conf.inc.php";
	require "private/functions.php";



		$error = FALSE;
		$msgError = "Identifiants incorrects";

		if(isset($_POST["login"]) && isset($_POST["pwd"])){

			//Se connecter à la bdd
			$bdd = connectBdd();

			//Demander au serveur SQL toutes les informations en fonction de l'email
			$users = getUser($bdd, ["email"=>$_POST["login"]]);
			$user = $users[0];

			//Si aucune information, identifiants not ok
			if( empty($user)){
				$error = TRUE;
			}else{
				//Sinon on vérifie le mot de passe
				if(verifyPwd($user, $_POST["pwd"])){
						
					setcookie("name",$user["name"]);
					setcookie("surname",$user["surname"]);

					$_SESSION['id'] =  $user["id"];

					$_SESSION['token'] = createToken($user);
					
					header("Location: index.php");


				}else{
					$error = TRUE;
				}
			}

		}

		include "template/header.php";

		if($error){
			logAuth($_POST);
			echo $msgError;
		}


	?>

	<form method="POST">
		<input type="text" name="login" placeholder="email">
		<input type="password" name="pwd" placeholder="Mot de passe">
		<input type="submit" value="Se connecter">
	</form>

<?php
	include "template/footer.php";
?>
