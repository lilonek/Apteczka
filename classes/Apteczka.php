<?php
class Apteczka
{
	private $id;
	private $nazwa;
	
	public function __construct($id, $nazwa) {
		$this->id = $id;
		$this->nazwa = $nazwa;
	}
	
	function id() {
		return $this->id;
	}
	
	function nazwa() {
		return $this->nazwa;
	}
}
?>