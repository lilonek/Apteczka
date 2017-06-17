<?php 
	session_start();
	require_once 'conf/zmienne.php';
	require_once "inc/$lang/teksty.php";	
	require_once 'inc/nagl.php';
	require_once 'inc/baza.php';
?>

	<header>
		<H1><?php echo $tytul?></H1>
		<H4><?php echo $podtytul?></H4>
	</header>
	
<?php require_once 'inc/menu.php';?>
	
	<div id="tresc">
	
	<form action="index.php" method="post">
	<INPUT type="text" name="imie" size="25" maxlength="25" placeholder="Imie" required><br>
	<INPUT type="text" name="nazwisko" size="25" maxlength="25" placeholder="Nazwisko" required><br>
	<input type="email" name="email" placeholder="Wprowadź swój email" required><br>
	<input type="password" name="haslo" placeholder="Wprowadź hasło" required><br><br>
	<INPUT type="submit" value="Rejestracja">
	</form>	
	
<?php ?>
	
</div>
	
<?php require_once 'inc/stopka.php';?>

