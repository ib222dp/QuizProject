<?php

require_once("src/model/UserRepository.php");

class RegisterModel {
	private $userRepository;
	
	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	//Validerar användaruppgifter. Returnerar valideringsmeddelande, samt true om valideringen går igenom, annars false
	public function validateInput($userName, $password, $repeatedPassword) {
		$userNameLength = mb_strlen($userName, "utf8");
		$passwordLength = mb_strlen($password, "utf8");
		$repPasswordLength = mb_strlen($repeatedPassword, "utf8");
		
		if ($userNameLength < 3 && $passwordLength < 6 && $repPasswordLength < 6){
			$string = "Användarnamnet har för få tecken. Minst 3 tecken";
		}elseif ($userNameLength >= 3 && $passwordLength < 6 || $userNameLength >= 3  && $repPasswordLength < 6){
			$string = "Lösenorden har för få tecken. Minst 6 tecken";
		}elseif($userNameLength < 3 && $passwordLength >= 6 || $userNameLength < 3 && $repPasswordLength >= 6){
			$string = "Användarnamnet har för få tecken. Minst 3 tecken";
		}elseif(strcmp($password, $repeatedPassword) !== 0){
			$string = "Lösenorden matchar inte";
		}elseif (in_array($userName, $this->userRepository->getUserNames())) {
			$string = "Användarnamnet är redan upptaget";
			//(http://stackoverflow.com/questions/878715/checking-string-for-illegal-characters-using-regular-expression)
		}elseif (preg_match("/[\W]/i", $userName)){
			$string = "Användarnamnet innehåller ogiltiga tecken";
		}else{
			return array("", true);
		}
		return array($string, false);
	}
	
	public function saveUser($userName, $password) {
		$ret = $this->userRepository->saveUser($userName, $password);
		return $ret;
	}
}
