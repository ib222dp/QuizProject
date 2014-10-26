<?php

require_once("src/view/View.php");

class EditProfileView extends View {
	private $form;
	private static $firstName = "firstName";
	private static $lastName = "lastName";
	private static $age = "age";
	private static $homeTown = "homeTown";
	private static $occupation = "occupation";
	private static $submitButton = "submit";
	
	//Konstruktor
	public function __construct() {
		
		parent::__construct();
		
		$this->form =			"<div id='form'>
									<form action='index.php?" . http_build_query($_GET) . "' method='post' id='editprofileform'>
										<div id='fieldsetedit'>
											<fieldset>
												<legend>SKAPA/REDIGERA PROFIL</legend>
												<label for='firstname'>Förnamn:</label>
													<input class='textbox' type='text' id='firstname' name='" . self::$firstName . "' 
													value='" . htmlspecialchars($_POST[self::$firstName]) . "'/>
												<br />
												<label for='lastname'>Efternamn:</label>
													<input class='textbox' type='text' id='lastname' name='" .self::$lastName . "'
													value='" . htmlspecialchars($_POST[self::$lastName]) . "'/>
												<br />
												<label for='age'>Ålder:</label>
													<input class='textbox' type='number' id='age' name='" . self::$age . "'
													value='" . htmlspecialchars($_POST[self::$age]) . "'/>
												<br />
												<label for='city'>Hemort:</label>
													<input class='textbox' type='text' id='city' name='" . self::$homeTown . "'
													value='" . htmlspecialchars($_POST[self::$homeTown]) . "'/>
												<br />
												<label for='occupation'>Sysselsättning:</label>
													<input class='textbox' type='text' id='occupation' name='" . self::$occupation . "'
													value='" . htmlspecialchars($_POST[self::$occupation]) . "'/>
												<br />
											</fieldset>
										</div>
										<button type='submit' class='formbutton' name='" . self::$submitButton . "'>Skicka</button>
									</form>
								</div>";
	}
	
	public function showEditProfilePage () {
		$content = "<div id='content'>" . $this->form . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function showValidationPage ($valMessage) {
		$content = "<div id='content'><h1>" . $valMessage . "</h1>" . $this->form . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function userClickedSubmit() {
		if(isset($_POST[self::$submitButton])){
			return true;
		}else{
			return false;
		}
	}
	
	public function getFirstName() {
		if(isset($_POST[self::$firstName])){
			$firstName = $_POST[self::$firstName];
			return $firstName;
		}else{
			exit();
		}
	}
	
	public function getLastName() {
		if(isset($_POST[self::$lastName])){
			$lastName = $_POST[self::$lastName];
			return $lastName;
		}else{
			exit();
		}
	}
	
	public function getAge() {
		if(isset($_POST[self::$age])){
			$age = $_POST[self::$age];
			return $age;
		}else{
			exit();
		}
	}
	
	public function getHomeTown() {
		if(isset($_POST[self::$homeTown])){
			$homeTown = $_POST[self::$homeTown];
			return $homeTown;
		}else{
			exit();
		}
	}
	
	public function getOccupation() {
		if(isset($_POST[self::$occupation])){
			$occupation = $_POST[self::$occupation];
			return $occupation;
		}else{
			exit();
		}
	}
}
