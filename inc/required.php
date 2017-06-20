<?php 
// error_reporting(E_ALL);
session_save_path("/home/piegrp/klaudgg/public_html/SIwM");
session_start();
	
require_once 'classes/Apteczka.php';
require_once 'classes/Lek.php';
require_once 'classes/Uzytkownik.php';
require_once 'classes/DB.php';
require_once 'classes/ApteczkaDB.php';
require_once 'classes/LekDB.php';
require_once 'classes/UzytkownikDB.php';

require_once 'conf/zmienne.php';
//require_once "inc/$lang/error_msg.php";
require_once "inc/$lang/teksty.php";
require_once 'inc/baza.php';	

require_once 'inc/nagl.php';

	
//£¹czenie z baz¹
DB::connect('mysql.agh.edu.pl', 'klaudgg', 'mPcSRXL8PzzQJRrd','klaudgg');
?>