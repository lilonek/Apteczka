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
	$sort = (!isset($_POST['sort']));
	$Nazwa = (!isset($_POST['Nazwa']));	

	//Przygotowywanie zapytania
	if (empty($_POST['sort']) && empty($_POST['Nazwa'])) {
	}
	else 
		$wyszukaj= ApteczkaDB::wyszukajLek($sort,$Nazwa);
	
	//Wyświetlenie wyniku zapytania
	foreach ($wyszukaj as $row):
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
			<?
		
	
	endforeach;
?>
</div>
	
<?php require_once 'inc/stopka.php';?>

