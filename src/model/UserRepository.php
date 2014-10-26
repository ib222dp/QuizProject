<?php

require_once("src/model/User.php");

class UserRepository {
	private $dbc;
	
	
	public function __construct() {
		$this->dbc =  new mysqli("HOST", "USERNAME", "PASSWORD", "DATABASENAME");
	}
	
	
	public function getUser ($userName) {
		if(mysqli_set_charset($this->dbc, "utf8")){
			$result = $this->dbc->query("SELECT ID FROM Users WHERE username='" . $userName . "'");
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$id = $row["ID"];
			$query = $this->dbc->query("SELECT * FROM UserInfo WHERE ID='" . $id . "'");
			$object = $query->fetch_array(MYSQLI_ASSOC);
			$user =  new User ($object["lastName"], $object["firstName"], $object["age"], $object["homeTown"], $object["occupation"]);
			return $user;
		}else {
			exit();
		}
	}
	
	//Kontrollerar om angivna uppgifter finns i tabellen "Users"
	//(https://www.daniweb.com/web-development/php/threads/181577/validate-user-login)
	public function validateUser($userName, $password){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escPassword = $this->dbc->real_escape_string($password);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$result = $this->dbc->query("SELECT * FROM Users WHERE username='" . $escUserName . "' AND password='" . base64_encode($escPassword) . "'");
			if(mysqli_num_rows($result) === 1){
				return true;
			}else{
				return false;
			}
		}else{
			exit();
		}
	}
	
	public function getUserNames(){
		$ret = array();
		$query = $this->dbc->query("SELECT username FROM Users");
		
		while ($row = $query->fetch_array(MYSQLI_ASSOC)){
			$ret[] = $row["username"];
		}
		return $ret;
	}
	
	public function saveUser($userName, $password){
		
		$escUserName = $this->dbc->real_escape_string($userName);
		$escPassword = $this->dbc->real_escape_string($password);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$query = $this->dbc->query("INSERT INTO Users (`ID`, `username`, `password`) VALUES (NULL, '" . $escUserName . "', '" . base64_encode($escPassword) . "')");
			if($query) {
				$id = $this->dbc->insert_id;
				$this->dbc->query("INSERT INTO UserInfo (`ID`) VALUES ('" . $id . "')");
				$ret = "Registreringen lyckades. <a href='index.php'>Logga in</a>";
			}else {
				$ret = "Registreringen misslyckades.";	
			}
		}else{
			$ret = "Registreringen misslyckades.";	
		}
		return $ret;
	}	
	
	public function saveProfile($userName, $firstName, $lastName, $age, $homeTown, $occupation){
		
		$escFirstName = $this->dbc->real_escape_string($firstName);
		$escLastName = $this->dbc->real_escape_string($lastName);
		$escAge = $this->dbc->real_escape_string($age);
		$escHomeTown = $this->dbc->real_escape_string($homeTown);
		$escOccupation = $this->dbc->real_escape_string($occupation);
		
		if(mysqli_set_charset($this->dbc, "utf8")){
			$result = $this->dbc->query("SELECT ID FROM Users WHERE username='" . $userName . "'");
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$id = $row["ID"];
			$query =	$this->dbc->query("UPDATE UserInfo SET `lastName`='" . $escLastName . "', `firstName`='" . $escFirstName .
						"', `age`='" .  $escAge . "', `homeTown`='" . $escHomeTown . "', `occupation`='" . $escOccupation . "' 
						WHERE ID='" . $id . "'");
			if($query){
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}	
	
	public function deleteUser($userName) {
		
			if(mysqli_set_charset($this->dbc, "utf8")){
			$query = $this->dbc->query("DELETE FROM Users WHERE username='" . $userName . "'");
			if($query) {
				$id = $this->dbc->insert_id;
				$this->dbc->query("DELETE FROM UserInfo WHERE ID='" . $id . "'");
				$ret = "Ditt konto har raderats";
			}else {
				$ret = "Något gick fel. Ditt konto har inte raderats.";
			}
		}else{
			$ret = "Något gick fel. Ditt konto har inte raderats.";
		}
		return $ret;
	}
}
