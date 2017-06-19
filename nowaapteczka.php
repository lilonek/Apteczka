<?php 

	require_once 'conf/zmienne.php';
	//require_once "inc/$lang/error_msg.php";
	require_once "inc/$lang/teksty.php";
	require_once 'inc/baza.php';
	
	
	require_once 'inc/nagl.php';
	require_once 'classes/Apteczka.php';
	require_once 'classes/DB.php';
	require_once 'classes/ApteczkaDB.php';
	
	DB::connect('mysql.agh.edu.pl', 'klaudgg', 'mPcSRXL8PzzQJRrd','klaudgg');
	
	
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