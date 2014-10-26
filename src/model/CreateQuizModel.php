<?php

require_once("src/model/Question.php");

class CreateQuizModel {
	
	public function __construct() {
	}
	
	public function getFileNames($category){
		$file = "XML/" . $category . ".xml";
		$quizzes = simplexml_load_file($file);
		$fileNames = array();
		foreach($quizzes as $quiz){
			array_push($fileNames, $quiz["url"]);
		}
		return $fileNames;
	}
	
	public function validateQuestions($questionArray){
		
		for($i = 0; $i < count($questionArray); $i++){
			for($j = 0; $j <= 8; $j++)  {
				if (empty($questionArray[$i][$j])){
					$emptyFields = true;
				}
			}
		}
		
		if($emptyFields){
			return array("NÅGOT FÄLT ÄR TOMT", false);
		}else{
			return array("", true);
		}
	}
	
	//(http://webdesign.about.com/od/beginningtutorials/f/html-file-names.htm)
	public function validateInput($category, $quizTitle){
		$titleLength = mb_strlen($quizTitle, "utf8");
		
		$quizTitleNoWSpace = preg_replace("/\s+/", "", $quizTitle);
		$filteredTitle = filter_var($quizTitleNoWSpace, FILTER_SANITIZE_URL);
		$fileName = "../slutuppgift/" . $category . "/" . strtolower($filteredTitle) . ".html";
		
		if(empty($category)){
			$string = "VÄLJ KATEGORI";
		}elseif(empty($quizTitle)){
			$string = "TITEL SAKNAS";
		}elseif($titleLength > 30){
			$string = "TITELN ÄR FÖR LÅNG. MAX 30 TECKEN";
			//(http://stackoverflow.com/questions/6263690/first-letter-is-number-in-string)
		}elseif(strlen($quizTitle) > 0 && is_numeric($quizTitle[0]) || strlen($quizTitle) > 0 && $quizTitle[0] == "_"){
			$string = "TITELN MÅSTE BÖRJA MED EN BOKSTAV";
		}elseif(in_array($fileName, $this->getFileNames($category))){
			$string = "TITELN FINNS REDAN. VÄLJ EN ANNAN TITEL";
		}else{
			return array("", true);
		}
		return array($string, false);
	}

	public function getObjQuestionArray($questionArray){
		$newQuestionArray = array();
		for($i = 0; $i < count($questionArray); $i++){
			$question = new Question($questionArray[$i][0], $questionArray[$i][1], $questionArray[$i][2], $questionArray[$i][3],
				$questionArray[$i][4], $questionArray[$i][5], $questionArray[$i][6], $questionArray[$i][7], $questionArray[$i][8]);
			array_push($newQuestionArray, $question);
		}
		return $newQuestionArray;
	}
	
	public function createHTMLPage($categoriesArray, $category, $quizTitle, $quizNumber){
		//(http://php.net/manual/en/domdocument.savehtmlfile.php)
		//(http://php.net/manual/en/function.copy.php)
		//(http://stackoverflow.com/questions/3386882/php-domdocument-insertbefore-how-to-make-it-work)
		
		$file = "slutuppgift/category/quiztemplate.html";
		
		$newFile = "slutuppgift/" . $category . "/" . strtolower($quizTitle) . ".html";

		copy($file, $newFile);
		//(http://us.php.net/manual/en/domdocument.getelementbyid.php)
		//(http://stackoverflow.com/questions/8144061/using-php-to-get-dom-element)
		//(http://stackoverflow.com/questions/9149180/domdocumentloadhtml-error)
		
		$doc = new DOMDocument("4.01", "utf-8");
		$doc->validateOnParse = true;
		libxml_use_internal_errors(true);
		$doc->loadHTMLFile($newFile);
		libxml_use_internal_errors(false);
		
		$content = $doc->getElementById("content");
		$content->setAttribute("class", $category);
		
		$quiz =  $doc->getElementById("quiz");
		$quiz->setAttribute("class", $quizNumber);
		
		$header1 = $doc->createElement("h1");
		$headerText = $doc->createTextNode(strtoupper($categoriesArray[$category]));
		$header1->appendChild($headerText);
		$items = $quiz->getElementsByTagName("div");
		$items->item(0)->parentNode->insertBefore($header1, $items->item(0));
		
		$header2 = $doc->createElement("h2");
		$header2Text = $doc->createTextNode(strtoupper($quizTitle));
		$header2->appendChild($header2Text);
		$items = $quiz->getElementsByTagName("div");
		$items->item(0)->parentNode->insertBefore($header2, $items->item(0));
		
		$quizMenu = $doc->getElementById("quizmenu");
		$linkItems = $quizMenu->getElementsByTagName("a");
		$linkItems->item(0)->setAttribute("href", strtolower($quizTitle) . ".html");
		
		$doc->saveHTMLFile($newFile);
	}
	
