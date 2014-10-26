<?php

require_once("src/view/View.php");

class DeleteAccountView extends View {
	private $form;
	private static $submitButton = "submitButton";
	private static $delChoice = "delChoice";
	private static $yes = "JA";
	private static $no = "NEJ";

	//Konstruktor
	public function __construct() {
		
		parent::__construct();
		
		$this->form =			"<div id='rating'>
									<form action='index.php?" . http_build_query($_GET) . "' method='post' id='ratingform'>
										<div id='fieldsetrating'>
											<fieldset>
												<legend>Är du säker på att du vill radera ditt konto?</legend>
												<div id='radiobuttons'>
													<input class='1button' type='radio' name='" . self::$delChoice . "' 
													value='" . self::$yes . "'/>JA
													<br />
													<input class='1button' type='radio' name='" . self::$delChoice . "' 
													value='" . self::$no . "'/>NEJ
												</div>
											</fieldset>
										</div>
										<button type='submit' class='formbutton' name='" . self::$submitButton . "'>Skicka</button>
									</form>
								</div>";
	}
	
	public function showConfirmPage(){
		$content = "<div id='contentheight'>" . $this->form . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function showFeedbackPage($string){
		$content = "<div id='contentheight'><h1>" . $string . "</h1>" . $this->form . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function userPressedSubmit () {
		if(isset($_POST[self::$submitButton])){
			return true;
		}else{
			return false;
		}
	}
	
	public function userChoseYes(){
		if(isset($_POST[self::$delChoice])){	
			if($_POST[self::$delChoice] == self::$yes){
				return true;
			}else{
				return false;
			}
		}
	}
}
