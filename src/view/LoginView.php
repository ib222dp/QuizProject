<?php

require_once("src/view/View.php");

class LoginView extends View {
	private $model;
	private $regLink;
	private $loginForm;
	private $text;
	
	private static $register = "register";
	private static $userName = "userName";
	private static $password = "password";
	private static $loginButton = "loginButton";
	
	//Konstruktor
	public function __construct(LoginModel $model) {
		$this->model = $model;
		$this->regLink = 		"<div id='logon'>
									<ul>
										<li><a href='index.php?" . self::$register . "'>Skapa konto</a></li>
									</ul>
								</div>";
		$this->loginForm =		"<div id='formlogon'>
									<form action='index.php' method='post' id='loginform'>
										<div id='fieldsetlogon'>
											<fieldset>
												<legend>Logga in</legend>
												<label for='userName'>
													Användarnamn:</label>
												<input class='textbox' type='text' id='userName' name='" . self::$userName . "'
												value='" . htmlspecialchars($_POST[self::$userName]) . "'/>
												<br />
												<label for='password'>
													Lösenord:</label>
												<input class='textbox' type='password' id='password' name='" . self::$password . "' />
												<br />
											</fieldset>
										</div>
										<button type='submit' class='formbutton' name='" . self::$loginButton . "'>Logga in</button>
									</form>
								</div>";
		$this->text =		"<h2>Välkommen till Quiz.se!</h2>
							<p>Du kan sätta igång direkt med att spela quiz genom att välja en kategori i menyn
							till vänster, eller så kan du <a href='index.php?" . self::$register . "'>skapa ett konto</a>. När du
							har ett konto kan du till exempel skapa egna quiz och en egen profilsida.</p>";
	}
	
	public function userClickedRegister() {
		if (array_key_exists(self::$register, $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	//Visar Login-sida
	public function showLoginPage() {
		$header =	$this->regLink . $this->loginForm;
		$content =	"<div id='contentheight'>
						<div id='starttext'>"
							. $this->text .
						"</div>
					</div>";
		return array($header, $content);
	}

	//Visar meddelande om användarnamn och/eller lösenord saknas eller är felaktigt
	public function showValidationPage($string){
		$header =	$this->regLink . $this->loginForm;
		$content =	"<div id='contentheight'>
						<div id='starttext'>
							<h1>" . $string . "</h1>"
							. $this->text . 
						"</div>
					</div>";
		return array($header, $content);
	}
	//Hämtar användarnamn
	public function getUserName(){
		if(isset($_POST[self::$userName])){
			$userName = filter_var(trim($_POST[self::$userName]), FILTER_SANITIZE_STRING);
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
	//Kontrollerar om användaren klickat på "Logga in"
	public function userPressedLogon() {
		if(isset($_POST[self::$loginButton])){
			return true;
		}else{
			return false;
		}
	}
}
