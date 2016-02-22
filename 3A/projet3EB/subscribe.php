<?php

    require "private/conf.inc.php";
    require "private/functions.php";
    require "user.class.php";

	include "template/header.php";
?>

    <a href="index.php">Accueil</a>
    
<?php
    $list_of_country = ["pa"=>"Paris", "ma"=>"Marseille", "ly"=>"Lyon", "li"=>"Lille"];
	$list_of_kind = [0=>"homme", 1=>"femme"];

if( isset($_POST['nom']) &&  isset($_POST['prenom']) &&  isset($_POST['dateDeNaissance']) &&  isset($_POST['ville']) && 
     isset($_POST['email']) &&  isset($_POST['motDePasse']) &&  isset($_POST['confirmationMotDePasse']) &&    isset($_POST['genre']) ){
	
	$utilisateur = new user();
	
	$utilisateur->name = $_POST["nom"];
	$utilisateur->surname = $_POST["prenom"];
	$utilisateur->birthday = $_POST["dateDeNaissance"];
	$utilisateur->country = $_POST["ville"];
	$utilisateur->email = $_POST["email"];
	$utilisateur->pwd = $_POST["motDePasse"];
	$utilisateur->kind = $_POST["genre"];
	$utilisateur->commentaire = $_POST["commentaire"];
	$utilisateur->cgu = true;
	
	$utilisateur->bdd = connectBdd();
	
	$error = $utilisateur->verify($_POST["confirmationMotDePasse"]);
	
	if($error == 1){
		$utilisateur->save();
		echo "Création réussie";
	} 
	else
	{
		echo "<ul>";
		echo $error;
		echo "</ul>";
	}
	
	//echo "<pre>";
	//var_dump($utilisateur);
	//echo "</pre>";	
}
?>

<!-- DEBUT DU FORMULAIRE -->

<form method="POST">
	<label for="nom">Votre nom</label> : <input type="text" name="nom" id="nom" value="<?php echo (isset($_POST['nom']))?$_POST['nom']:"";?>">
	<br><br>

	<label for="prenom">Votre prénom</label> : <input type="text" name="prenom" id="prenom" value="<?php echo (isset($_POST['prenom']))?$_POST['prenom']:"";?>">
	<br><br>

	<label for="dateDeNaissance">Votre date de naissance</label> : <input type="date" placeholder="jj/mm/aaaa" name="dateDeNaissance" id="dateDeNaissance" value="<?php echo (isset($_POST['dateDeNaissance']))?$_POST['dateDeNaissance']:"";?>">
	<br><br>

	<label for="ville">Votre ville</label> :
	
    <select name="ville" id="ville">
        <?php foreach ($list_of_country as $key=>$country): ?>
            <option value="<?php echo $key;?>"><?php echo $country;?></option>
        <?php endforeach;?>
	</select>

	<br><br>

	<label for="email">Votre email</label> : <input type="email" name="email" id="email" value="<?php echo (isset($_POST['email']))?$_POST['email']:"";?>">
	<br><br>

	<label for="commentaire">Votre commentaire</label> :
	<textarea name="commentaire" id="commentaire" value="<?php echo (isset($_POST['commentaire']))?$_POST['commentaire']:"";?>"></textarea>
	<br><br>

	<label>Votre mot de passe</label> : <input type="password" name="motDePasse">
	<br><br>

	<label>Confirmez votre mot de passe</label> : <input type="password" name="confirmationMotDePasse">
	<br><br><br>

	Cochez votre genre : <br>

    <?php foreach ($list_of_kind as $key=>$kind):?>
        <label for="<?php echo $kind;?>"> <?php echo $kind;?> </label> : <input type="radio" name="genre" id="<?php echo $key;?>" checked value="<?php echo $kind;?>">
    </br>
    <?php endforeach;?>
    <br>

	En cliquant ci-dessous, vous acceptez nos Conditions Générales d'Utilisation (CGU) : <br>
	<label for="CGU"> CGU </label> : <input type="checkbox" name="CGU" id="CGU">
	<br><br>

<!--
    <label for="captcha">Recopiez le mot : </label> <input type="text" name="captcha" id="captcha"> <img src="captcha.php" alt="Captcha">
-->
    <br><br><br>

	<label for="envoyer">Envoyer le formulaire </label> : <input type="submit" value="Envoyer" id="envoyer">
	<br><br>
</form>




