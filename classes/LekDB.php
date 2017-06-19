<?php 

class LekDB 
{
	public static function getLekById($id) {
		$row = DB::getConnection()->query("SELECT * FROM `leki_specyfikacja` WHERE idleki = $id")->fetch();
		return new Lek($row['idleki'], $row['nazwa'], $row['subs_czynn'], $row['ean'], $row['op_zb']);
	}

}