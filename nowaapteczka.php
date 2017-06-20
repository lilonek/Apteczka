<?php 

include_once 'inc/required.php';
	
	
?>



<!-- Header i menu  -->
<header>
	<H1><?php echo  $tytul?></H1>
	<H4><?php echo  $podtytul?></H4>
</header>
	
<?php require_once "inc/menu.php";?>
	
<div id="tresc">

<?php

if(isset($_GET['dodawanie'])) {
	if($_POST['haslo'] != 'jelonek') {
		echo '<p>Zle haslo mlotku</p>';
	}else {
		ApteczkaDB::dodajApteczke($_POST['nazwa']);
		echo '<p>Apteczka zostala dodana.</p>';
	}	
}
?>
	<form action="nowaapteczka.php?dodawanie" method="POST">
		<fieldset>
			<legend>Dodawanie nowej apteczki</legend>
			<label>Nazwa nowej apteczki</label>
			<input type="text" name="nazwa" />
			<label>Haslo</label>
			<input type="password" name="haslo" />
			<input type="submit" value="Dodaj" />
		</fieldset>		
	</form>

</div>
	
	
<?php require_once 'inc/stopka.php';?>