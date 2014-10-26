<?php

require_once("src/view/View.php");
require_once("src/model/CreateQuizModel.php");

class CreateQuizView extends View {
	private $model;
	private $form;
	private $button;
	private $categoriesArray;
	private $alternativesArray;  
	private static $category = "category";
	private static $title = "title";
	const AMOUNT_QUESTIONS = 2;
	private static $questionText = "questionText";
	private static $answerA = "answerA";
	private static $answerB = "answerB";
	private static $answerC = "answerC";
	private static $answerD = "answerD";
	private static $answer = "answer";
	private static $answerText = "answerText";
	private static $sourceText = "sourceText";
	private static $sourceLink = "sourceLink";
	private static $submitQuizButton = "submitQuizButton";
	
	//Konstruktor
	public function __construct(CreateQuizModel $model) {
		
		parent::__construct();
		
		$this->model = $model;
		
		$this->categoriesArray = array("politics"=>"Politik", "music"=>"Musik");
		
		$this->alternativesArray = array("A", "B", "C", "D");
		
		$this->form .=	"<div id='formquiz'>
							<form action='index.php?" . http_build_query($_GET) . "' method='post' id='createquizform'>
								<div id='fieldsetquiz'>
									<fieldset>
										<legend>SKAPA QUIZ</legend>
										<label for='category'>Kategori:</label>
											<select class='select' id='category' name='" . self::$category . "'>
												<option value=''>Välj kategori</option>";
		
		//(http://www.dreamincode.net/forums/topic/48477-how-to-get-the-select-value-from-the-drop-down-list/)
		foreach($this->categoriesArray as $key=>$value){
			if($_POST[self::$category] == $key){
				$this->form .= "<option selected value='" . $key . "'>" . $value . "</option>";
			}else{
				$this->form .= "<option value='" . $key . "'>" . $value. "</option>";
			}
		}  
		
		$this->form	.=						"</select>
										<br />
										<label for='title'>Titel:</label>
											<input class='textbox' type='text' id='title' name='" . self::$title . "' 
											value='" . filter_var(trim($_POST[self::$title]), FILTER_SANITIZE_STRING) . "' />
										<br />
									</fieldset>";
		
		for($i = 0; $i < self::AMOUNT_QUESTIONS; $i++){
			$this->form .=			"<div id='fieldsetquestion'>
									<fieldset>
										<legend>Fråga " . ($i+1) . "</legend>
										<label for='question'>Fråga " . ($i+1) . ":</label>
											<textarea class='textarea' id='question' name='" . self::$questionText  . "[]' rows='5' cols='28'>"
				. filter_var(trim($_POST[self::$questionText][$i]), FILTER_SANITIZE_STRING) . "</textarea>
										<br />
										<label for='answerA'>Svarsalternativ A:</label>
											<input class='textbox' type='text' id='answerA' name='" . self::$answerA . "[]' 
											value='" . filter_var(trim($_POST[self::$answerA][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
										<label for='answerB'>Svarsalternativ B:</label>
											<input class='textbox' type='text' id='answerB' name='" . self::$answerB . "[]' 
											value='" . filter_var(trim($_POST[self::$answerB][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
										<label for='answerC'>Svarsalternativ C:</label>
											<input class='textbox' type='text' id='answerC' name='" . self::$answerC . "[]' 
											value='" . filter_var(trim($_POST[self::$answerC][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
										<label for='answerD'>Svarsalternativ D:</label>
											<input class='textbox' type='text' id='answerD' name='" . self::$answerD . "[]' 
											value='" . filter_var(trim($_POST[self::$answerD][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
										<label for='answer'>Rätt svar:</label>
											<select class='select' id='answer' name='" . self::$answer . "[]'>
												<option value=''>Välj det rätta svaret</option>";
			
			for($j = 0; $j < count($this->alternativesArray); $j++){
				if($_POST[self::$answer][$i] == $this->alternativesArray[$j]){
					$this->form .= "<option selected value='" . $this->alternativesArray[$j] . "'>" . $this->alternativesArray[$j] . "</option>";
				}else{
					$this->form .= "<option value='" . $this->alternativesArray[$j] . "'>" . $this->alternativesArray[$j]. "</option>";
				}
			}
			
			$this->form .=					"</select>
										<br />
										<label for='answerText'>Svarstext:</label>
											<textarea class='textarea' id='answerText' name='" . self::$answerText . "[]' rows='5' cols='28'>" 
				. filter_var(trim($_POST[self::$answerText][$i]), FILTER_SANITIZE_STRING) . "</textarea>
										<br />
										<label for='source'>Källa:</label>
											<input class='textbox' type='text' id='source' name='" . self::$sourceText . "[]' 
											value='" . filter_var(trim($_POST[self::$sourceText][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
										<label for='sourceLink'>Länk till källa:</label>
											<input class='textbox' type='url' id='sourceLink' name='" . self::$sourceLink . "[]' 
											value='" . filter_var(trim($_POST[self::$sourceLink][$i]), FILTER_SANITIZE_STRING) . "' />
										<br />
									</fieldset>
								</div>";
		}
		$this->button	=		"</div>
							<button type='submit' class='formbutton' name='" . self::$submitQuizButton . "'>Skicka</button>
						</form>
					</div>";	
	}
	
