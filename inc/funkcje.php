 <?php
//Sprawdzenie czy zalogowano

function sprawdz_login_haslo($login, $pwd){

	global $baza;
 	$query = "select * from `konta` where email = '$login'";
	$wynik = $baza->query($query);
	
	if (($wynik -> num_rows) == 1){
		$row = $wynik -> fetch_assoc();

		if ($pwd == $row['haslo'])
			return true;
		else 
			return false;
	}
	else 
		return false;
}	

?>	