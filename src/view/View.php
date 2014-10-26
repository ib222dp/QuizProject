<?php

abstract class View {
	protected $loginMenu;
	protected static $createQuiz = "create";
	protected static $logoutButton = "logoutButton";

	//Konstruktor
	public function __construct() {
		$this->loginMenu = "<div id='loginmenu'>
								<ul>
									<li><a href='index.php'>Profil</a></li>
									<li><a href='index.php?" . self::$createQuiz . "'>Skapa quiz</a></li>
								</ul>
							</div>
							<form action='index.php' method='post' id='logoutform'>
								<button type='submit' class='formbutton' name='" . self::$logoutButton . "'>Logga ut</button>
							</form>";
	}
	
	//Kontrollerar om användaren klickat på "Skapa quiz"
	public function userPressedCreateQuiz() {
		if(array_key_exists(self::$createQuiz, $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på "Logga ut"
	public function userPressedLogout() {
		if(isset($_POST[self::$logoutButton])){
			return true;
		}else{
			return false;
		}
	}
	
	//Hämtar användarens IP-address och webbläsare
	public function getServerInfo(){
		$aip = $_SERVER["REMOTE_ADDR"];
		$bip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$agent = $_SERVER["HTTP_USER_AGENT"];
		return array($aip, $bip, $agent); 
	}
}
