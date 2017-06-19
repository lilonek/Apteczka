<?php
	//Zakładam, że ten skrypt będzie załadowany po załadowaniu zmiennych
	
	$dbServer;		/*serwer, na którym działa MySQL*/
	$dbLogin;			/*nazwa użytkownika*/
	$dbHaslo;			/*hasło użytkownika*/
	$dbBaza;			/*wybrana baza danych*/
	
	//Połączenie z bazą
	$baza = new mysqli($dbServer, $dbLogin, $dbHaslo, $dbBaza);
	
	//Sprawdzenie czy się udało
	if ($baza->connect_error > 0){
		die('Nie można się połączyć z [' . $db->connect_error . ']');
	}
	
	//Ustawienie właściwego kodowania
	$baza->set_charset("utf8");

?>