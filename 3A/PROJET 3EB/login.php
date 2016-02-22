	

    <?php
            session_start();
            require "private/conf.inc.php";
            require "private/functions.php";
     
     
     
                    $error = FALSE;
                    $msgError = "Identifiants incorrects";
     
                    if(isset($_POST["login"]) && isset($_POST["pwd"])){
     
                            //Se connecter à la bdd
                            $bdd = connectBdd();
						    $user = getUser($bdd, ["email"=>$_POST["login"]], "*");
						    $user = $user[0];
						    
                            //Demander au serveur SQL toutes les informations en fonction de l'email
                            $query = $bdd->prepare("SELECT * FROM users WHERE email=:email");
                            $query->execute(["email"=>  strtolower($_POST["login"]) ]);
                            $user = $query->fetch(PDO::FETCH_ASSOC);
     
                            //Si aucune information, identifiants not ok
                            if( empty($user)){
                                    $error = TRUE;
                            }else{
                                    //Sinon on vérifie le mot de passe
                                    if(password_verify( $_POST["pwd"] , $user['pwd'] )){
                                                   
                                            setcookie("name",$user["name"]);
                                            setcookie("surname",$user["surname"]);
     
                                            $_SESSION['id'] =  $user["id"];
											
											createToken($user);
                                            //~ $_SESSION['token'] = 
                                           
                                            header("Location: index.php");
     
     
                                    }else{
                                            $error = TRUE;
                                    }
                            }
     
                    }
     
                    include "template/header.php";
     
                    if($error){
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
                            fwrite($handle, $_POST["login"]."->".$_POST["pwd"]."\r\n");
                            //Fermer le fichier
                            fclose($handle);
     
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

