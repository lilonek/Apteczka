<?php

include_once 'inc/required.php';

if(!isset($_SESSION['zalogowany']))
	header("Location: index.php?wybrano=0&zaloguj_sie=1");

	
	
	?>

	<header>
		<H1><?php echo $tytul?></H1>
		<H4><?php echo $podtytul?></H4>
	</header>
	
<?php require_once 'inc/menu.php';?>
	
	<div id="tresc">
	
<form action="" method="POST">

				Nazwa użytkownika:
					<div class="form-group">
						<select class="form-control" id = "iduser" name = "iduser">
						  <?php 	
							//przygotowanie zapytania	
								$query = "SELECT * FROM users ORDER BY users.idkonta"; 
		
							//wykonanie zapytania i pobranie wyników
								$wynik = $baza->query($query);
								while ($row = $wynik->fetch_assoc()) {
									echo '<option value = "' . $row['idkonta'] . '">' .$row['imie']." ". $row['nazwisko']. '</option>';
								}
						  ?>
						</select> 			
					</div>
			
				<p><input type="submit" value="Sprawdź" name="check" /></p>
				
	
<?php 	
//Wy�wietlenie wyniku zapytania

if(isset($_POST['check']))
{
	$raport = ApteczkaDB::allUsersRaports($_SESSION['apteczka'],$_POST['iduser']);
	
	//Wyświetlenie wyniku zapytania
	echo "<hr><table><tr>
		<th>Data zażycia leku</th>
		<th>Ilosc</th>
		<th>Jaki lek</th>
		</tr>";
	
	
	foreach ($raport as $lek):
	?>
		<tr>
			<td><?php echo $lek['data_dodania'] ?></td>
			<td><?php echo $lek['ilosc'] ?></td>
			<td><?php echo $lek['nazwa'] ?></td>
			<td>
			</td>
		</tr>
		
		
	<?
	endforeach;		
	echo "</table>";	 

}
	
	
?>
