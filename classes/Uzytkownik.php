<?php 

class Uzytkownik
{
	private $id;
	private $email;
	private $imie;
	private $nazwisko;
	private $haslo;
	private $admin;
	
	public function __construct($id, $email, $imie, $nazwisko, $haslo, $admin) {
		$this->id = $id;
		$this->email = $email;
		$this->imie = $imie;
		$this->nazwisko = $nazwisko;
		$this->haslo = $haslo;
		$this->admin = $admin;
	}
	
	public function imie(){
		return $this->imie;
	}
	
	public function nazwisko(){
		return $this->nazwisko;
	}
	
	public function email(){
		return $this->email;
	}
	
	public function haslo(){
		return $this->haslo;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function admin(){
		return $this->admin;
	}
}


?>