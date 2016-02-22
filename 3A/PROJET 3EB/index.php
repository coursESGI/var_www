<?php
	include "template/header.php";

    define("BDD_DRIVER", "mysql");
    define("BDD_HOST", "localhost");
    define("BDD_DBNAME", "projet3web");
    define("BDD_USER", "root");
    define("BDD_PWD", "root");
?>


<h1>Welcome</h1>

<a href="login.php">Se connecter</a>
<a href="subscribe.php">S'inscrire</a>



<?php
	include "template/footer.php";
?>