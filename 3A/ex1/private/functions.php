<?php
function isFirst($number){ //fonction qui vérifie si $number est un nombre 1er
	for($i=2; $i<=$number/2; $i++)
	{
		if($number % $i == 0)
			return false;
	}
	return true;
}