	public function showCreateQuizPage(){
		$content = "<div id='content'>" . $this->form . $this->button . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function showValPage($string){
		$content = "<div id='content'>" . "<p>" . $string . "</p>" . $this->form . $this->button . "</div>";
		return array($this->loginMenu, $content);
	}
	
	public function userPressedSubmitQuiz(){
		if(isset($_POST[self::$submitQuizButton])){
			return true;
		}else{
			return false;
		}
	}
	
	public function getCategory(){
		if(isset($_POST[self::$category])){
			$category = $_POST[self::$category];
			return $category;
		}else{
			exit();
		}
	}
	
	public function getTitle(){
		if(isset($_POST[self::$title])){
			$title = filter_var(trim($_POST[self::$title]), FILTER_SANITIZE_STRING);
			return $title;
		}else{
			exit();
		}
	}
	
	public function getQuestionArray(){
		$questionArray = array();
		for($i = 0; $i < self::AMOUNT_QUESTIONS; $i++){
			$questionText = filter_var(trim($_POST[self::$questionText][$i]), FILTER_SANITIZE_STRING);
			$alt1a = filter_var(trim($_POST[self::$answerA][$i]), FILTER_SANITIZE_STRING);
			$alt1b = filter_var(trim($_POST[self::$answerB][$i]), FILTER_SANITIZE_STRING);
			$alt1c = filter_var(trim($_POST[self::$answerC][$i]), FILTER_SANITIZE_STRING);
			$alt1d = filter_var(trim($_POST[self::$answerD][$i]), FILTER_SANITIZE_STRING);
			$answer = filter_var(trim($_POST[self::$answer][$i]), FILTER_SANITIZE_STRING);
			$answerText = filter_var(trim($_POST[self::$answerText][$i]), FILTER_SANITIZE_STRING);
			$sourceText = filter_var(trim($_POST[self::$sourceText][$i]), FILTER_SANITIZE_STRING);
			$sourceLink = filter_var(trim($_POST[self::$sourceLink][$i]), FILTER_SANITIZE_STRING);
			$question = array();
			array_push($question, $questionText, $alt1a, $alt1b, $alt1c, $alt1d, $answer, $answerText, $sourceLink, $sourceText);
			array_push($questionArray, $question);
		}
		return $questionArray;
	}
	
	//(http://stackoverflow.com/questions/11184469/php-use-array-as-class-constant)
	public function getAlternativesArray(){
		return $this->alternativesArray;
	}
	
	public function getCategoriesArray(){
		return $this->categoriesArray;
	}
}
