<?php 

class UzytkownikDB
{
	public static function uzytkownikByID($id){
		$row = DB::getConnection()->query("SELECT * FROM `users` WHERE idkonta = $id")->fetch();
		return new Uzytkownik($row['idkonta'], $row['email'], $row['imie'], $row['nazwisko'], $row['haslo'], $row['isAdmin']);
	}
	
}


?>