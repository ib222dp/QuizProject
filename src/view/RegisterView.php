<?php

class RegisterView {
	private $model;
	private $loginLink;
	private $form;
	private static $userName = "userName";
	private static $password = "password";
	private static $repPassword = "repPassword";
	private static $registerButton = "registerButton";

	public function __construct(RegisterModel $model){
		
		$this->model = $model;
		
		$this->loginLink =	"<div id='logon'>
								<ul>
									<li><a href='index.php'>Logga in</a></li>
								</ul>
							</div>";

		$this->form =		"<div id='form'>
								<form action='index.php?"  . http_build_query($_GET) . "' method='post' id='regform'>
									<div id='fieldsetcreate'>
										<fieldset>
											<legend>SKAPA KONTO</legend>
											<label for='userName'>
												Användarnamn:</label>
											<input class='textbox' type='text' id='userName' name='" . self::$userName . "'
											value='" . htmlspecialchars($_POST[self::$userName]) . "'/>
											<br />
											<label for='password'>
												Lösenord:</label>
											<input class='textbox' type='password' id='password' name='" . self::$password . "' />
											<br />
											<label for='repPassword'>
												Bekräfta lösenord:</label>
											<input class='textbox' type='password' id='repPassword' name='" . self::$repPassword . "' />
											<br />
										</fieldset>
									</div>
									<button type='submit' class='formbutton' name='" . self::$registerButton . "'>Skicka</button>
								</form>
							</div>";
	}
	
	//Kontrollerar om användaren klickat på "Registrera"
	public function userPressedRegister(){
		if(isset($_POST[self::$registerButton])){
			return true;
		}else{
			return false;
		}
	}
	//Hämtar användarnamn
	public function getUsername(){
		if(isset($_POST[self::$userName])){
			$userName = $_POST[self::$userName];
			return $userName;
		}else{
			exit();
		}
	}
	//Hämtar lösenord
	public function getPassword(){
		if(isset($_POST[self::$password])){
			$password = filter_var(trim($_POST[self::$password]), FILTER_SANITIZE_STRING);
			return $password;
		}else{
			exit();
		}
	}
	//Hämtar repeterat lösenord
	public function getRepeatedPassword(){
		if(isset($_POST[self::$repPassword])){
			$repPassword = filter_var(trim($_POST[self::$repPassword]), FILTER_SANITIZE_STRING);
			return $repPassword;
		}else{
			exit();
		}
	}
	//Visar registreringsformulär utan valideringsmeddelande
	public function showPage(){
		$content = "<div id='contentheight'>" . $this->form . "</div>";
		$ret = array($this->loginLink, $content);
		return $ret;
	}
	//Visar registreringsformulär med valideringsmeddelande
	public function showValidationPage($string){
		$content = "<div id='contentheight'><p>" . $string . "</p>" . $this->form . "</div>";
		$ret = array($this->loginLink, $content);
		return $ret;
	}
}
