<?php
require_once('classes/RandID.class.php');

class Person {
	
	protected $db;
	protected $id;
	protected $groups;
	protected $name;

	public function __construct($id = 0, $db) {
		$this->db = $db;
		if ($id == 0):
			$id = new RandID($db);
			$this->id = $id->getRandID();
		else:
			$this->id = $id;
		endif;
	}
	
	public function getGroups() {
		return $this->groups;
	}

	public function getName() {
		return $this->name;
	}

	public function setGroups($groups) {
		$this->groups = $groups;
	}

	public function setName($name) {
		$this->name = $name;
	}
}