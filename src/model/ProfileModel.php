<?php

require_once("src/model/UserRepository.php");

class ProfileModel {
	private $userRepository;
	
	//Konstruktor
	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	//Returnerar det användarnamn som är lagrat i sessionsvariabeln "userName"
	public function getUserName(){
		$userName = $_SESSION["userName"];
		return $userName;
	}
	
	public function saveProfile($firstName, $lastName, $age, $homeTown, $occupation) {
		
		if(empty($firstName) || empty($lastName) || empty($age) || empty($homeTown) || empty($occupation)) {
			$string = "FYLL I ALLA FÄLT";
			//(http://stackoverflow.com/questions/878715/checking-string-for-illegal-characters-using-regular-expression)
		}elseif (preg_match("/[\W]/i", $firstName)){
			$string = "FÖRNAMN INNEHÅLLER OGILTIGA TECKEN";
		}elseif(preg_match("/[\W]/i", $lastName) ) {
			$string = "EFTERNAMN INNEHÅLLER OGILTIGA TECKEN";
		}elseif(preg_match("/[\W]/i", $homeTown) ){
			$string = "HEMORT INNEHÅLLER OGILTIGA TECKEN";
		}elseif(preg_match("/[\W]/i", $occupation)) {
			$string = "SYSSELSÄTTNING INNEHÅLLER OGILTIGA TECKEN";
		}else{
			if($this->userRepository->saveProfile($this->getUserName(), $firstName, $lastName, $age, $homeTown, $occupation)) {
				$string = "DIN PROFIL HAR UPPDATERATS";
			}else {
				$string = "UPPDATERINGEN MISSLYCKADES";
			}
		}
		return $string;
	}
	
	public function getUser () {
		$userName = $this->getUserName();
		$user = $this->userRepository->getUser($userName);
		return $user;
	}
	
	public function deleteUser() {
		$ret = $this->userRepository->deleteUser($this->getUserName());
		return $ret;
	}
}
