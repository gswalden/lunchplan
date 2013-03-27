<?php
require_once('classes/RandID.class.php');

class Event {
	
	protected $date;
	protected $db;
	protected $endTime;
	protected $flexible;
	protected $id;
	protected $groups;
	protected $location;
	protected $persons;
	protected $startTime;

	public function __construct($id = 0, $db) {
		$this->db = $db;
		if ($id == 0):
			$id = new RandID($db);
			$this->id = $id->getRandID();
		else:
			$this->id = $id;
		endif;
	}

	public function getDate() {
		return $this->date;
	}

	public function getEndTime() {
		return $this->endTime;
	}

	public function getFlexible() {
		return $this->flexible;
	}

	public function getGroups() {
		return $this->groups;
	}

	public function getID() {
		return $this->id;
	}

	public function getLocation() {
		return $this->location;
	}

	public function getPersons() {
		return $this->persons;
	}

	public function getStartTime() {
		return $this->startTime;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function setFlexible($flex = false) {
		// True if the times ARE flexible
		$this->flexible = $flex;
	}

	public function setGroups($groups) {
		// $groups should be array
		$this->groups = $groups;
	}

	public function setLocation($loc) {
		$this->location = $loc;
	}

	public function setPersons($persons) {
		// $persons should be array
		$this->persons = $persons;
	}

	public function setStartAndEnd($start, $end = 0) {
		$this->startTime = $start;
		$this->endTime = $end;
	}
}