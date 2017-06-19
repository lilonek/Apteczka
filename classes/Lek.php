<?php 

class Lek
{
	private $id;

	private $nazwaLeku;
	private $subst_czynn;
	private $ean;
	private $op_zb;
	private $ilosc;
	
	public function __construct($id, $nazwaLeku) {
		$this->id = $id;
		$this->nazwaLeku = $nazwaLeku;
		
	}
	
	public function id(){
		return $this->id;
	}

	
	public function nazwaLeku(){
		return $this->nazwaLeku;
	}
	
	public function subst_czynn(){
		return $this->subst_czynn;
	}
	
	public function ean(){
		return $this->ean;
	}
	
	public function op_zb(){
		return $this->op_zb;
	}
	
	public function ilosc(){
		return $this->ilosc;
	}
	
	public function ustawIlosc($ilosc) {
		$this->ilosc = $ilosc;
	}
}