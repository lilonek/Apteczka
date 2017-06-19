<?php 
error_reporting(E_ALL);
session_save_path("/home/piegrp/klaudgg/public_html/SIwM");
session_start();

	require_once 'classes/Apteczka.php';
	require_once 'classes/Lek.php';
	require_once 'classes/Uzytkownik.php';
	require_once 'classes/DB.php';
	require_once 'classes/ApteczkaDB.php';
	require_once 'classes/LekDB.php';
	require_once 'classes/UzytkownikDB.php';
	
	
	// phpinfo();
	
	
	DB::connect('mysql.agh.edu.pl', 'klaudgg', 'mPcSRXL8PzzQJRrd','klaudgg');
	
	require_once 'conf/zmienne.php';
	require_once "inc/$lang/teksty.php";
	
	if(!isset($_SESSION['zalogowany']))
		header("Location: index.php?wybrano=0&zaloguj_sie=1");
		
		require_once 'inc/nagl.php';
		//require_once 'inc/baza.php';
?>


	<header>
		<H1><?php echo $tytul?></H1>
		<H4><?php echo $podtytul?></H4>
	</header>
	
<?php require_once 'inc/menu.php';?>
	
	<div id="tresc">
	
	<form action="wyszukiwanie.php" method="post">
	<INPUT type="radio" name="sort" value="nazwa"> <label>NAZWA</label><br>
	<INPUT type="radio" name="sort" value="ean"> <label>EAN</label><br>
	<INPUT type="radio" name="sort" value="subst_czynna"> <label>SUBSTANCJA CZYNNA</label> <br>
	<INPUT type="text" name="Nazwa" size="25" maxlength="25">
	<INPUT type="submit" value="Szukaj">
	</form>	
	
<?php 
	//session_start();
	//Pobieranie danych z formularza
	$sort = $_POST['sort'];
	$Nazwa = $_POST['Nazwa'];
			
	//Polaczenie z baza danych
// 	$conn = @mysql_connect ($dbServer, $dbLogin, $dbHaslo);
// 	$select = @mysql_select_db  ($dbBaza, $conn);

// 	if (!$conn) {
// 		die ('<p class="error">Nie udało się połączyć z bazą danych.</p>');
// 	}

// 	if (!$select) {
// 		die ('<p class="error">Nie udało się wybrać bazy danych.</p>');
// 	}	

	//Przygotowywanie zapytania
	if (empty($_POST['sort']) && empty($_POST['Nazwa'])) {
		//$query = "SELECT * FROM leki_specyfikacja";	// lista lekow na poczatku
	}
	else {$query = "SELECT * FROM leki_specyfikacja WHERE ".$sort." LIKE '".$Nazwa."%'";}
	
	//echo $query;
	//Wykonanie zapytania i pobieranie wyników
	$wynik = $baza->query($query);
	
	echo "<hr>";
	
	//Wyświetlenie wyniku zapytania
	while ($wynik!=null && $row = $wynik->fetch_assoc()) {
			echo  $row["idleki"] . ". "; 
			echo  $row["nazwa"] . ", ";
			echo  $row["subst_czynna"] . ", ";
			echo  $row["ean"] . ", ";
			echo  $row["op_zb"];
			echo "<br>";
			?> <form action="apteczka.php?idleki=<?php echo $row["idleki"]; ?>" id="form_wysz" method="post"> 
				<input type="submit" value="Dodaj lek do apteczki" /> 
				<input type="date" name="date">
				<INPUT type="text" name="ilosc"  placeholder="Ilość" size="15" maxlength="25">
				<INPUT type="text" name="cena"  placeholder="Cena" size="15" maxlength="25">
			</form> 
			<?php
		
	}
?>
</div>
	
<?php require_once 'inc/stopka.php';?>

