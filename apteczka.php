<?php 
	session_start();
	require_once 'conf/zmienne.php';
	require_once "inc/$lang/teksty.php";
	
	if(!isset($_SESSION['zalogowany']))
	header("Location: index.php?wybrano=0&zaloguj_sie=1");
	
	require_once 'inc/nagl.php';
	require_once 'inc/baza.php';
?>

	<header>
		<H1><?php echo $tytul?></H1>
		<H4><?php echo $podtytul?></H4>
	</header>
	
<?php require_once 'inc/menu.php';?>
	
	<div id="tresc">
	
	
	
<?php 
	//Polaczenie z baza danych
	$idleki = ($_GET['idleki']);
	$usun = ($_GET['usun']);
	$conn = @mysql_connect ($dbServer, $dbLogin, $dbHaslo);
	$select = @mysql_select_db  ($dbBaza, $conn);

	if (!$conn) {
		die ('<p class="error">Nie udało się połączyć z bazą danych.</p>');
	}

	if (!$select) {
		die ('<p class="error">Nie udało się wybrać danych.</p>');
	}	
	
	//Jesli cos przyszlo z wyszukiwarki, to dodaj to do bazy
	if($idleki>0)
	{
		$date = $_POST['date'];
		$cena = $_POST['cena'];
		$ilosc = $_POST['ilosc'];
	
		//Pobieranie informacji o uzytkowniku oraz leku który dodał
		$wynik = $baza->query("SELECT * FROM leki_specyfikacja WHERE idleki LIKE ".$idleki);
		$lek = $wynik->fetch_assoc();
		$wynik = $baza->query("SELECT * FROM users WHERE email LIKE '".$_SESSION['user']."'");
		$user = $wynik->fetch_assoc();
		
		echo "Uzytkownik <b>".$_SESSION['user']."</b> dodał do swojej apteczki lek <b>".$lek['nazwa']."</b>";
		
		//Dodanie rekordu do bazy Apteczka (Ap_We_Wy) - będą 2 scenariusze: istnieje już lek o takiej dacie i cenie; nie istnieje taki lek
		$wynik = $baza->query("SELECT * FROM Ap_We_Wy WHERE DATE(data_waznosci)='".$date."' AND wartosc='".$cena."' AND id_spec='".$idleki."'")->fetch_assoc();
		
		if($wynik != null) //jest juz taki lek
			$baza->query("UPDATE Ap_We_Wy SET pozostalo='".($wynik['pozostalo']+$ilosc)."' WHERE id_Ap_We_Wy='".$wynik['id_Ap_We_Wy']."'");
		
		else //nie ma jeszcze takiego leku, o tej cenie i tej dacie ważności
			$baza->query("INSERT INTO Ap_We_Wy (id_konta, id_spec, data, id_operacja, ilosc, wartosc, pozostalo, data_waznosci, dok_zrodlowy) VALUES 
			('".$user['idkonta']."', '".$lek['idleki']."', '".date("Y-m-d")."', '"."1"."', '".$ilosc."', '".$cena."', '".$ilosc."', '".$date."', '0')");
	}
	
	//Jesli byla prosba o usuniecie leku z apteczki
	elseif($usun>0)
	{
		$baza->query("DELETE FROM Ap_We_Wy WHERE id_Ap_We_Wy='".$usun."'");
		echo "Usunięto lek z bazy";
	}
		
	//Wyswietlanie Apteczki
	//Przygotowywanie zapytania
	$query = "SELECT * FROM Ap_We_Wy ORDER BY data_waznosci ASC";	// lista lekow (z rosnącą datą ważności)
	
	//echo $query;
	//Wykonanie zapytania i pobieranie wyników
	$wynik = $baza->query($query);
	echo "<hr>";
	
	//Wyświetlenie wyniku zapytania
	while ($wynik!=null && $row = $wynik->fetch_assoc()) {
		$row_leki = $baza->query("SELECT * FROM leki_specyfikacja WHERE idleki LIKE ".$row["id_spec"])->fetch_assoc();
		$row_users = $baza->query("SELECT * FROM users WHERE idkonta LIKE ".$row["id_konta"])->fetch_assoc();		
			
		//echo  $row["id_Ap_We_Wy"] . ". "; 
		echo  $row_leki["nazwa"] . ", "; 
		echo  $row_leki["op_zb"] . ", "; 
		echo  "<b>Pozostało:</b> ". $row["pozostalo"] . ", "; 
		echo  "<b>Cena:</b> ". $row["wartosc"] . ", ";
		echo  "<b>Data ważności:</b> ". $row["data_waznosci"] . ", ";
		echo  "<b>Dodane dnia:</b> ". $row["data"] . ", ";
		echo  "<b>Przez:</b> ". $row_users["imie"] . " ";
		echo  $row_users["nazwisko"];
		?><form action="apteczka.php?usun=<?php echo $row["id_Ap_We_Wy"];?>" id="usun" method="post"> 
			<input type="submit" value="Usuń z apteczki" /></form><?php
		echo "<br>";	 
	}
	
?>
</div>
	
<?php require_once 'inc/stopka.php';?>

