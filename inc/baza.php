<?php 
//Połączenie z bazą
	$baza = new mysqli($dbServer, $dbLogin, $dbHaslo, $dbBaza);
	
//Sprawdzenie czy się udało
	if ($baza->connect_error > 0){
		die('Nie można połączyć się z bazą [' . $db->connect_error . ']');
	}
	
//Ustawienie właściwego kodowania
	$baza->set_charset("utf8")
	
?>