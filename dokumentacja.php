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
	
	
	<img src="1.jpg" />
	
</div>
<?php 	
	require_once 'inc/stopka.php';
?>