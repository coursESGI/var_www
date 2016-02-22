<?php

    require "private/conf.inc.php";
    require "private/functions.php";


	include "template/header.php";
?>

    <a href="index.php">Accueil</a>
<?php



    $list_of_country = ["pa"=>"Paris", "ma"=>"Marseille", "ly"=>"Lyon", "li"=>"Lille"];
    $list_of_kind = [0=>"homme", 1=>"femme"];

    $error = FALSE;
    $msg_error = "";



    if( isset($_POST['nom']) &&  isset($_POST['prenom']) &&  isset($_POST['dateDeNaissance']) &&  isset($_POST['ville']) && 
     isset($_POST['email']) &&  isset($_POST['motDePasse']) &&  isset($_POST['confirmationMotDePasse']) &&    isset($_POST['genre']) ){


        $_POST['nom'] = strtolower(trim($_POST['nom']));
        $_POST['prenom'] = strtolower(trim($_POST['prenom']));
        $_POST['email'] = strtolower(trim($_POST['email']));

        if(strlen($_POST['nom'])<2){
            $error = TRUE;
            $msg_error .= "<li>Le nom doit faire plus d'un caractère";
        }
        if(strlen($_POST['prenom'])<2){
            $error = TRUE;
            $msg_error .= "<li>Le prénom doit faire plus d'un caractère";
        }
        if( $_POST['nom'] === $_POST['prenom']){
            $error = TRUE;
            $msg_error .= "<li>Le prénom doit être différent du nom";
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error = TRUE;
            $msg_error .= "<li>Email invalide";
        }
        if(strlen($_POST['motDePasse']) <8 || strlen($_POST['motDePasse'])>12){
            $error = TRUE;
            $msg_error .= "<li>Le mot de passe doit faire entre 8 et 12 caractères";
        }
        if($_POST['motDePasse'] != $_POST['confirmationMotDePasse']){
            $error = TRUE;
            $msg_error .= "<li>Le mot de passe de confirmation ne correspond pas";
        }
        if(! isset($list_of_country[$_POST['ville']]) ){
            $error = TRUE;
            $msg_error .= "<li>Votre ville n'existe pas";
        }
        if(!in_array($_POST['genre'], $list_of_kind)){
            $error = TRUE;
            $msg_error .= "<li>Le genre n'existe pas";
        }

        //Quand le format date fonctionne j'ai 2015-11-18
        //Sinon je vais devoir m'adapter
        //2012-07-08
        $now = new DateTime();


        //Vérifier la présence du "-"
        if( strpos($_POST['dateDeNaissance'], "-") ){
            $explode_date = explode("-", $_POST['dateDeNaissance']);
            
            list($year, $month, $day) = explode('-', $_POST['dateDeNaissance']);
            $time_birthday = mktime(0, 0, 0, $month, $day, $year);

            if( checkdate ( $month , $day , $year )){
                $bithdayDate = new DateTime($_POST['dateDeNaissance']);
                $interval = $now->diff($bithdayDate);
                $age = $interval->y;

                if($age >= 100 ){
                    $error = TRUE;
                    $msg_error .= "<li>Date de naissance incorrecte";
                }
            }
        }
        //Vérifier la présence du "/"
        else if( strpos($_POST['dateDeNaissance'], "/") ){

            list($day, $month, $year) = explode('/', $_POST['dateDeNaissance']);
            $time_birthday = mktime(0, 0, 0, $month, $day, $year);

            if( checkdate ( $month , $day , $year )){
                $bithdayDate = new DateTime($year."-".$month."-".$day);
                $interval = $now->diff($bithdayDate);
                $age = $interval->y;

                if($age >= 100 ){
                    $error = TRUE;
                    $msg_error .= "<li>Date de naissance incorrecte";
                }
            }
        }
        //Erreur
        else{
            $error = TRUE;
            $msg_error .= "<li>Date de naissance incorrecte";
        }
        
        if(!isset($_POST["CGU"])){
            $error = TRUE;
            $msg_error .= "<li>Veuillez accepter les CGUs";
        }

        //Vérification de l'unicité de l'email
        $bdd = connectBdd();
        $users = getUser($bdd, ["email"=>$_POST["email"]] , "id");
        if(!empty($users)){
            $error = TRUE;
            $msg_error .= "<li>L'email existe déjà";

        }

        //if ($_POST['captcha'] != $_SESSION['captcha'])
        //{
            //$error = TRUE;
            //$msg_error .= "<li>Le captcha saisi est invalide";
        //}





      if($error){
            echo "<ul>";
            echo $msg_error;
            echo "</ul>";
        }else{


            $pwd = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);

            setUser( $bdd, ["name"=>$_POST['nom'],
                            "surname"=>$_POST['prenom'],
                            "kind"=>$_POST['genre'],
                            "email"=>$_POST['email'],
                            "pwd"=>$pwd,
                            "comment"=>$_POST['commentaire'],
                            "country"=>$_POST['ville'],
                            "birthday"=> $_POST['dateDeNaissance']]  );

         
        }

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

<?php
if( isset($_POST['nom']) &&  isset($_POST['prenom']) &&  isset($_POST['dateDeNaissance']) &&  isset($_POST['ville']) && 
     isset($_POST['email']) &&  isset($_POST['motDePasse']) &&  isset($_POST['confirmationMotDePasse']) &&    isset($_POST['genre']) ){
	
	$utilisateur = new user();
	
	$utilisateur->verify($_POST);
	
	//$utilisateur->name = "nom";
	//$utilisateur->surname = "prénom";
	//$utilisateur->birthday = "14/02/1995";
	//$utilisateur->country = "ville";
	//$utilisateur->email = "email";
	//$utilisateur->pwd = "mot de passe";
	//$utilisateur->kind = "genre";
	//$utilisateur->cgu = true;
	//
	//if($utilisateur->verify())
		//$utilisateur->save();
	//
	//echo "<pre>";
	//var_dump($utilisateur);
	//echo "</pre>";
}
?>


