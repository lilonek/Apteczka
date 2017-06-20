<?php

include_once 'inc/required.php';

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

	//Jesli cos przyszlo z wyszukiwarki, to dodaj to do bazy
	if(isset($_GET['idleki']))
	{
		$idleki = $_GET['idleki'];
		
		$dataPrzeterminowania = $_POST['date'];
		$cena = $_POST['cena'];
		$iloscLeku = $_POST['ilosc'];
		$lek = LekDB::getLekById($idleki);
			
		$apteczka = ApteczkaDB::getApteczkaById($_SESSION['apteczka']);
		$uzytkownik = UzytkownikDB::uzytkownikByID($_SESSION['user_id']);
		
		ApteczkaDB::dodajLek($apteczka, $lek, $iloscLeku, $cena, $dataPrzeterminowania, $uzytkownik);
		echo '<p>'.$uzytkownik->imie().' dodał/-a '.$lek->nazwaLeku().'</p>';
	}
	
	//Jesli byla prosba o usuniecie leku z apteczki
	elseif(isset($_GET['usun']))
	{
		ApteczkaDB::usunLek($_GET['usun']);
	}
	
	
	if(isset($_GET['wezlek'])){
		$idwpis = $_GET['wezlek'];
		$ilosc = $_POST['wezilosc'];
		if(!ApteczkaDB::wezLek($idwpis, $ilosc)){
			echo '<p>Masz za malo leku!</p>';
		}else {
			echo '<p>Zabrano '.$ilosc.' sztuk leku z apteczki</p>';
		}
	}

	echo "<hr><table><tr>
		<th>Nazwa</th>
		<th>Ilosc</th>
		<th>Data przeterminowania</th>
		<th>Data dodania</th>
		<th>Uzytkownik</th>
<th>Menu</th>
		</tr>";
	
	//Wyświetlenie wyniku zapytania

	$leki = ApteczkaDB::pobierzLeki($_SESSION['apteczka']);
	foreach ($leki as $lek):
	?>
		<tr>
			<td><?php echo $lek['nazwa'] ?></td>
			<td><?php echo $lek['ilosc'] ?></td>
			<td><?php echo $lek['data_przeterminowania'] ?></td>
			<td><?php echo $lek['data_dodania'] ?></td>
			<td><?php echo $lek['imie'].' '.$lek['nazwisko'] ?></td>
			<td>
			<form action="apteczka.php?wezlek=<?php echo $lek["id"];?>" id="wezilosc" method="post"> 
		Ilosc: <input type="number" name="wezilosc" min="1" style = "width: 100px" required>
			<input name = "wezlek" type="submit" value="Weź lek z apteczki" /></form>
		<form action="apteczka.php?usun=<?php echo $lek["id"]; ?>" id="usun" method="post"> 
			<input type="submit" value="Usuń z apteczki" /></form>
			</td>
		</tr>
		
		
	<?
	endforeach;		
	echo "</table>";	 
	
?>
</div>
	
<?php require_once 'inc/stopka.php';?>

