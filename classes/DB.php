<?php 

class DB
{
	private static $connection = null;
	
	public static function connect($host, $username, $password, $database) {
		$dsn = "mysql:dbname=$database;host=$host";
		
		try {
			self::$connection = new PDO($dsn, $username, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
	
	
	public static function getConnection(){
		return self::$connection;
	}
}
?>