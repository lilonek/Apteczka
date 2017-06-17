<?php 

	session_start();
	require_once 'conf/zmienne.php';
	//require_once "inc/$lang/error_msg.php";
	require_once "inc/$lang/teksty.php";
	require_once 'inc/baza.php';		
	require_once 'inc/nagl.php';
	
	$conn = @mysql_connect ($dbServer, $dbLogin, $dbHaslo);
	$select = @mysql_select_db  ($dbBaza, $conn);
	
	
	//Sprawdzam czy przyszlo rzadanie wylogowania
	if($_GET['wyloguj'] == 1){
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
			$_SESSION['wiadomosc'] = "BŁĄD! Taki email juz istnieje";
			session_destroy();
		}
	}
	
	//Sprawdzam czy przyszły dane do logowania
	elseif(isset($_POST['email']) && isset($_POST['haslo'])) 
	{
		$pwd = $baza->query("SELECT * FROM users WHERE email LIKE '".$_POST['email']."' AND haslo LIKE SHA('".$_POST['haslo']."')")->fetch_assoc();
		if($pwd!=null)
		{
			$_SESSION['wiadomosc'] = "Zalogowano: ".$_POST['email'];
			$_SESSION['user'] = $_POST['email'];
			$_SESSION['zalogowany'] = true;
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
			<input type="submit">
			<a href="rejestracja.php">Rejestracja</a>
		</fieldset>		
	</form>
<?php 
	
	}else 
	{
		echo $_SESSION['wiadomosc']."<br><br>";
		echo "Leki ze zbliżającym się końcem daty ważności:<br><br>";
		
		$usun = ($_GET['usun']);
		//Jesli byla prosba o usuniecie leku z apteczki
		if($usun>0)
		{
			$baza->query("DELETE FROM Ap_We_Wy WHERE id_Ap_We_Wy='".$usun."'");
			echo "Usunięto lek z bazy";
		}
	
		//Leki których koniec daty ważności jest za mniej niż 1 miesiąc
		$wynik = $baza->query("SELECT * FROM Ap_We_Wy WHERE DATE(data_waznosci)<DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ORDER BY data_waznosci ASC");
		
		while ($wynik!=null && $row = $wynik->fetch_assoc()) {
			$row_leki = $baza->query("SELECT * FROM leki_specyfikacja WHERE idleki LIKE ".$row["id_spec"])->fetch_assoc();
			$row_users = $baza->query("SELECT * FROM users WHERE idkonta LIKE ".$row["id_konta"])->fetch_assoc();
			
			//echo  $row["id_Ap_We_Wy"] . ". "; 
			echo  $row_leki["nazwa"] . ", "; 
			echo  $row_leki["op_zb"] . ", "; 
			echo  "<b>Pozostało:</b> ". $row["pozostalo"] . ", "; 
			echo  "<b>Cena:</b> ". $row["wartosc"] . ", ";
			echo  "<b><u>Data ważności: ". $row["data_waznosci"] . ", </u></b>";
			echo  "<b>Dodane dnia:</b> ". $row["data"] . ", ";
			echo  "<b>Przez:</b> ". $row_users["imie"] . " ";
			echo  $row_users["nazwisko"];
			echo "<br>";
			?><form action="index.php?usun=<?php echo $row["id_Ap_We_Wy"];?>" id="usun" method="post"> 
			<input type="submit" value="Usuń z apteczki" /></form><?php
			
			echo "<br>";
		}
	}
?>
</div>
	
	
<?php require_once 'inc/stopka.php';?>