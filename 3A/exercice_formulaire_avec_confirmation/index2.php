<?php
	include "template/header.php"; //include : si chemin non valide, warning; require : si chemin non valide, erreur fatale
	require "private/functions.php";
?>

<article>
	Tous les champs sont obligatoires, sauf commentaire.
	<form method="POST" action="index2.php?submit=1">
		<table>
			<tr>
				<td>email</td>
				<td>
					<input value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>"
					type="text" placeholder="email" name="email">
				</td>
			</tr>
			<tr>
				<td>nom</td>
				<td>
					<input value="<?php if(isset($_POST["name"])) echo $_POST["name"]?>"
					type="text" placeholder="nom" name="name">
				</td>
			</tr>
			<tr>
				<td>prénom</td>
				<td>
					<input value="<?php if(isset($_POST["first_name"])) echo $_POST["first_name"]?>"
					type="text" placeholder="prénom" name="first_name">
				</td>
			</tr>
			<tr>
				<td>date de naissance</td>
				<td>
					<input value="<?php if(isset($_POST["birth"])) echo $_POST["birth"]?>"
					type="text" placeholder="naissance jj/mm/aaaa" name="birth">
				</td>
			</tr>
			<tr>
				<td> Pays : </td>
				<td>
					<select name="country">
						<option value="france">France</option>
						<option value="suede">Suède</option>
						<option value="russie">Russie</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>civilité : </td>
				<td>
					<input type="radio" name="sexe" value="homme">Homme
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="radio" name="sexe" value="femme">Femme
				</td>
			</tr>
			<tr>
				<td>commentaire</td>
				<td>
					<textarea name="comment"></textarea>
				</td>
			</tr>
			<tr>
				<td>mot de passe</td>
				<td>
					<input type="password" placeholder="mot de passe" name="passwd">
				</td>
			</tr>
			<tr>
				<td>confirmation mot de passe</td>
				<td>
					<input type="password" placeholder="confirm mot de passe" name="passwd_confirm">
				</td>
			</tr>
			<tr>
				<td>Validez-vous le CGU ?</td>
				<td>
					<input type="checkbox" name="cgu" value="cgu">oui
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="valider">
				</td>
			</tr>
		</table>
	</form>
</article>

<article>
	<ul>
<?php
	
	$faux = 0;
		
	if(isset($_GET["submit"]) && $_GET["submit"] == 1){ //si il a déjà appuyé sur valider
		$fields = ["email", "name", "first_name", "birth", "country", "sexe", "passwd", "passwd_confirm", "cgu"];
		
		if(!verif_field_not_empty($fields)) //verif isset chaque champ obligatoire
		{
			echo "<li>Tous les champs obligatoires n'ont pas été remplis</li>";
			$faux = 1;
		}
		else
		{
			if(!verif_not_equal("name", "first_name")){
				echo "<li>Les champs nom et prénom ne doivent pas être identiques</li>";
				$faux = 1;
			}
			if(!length_interval("passwd", 8, 12)){
				echo "<li>Le mot de passe doit contenir entre 9 et 12 caractères</li>";
				$faux = 1;
			}
			if(!verif_equal("passwd", "passwd_confirm")){
				echo "<li>Les deux mots de passes entrés ne sont pas les mêmes</li>";
				$faux = 1;
			}
			if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
				echo "<li>emails invalide</li>";
				$faux = 1;
			}
			if(!verif_date("birth")){
				echo "<li>date invalide</li>";
				$faux = 1;
			}
		}
		
	if($faux == 0){
		$bdd = connect_bdd();
	
	/*
		SELECT * FROM infos WHERE id = 2
		INSERT INTO infos (name, surname) VALUES ("x", "y");
		UPDATE infos SET name="a", surname = "b" WHERE id = 2;
		DELETE infos WHERE id = 2;
	*/
    
    $login = "gaetan.ab@gmail.com";
    $error = FALSE;
    
    $query = $bdd->prepare('SELECT * FROM infos WHERE email = :email');
    $query->execute( [ "email" => strtolower($login) ] );
    $user = $query->fetch(PDO::FETCH_ASSOC);  // pour ne récupérer que les clefs et les valeurs
    
    foreach($user as $value)
		echo "<br>" . $value;
		
	if(empty($user)){
		$error = TRUE;
	}
	else {
		//echo $user["pwd"]; // : mot de passe de la base de données
	}
	
	define("GRAIN_DE_SABLE", "FGYH848646565HGG");
    
    $_SESSION["id"] = "identifiant"; 
    
    $_SESSION["token"] = md5($info["id"] . $user["name"] . $user["email"] . GRAIN_DE_SABLE . date("Ymd"));  // un token par user
    
    header("Location: index.php"); // ne pas mettre d'html avant un header
    
    /*$f = [$_POST['name'], $_POST['first_name'], $_POST['sexe'], $_POST['email'], $_POST['passwd'], $_POST['birth'], $_POST['country']];
	//méthode 1
	$query = $bdd->prepare('INSERT INTO infos (name, surname, kind, email, pwd, birthday, country)
	VALUES (:name, :surname, :kind, :email, :pwd, :birthday, :country);');
	$query->execute(["name"=>$f[0], "surname"=>$f[1], "kind"=>$f[2], "email"=>$f[3], "pwd"=>$f[4], "birthday"=>$f[5], "country"=>$f[6]]);	*/
	}
}

?>
	</ul>
</article>

<?php
	include "template/footer.php";
?>
