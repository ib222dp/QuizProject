<?php

class User {
	private $lastName;
	private $firstName;
	private $age;
	private $homeTown;
	private $occupation;
	
	public function __construct($lastName, $firstName, $age, $homeTown, $occupation) {
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->age = $age;
		$this->homeTown = $homeTown;
		$this->occupation = $occupation;
	}
	
	public function getLastName() {
		return $this->lastName;
	}
	
	public function getFirstName () {
		return $this->firstName;
	}
	
	public function getAge () {
		return $this->age;
	}
	
	public function getHomeTown () {
		return $this->homeTown;
	}
	
	public function getOccupation () {
		return $this->occupation;
	}
}
