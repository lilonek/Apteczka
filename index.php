<?php 

include 'inc/required.php';

	//Sprawdzam czy przyszlo rzadanie wylogowania
	if ($_GET['wyloguj'] == 1){
		session_destroy();
		header('Refresh: 1; url=index.php');
	}	
	
	//Sprawdzam czy przyszly dane do rejestracji
	if(isset($_POST['email']) && isset($_POST['haslo']) && isset($_POST['imie']) && isset($_POST['nazwisko']))
	{
		$wynik = $baza->query("SELECT * FROM users WHERE email LIKE '".$_POST['email']."'")->fetch_assoc();
		if($wynik == null)
		{
			//password_hash($_POST['haslo'],PASSWORD_DEFAULT)
			$baza->query("INSERT INTO users (imie, nazwisko, haslo, email) VALUES ('".$_POST['imie']."', '".$_POST['nazwisko']."',SHA('".$_POST['haslo']."'), '".$_POST['email']."')");
			$_SESSION['wiadomosc'] = "Zalogowano: ".$_POST['email'];
			$_SESSION['user'] = $_POST['email'];
			$_SESSION['zalogowany'] = true;
		}
		else 
		{
			$_SESSION['wiadomosc'] = "Błąd! Taki email juz istnieje";
			session_destroy();
		}
	}
	
	//Sprawdzam czy przyszĹ‚y dane do logowania
	elseif(isset($_POST['email']) && isset($_POST['haslo'])) 
	{
		$pwd = $baza->query("SELECT * FROM users WHERE email LIKE '".$_POST['email']."' AND haslo LIKE SHA('".$_POST['haslo']."')")->fetch_assoc();
		
		if($pwd!=null)
		{
			$_SESSION['wiadomosc'] = "Zalogowano: ".$_POST['email'];
			$_SESSION['user'] = $_POST['email'];
			$_SESSION['user_id'] = $pwd['idkonta'];
			$_SESSION['zalogowany'] = true;
			$_SESSION['apteczka'] = $_POST['apteczka_id'];
		}
		else $byl_blad_logowania = 2;
	}
?>



<!-- Header i menu  -->
<header>
	<H1><?php echo  $tytul?></H1>
	<H4><?php echo  $podtytul?></H4>
</header>
	
<?php require_once "inc/menu.php";?>
	
<div id="tresc">

<?php
	if( !isset($_GET['wybrano']) ){
		header("Location: index.php?wybrano=0&zaloguj_sie=1");
	}else 
		$opcja = ($_GET['wybrano']);
			
	echo "Wybrano opcję nr: " . $opcja . " - " . $wybrane[$opcja] . "<br><br>";
	echo '<p id="blad">';
		if (isset($byl_blad_logowania) && $byl_blad_logowania == 2) echo $blad_logowania;
	echo '</p>';
	if(!$_SESSION['zalogowany']){
	echo "<b>".$_SESSION['wiadomosc']."</b>";
	
?>
	<form action="" method="POST">
		<fieldset>
			<legend><?php echo $lgLogowanie?></legend>
			<?php echo $lbEmail?><input type="email" name="email" placeholder="<?php echo $logEmailpch?>" required><br>
			<?php echo $lbHaslo?><input type="password" name="haslo" placeholder="<?php echo $logHaslopch?>" required><br>
			<select name="apteczka_id">
				<?php foreach(ApteczkaDB::wszystkieApteczki() as $a): ?>
					<option value="<?php echo $a->id(); ?>"><?php echo $a->nazwa(); ?></option>
				<?php endforeach;?>
			</select>
			<input type="submit">
			<a href="rejestracja.php">Rejestracja</a>
		</fieldset>		
	</form>
<?php 
	
	}else 
	{
		echo $_SESSION['wiadomosc']."<br><br>";
		echo "Leki ze zbliżającym się końcem daty ważnosci:<br><br>";
		
		//Jesli byla prosba o usuniecie leku z apteczki
		if(isset($_GET['usun']))
		{
			ApteczkaDB::usunLek($_GET['usun']);
			echo "Usunięto lek z bazy";
		}
	
		//Leki ktĂłrych koniec daty waĹĽnoĹ›ci jest za mniej niĹĽ 1 miesiÄ…c
// 		$wynik = $baza->query("SELECT * FROM Ap_We_Wy WHERE DATE(data_waznosci)<DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ORDER BY data_waznosci ASC");
		
		$leki = ApteczkaDB::lekiBliskTermin($_SESSION['apteczka']);
		if(isset($leki)){
			foreach ($leki as $row) {	
				//echo  $row["id_Ap_We_Wy"] . ". "; 
				echo  $row["nazwa"] . ", "; 
				echo  $row["op_zb"] . ", "; 
				echo  "<b>Pozostało:</b> ". $row["ilosc"] . ", "; 
	// 			echo  "<b>Cena:</b> ". $row["wartosc"] . ", ";
				echo  "<b><u>Data ważnosci: </u></b> ". $row["data_przeterminowania"] . ",";
				echo  "<b>Dodane dnia:</b> ". $row["data_dodania"] . ", ";
				echo  "<b>Przez:</b> ". $row['imie'] ." ".$row['nazwisko'];
				echo "<br>";
				?><form action="index.php?usun=<?php echo $row["id"];?>" id="usun" method="post"> 
				<input type="submit" value="Usuń z apteczki" /></form><?php
				
				echo "<br>";
			}
		}
	}
?>
</div>
	
	
<?php require_once 'inc/stopka.php';?>