	public function createQuiz($categoriesArray, $alternativesArray, $category, $quizTitle, $questionArray){
		
		//Laddar XML-filen
		$file = "XML/" . $category . ".xml";
		$quizzes = simplexml_load_file($file);
		
		$year = strftime("%Y");
		$month = strftime("%m");
		$day = strftime("%d");
		$time = ($year . "-" . $month . "-" . $day);
		
		$quiz = $quizzes->addChild("quiz");
		$quiz->addAttribute("name", strtoupper($quizTitle));
		
		//(http://stackoverflow.com/questions/1279774/to-strip-whitespaces-inside-a-variable-in-php)
		$quizTitleNoWSpace = preg_replace("/\s+/", "", $quizTitle);
		$filteredTitle = filter_var($quizTitleNoWSpace, FILTER_SANITIZE_URL);
		
		
		$quiz->addAttribute("url", "../slutuppgift/" . $category . "/" . strtolower($filteredTitle) . ".html");
		$quiz->addAttribute("created", $time);
		
		$quizNumber = ($quizzes->count() - 1);
		$quiz->addChild("quiznumber", $quizNumber);
		
		$this->createHTMLPage($categoriesArray, $category, $filteredTitle, $quizNumber);

		$questions = $quiz->addChild("questions");
		
		$questionArrayLength = count($questionArray);
		
		for($i = 0; $i < $questionArrayLength; $i++){
			$question = $questions->addChild("question");
			$question->addChild("questionno", $i+1);
			$question->addChild("questiontext", $questionArray[$i]->getQuestionText());
			$questionAlternatives = $question->addChild("questionalternatives");
			$altArray = array();
			for($j = 1; $j <= 4; $j++){
				$alt = $questionAlternatives->addChild("questionalternative", $questionArray[$i]->getAlternative($j));
				array_push($altArray, $alt);
			}
			if($questionArray[$i]->getAnswer() == $alternativesArray[0]){
				$altArray[0]->addAttribute("id", "1");
			}elseif($questionArray[$i]->getAnswer() == $alternativesArray[1]){
				$altArray[1]->addAttribute("id", "1");
			}elseif($questionArray[$i]->getAnswer() == $alternativesArray[2]){
				$altArray[2]->addAttribute("id", "1");
			}elseif($questionArray[$i]->getAnswer() == $alternativesArray[3]){
				$altArray[3]->addAttribute("id", "1");
			}
			
			//(http://stackoverflow.com/questions/10909372/checking-if-an-object-attribute-is-set-simplexml)
			$wrongAltArray = array();
			$arrayLength = count($altArray);
			for($k = 0; $k < $arrayLength; $k++){
				$attr = $altArray[$k]->attributes();
				if(!isset($attr["id"])) {
					array_push($wrongAltArray, $altArray[$k]);
				}
			}
			
			$newArrayLength = count($wrongAltArray);
			for($l = 0; $l < $newArrayLength; $l++){
				$wrongAltArray[$l]->addAttribute("id", $l+2);
			}
			
			$answer = $question->addChild("answer");
			$answer->addChild("answercomment", $questionArray[$i]->getAnswerText());
			$answer->addChild("sourcelink", $questionArray[$i]->getSourceLink());
			$answer->addChild("sourcetext", $questionArray[$i]->getSourceText());	
		} 
		
		$quiz->addChild("timesplayed", "0");
		
		$quiz->addChild("times0correct", "0");
		$timesXCorrect = $quiz->addChild("timesxcorrectcount");
		for($i = 0; $i < $questionArrayLength; $i++){
			$timesXCorrect->addChild("timesxcorrect", "0");
		}
		
		$ratings = $quiz->addChild("ratings");
		for($i = 0; $i <= 4; $i++){
			$ratings->addChild("rating", "0");
		}
		
		$quiz->addChild("comments");

		//Sparar XML-filen
		$quizzes->saveXML($file);
		
		return("Quizzet har skapats. Klicka på rätt kategori i menyn till vänster och välj ditt quiz i quiz-listan.");
	}
}
