<?php 
session_save_path("/home/piegrp/klaudgg/public_html/SIwM");
session_start();
	
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