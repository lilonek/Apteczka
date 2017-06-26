<?php 

include'inc/required.php';
	
	if(!isset($_SESSION['zalogowany']))
		header("Location: index.php?wybrano=0&zaloguj_sie=1");
		
?>


	<header>
		<H1><?php echo $tytul?></H1>
		<H4><?php echo $podtytul?></H4>
	</header>
	
<?php require_once 'inc/menu.php';?>
	
	<div id="tresc">
	
	<form action="wyszukiwanie.php" method="post">
	<INPUT type="radio" name="sort" value="nazwa" checked="checked"> <label>NAZWA</label><br>
	<INPUT type="radio" name="sort" value="ean"> <label>EAN</label><br>
	<INPUT type="radio" name="sort" value="subst_czynna"> <label>SUBSTANCJA CZYNNA</label> <br>
	<INPUT type="text" name="wpis" size="25" maxlength="25">
	<INPUT type="submit" value="Szukaj">
	</form>	

	
<?php 
	
	//session_start();
	//Pobieranie danych z formularza
	$sort = isset($_POST['sort']) ? $_POST['sort'] : 'nazwa';
	$Nazwa = isset($_POST['wpis']) ? $_POST['wpis'] : '';
	
	if (!empty($Nazwa))	{
	//Przygotowywanie zapytania 
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
 		}
?>
</div>
	
<?php require_once 'inc/stopka.php';?>

