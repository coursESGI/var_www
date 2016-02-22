<?php
	include "template/header.php"; //include : si chemin non valide, warning; require : si chemin non valide, erreur fatale
	require "private/functions.php";
?>

<article>
	<?php
		$tab = [
					["nom"=>"a", "prenom"=>"b"],
					["nom"=>"a2", "prenom"=>"b2"],
					["nom"=>"a3","prenom"=>"b3"],
					["nom"=>"a4","prenom"=>"b4"],
		];		

		//~ echo "<table>";		
		//~ foreach($tab as $key=>$value) //on peut enlever "$key=>" ici
		//~ {
			//~ echo "<tr><td>" . $value["nom"] . "<td>" . $value["prenom"] . "</td></tr>";						
		//~ }
		//~ echo "</table>";
		
		//echo 4%1;
		
		
		
		$x = 100;
		$chiffreAVerifier = 2;
		
		while($x > 0)
		{			
			if (isFirst($chiffreAVerifier))
			{
				echo $chiffreAVerifier . "<br>";
				$x--;
			}
			$chiffreAVerifier++;					
		}
		echo "<hr>";
		//~ for ($nombre=2; $nombre < 100; $nombre++)
		//~ {
			//~ $verif = 0;
			//~ 
			//~ for ($diviseur=2; $diviseur < $nombre/2+1 ; $diviseur++)
			//~ {
				//~ if ($nombre % $diviseur == 0)
				//~ {
					//~ $verif = 1;
					//~ break;
				//~ }
			//~ }
			//~ if ($verif == 0)
			//~ {
				//~ echo $nombre."<br>";
			//~ }
		//~ }
	?>
</article>

<?php
	include "template/footer.php";
?>
