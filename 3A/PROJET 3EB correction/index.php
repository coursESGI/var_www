<?php
	include "template/header.php";

    define("BDD_DRIVER", "mysql");
    define("BDD_HOST", "localhost");
    define("BDD_DBNAME", "projet3web");
    define("BDD_USER", "root");
    define("BDD_PWD", "root");
?>


<h1>Welcome</h1>

<?php //if(isConnected()):?>
<a href="login.php">Se connecter</a>
<?php //else:?>
<a href="subscribe.php">S'inscrire</a>
<a href="disconnect.php">Se déconnecter</a>
<?php //endif;?>
<img src="captcha.php">
<?php
	include "template/footer.php";
?>
