<?php

require_once("src/model/UserRepository.php");

class LoginModel {
	private $userRepository;
	
	//Konstruktor
	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	//Kontrollerar att användarens IP-adress och webbläsare är samma som de som är lagrade i sessionsvariabeln "ident"
	//(http://stackoverflow.com/questions/22880/what-is-the-best-way-to-prevent-session-hijacking) 
	public function userIsLoggedOn($serverInfo) {
		$aip = $serverInfo[0];
		$bip = $serverInfo[1];
		$agent = $serverInfo[2];
		
		$ident = hash("sha256", $aip . $bip . $agent);
		
		if ($ident != $_SESSION["ident"]){
			return false;
		}else{
			return true;
		}
	}
	
	//Förstör sessionen (http://php.net/manual/en/function.session-destroy.php)
	public function logoutUser(){
		session_start();
		
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}
		session_destroy();
	}
	
	//Kontrollerar om "username" och/eller "password är tomma
	public function validateInput($userName, $password){
		if(empty($userName) && empty($password) || empty($userName)){
			return array(false, "ANVÄNDARNAMN SAKNAS");
		}elseif(empty($password)){
			return array(false, "LÖSENORD SAKNAS");
		}else{
			return array(true, "");
		}
	}
	
	//Kontrollerar om angivna uppgifter är korrekta
	public function validateUser($userName, $password) {
		
		//Kontrollerar angivna uppgifter mot databasen
		$valResult = $this->userRepository->validateUser($userName, $password);

			if($valResult == true){
				$_SESSION["userName"] = $userName;
				return array(true, "");
			}else{
				return array(false, "ANVÄNDARNAMN OCH/ELLER LÖSENORD FELAKTIGT");
			}
	}
	
	//Lagrar användarens IP-adress och webbläsare i sessionsvariabeln "ident"
	public function setServerInfo($serverInfo){
		$aip = $serverInfo[0];
		$bip = $serverInfo[1];
		$agent = $serverInfo[2];
		$_SESSION["ident"] = hash("sha256", $aip . $bip . $agent);
	}
}
