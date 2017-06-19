<?php 

class ApteczkaDB
{
	private static $LEKIAPTECZKA_TABLE = 'leki_apteczka';
	
	public static function wszystkieApteczki(){
		$apteczki = array();
		$rows = DB::getConnection()->query("SELECT * FROM apteczki");
		foreach($rows as $row) {
			array_push($apteczki, new Apteczka($row['id'], $row['nazwa']));
		}
		return $apteczki;
	}
	
	public static function getApteczkaById($id) {
		$row = DB::getConnection()->query("SELECT * FROM apteczki WHERE id=$id");
		$row = $row->fetch();
		return new Apteczka($row['id'], $row['nazwa']);
	}
	
	public static function dodajLek(Apteczka $apteczka, Lek $lek, $iloscLeku, $cena, $dataPrzeterminiowania, $uzytkownik) {
		
		$query = 'INSERT INTO '.self::$LEKIAPTECZKA_TABLE.' VALUES (null, :id_lek, :id_apteczka, :id_uzytkownik, :cena, :ilosc, :data_przeterminowania, :data_dodania)';
		try{
			DB::getConnection()->beginTransaction();
			$q = DB::getConnection()->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$result = $q->execute(array(
					':id_apteczka' => $apteczka->id(),
					':id_lek' => $lek->id(),
					':id_uzytkownik' => $uzytkownik->id(),
					':cena' => $cena,
					':ilosc' => $iloscLeku,
					':data_przeterminowania' => $dataPrzeterminiowania,
					':data_dodania' => date('Y-m-d')
			));
			
			DB::getConnection()->commit();
		}catch (Exception $e) {
			DB::getConnection()->rollBack();
		}
		
	}
	
	public static function pobierzLeki($apteczkaID) {
		$leki = array();
		$sql = "SELECT * FROM leki_apteczka 
				LEFT JOIN leki_specyfikacja ON leki_apteczka.id_lek = leki_specyfikacja.idleki
				LEFT JOIN users ON leki_apteczka.id_uzytkownik = users.idkonta 
				WHERE id_apteczka=$apteczkaID";
		$rows = DB::getConnection()->query($sql);
		
		return $rows->fetchAll();
	}
	
	public static function wezLek($idwpis, $ilosc) {
		$wpis = DB::getConnection()->query('SELECT * FROM '.self::$LEKIAPTECZKA_TABLE.' WHERE id='.$idwpis)->fetch();
		if($wpis['ilosc'] < $ilosc) {
			return false;
		}
		
		$nowaIlosc = $wpis['ilosc'] - $ilosc;
		
		if($nowaIlosc == 0) {
			return self::usunLek($idwpis);
		}else {
			DB::getConnection()->query("UPDATE leki_apteczka SET ilosc=$nowaIlosc WHERE id=$idwpis");
			return true;
		}
	
	}
	
	public static function usunLek($idwpis) {
		$query = "DELETE FROM leki_apteczka WHERE id=$idwpis";
// 		try {
// 			DB::getConnection()->beginTransaction();
// 			$q = DB::getConnection()->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			
// 		}
		return DB::getConnection()->query($query);
	}
	
	public static function lekiBliskTermin($apteczkaID) {
		$sql = "SELECT * FROM leki_apteczka 
				LEFT JOIN leki_specyfikacja ON leki_apteczka.id_lek = leki_specyfikacja.idleki 
				LEFT JOIN users ON leki_apteczka.id_uzytkownik = users.idkonta 
				WHERE id_apteczka = $apteczkaID AND DATE(data_przeterminowania) < DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ORDER BY data_przeterminowania ASC";
// 		if (!isset()
		return DB::getConnection()->query($sql)->fetchAll();
	}
	
	
	public static function dodajApteczke($nazwa) {
		return DB::getConnection()->query("INSERT INTO apteczki VALUE(null, '$nazwa')");
	}
}
?>