<?php

class Question {
	private $questionText;
	private $altA;
	private $altB;
	private $altC;
	private $altD;
	private $answer;
	private $answerText;
	private $sourceLink;
	private $sourceText;
	
	
	public function __construct($questionText, $altA, $altB, $altC, $altD, $answer, $answerText, $sourceLink, $sourceText) {
				$this->questionText = $questionText;
				$this->altA = $altA;
				$this->altB = $altB;
				$this->altC = $altC;
				$this->altD = $altD;
				$this->answer = $answer;
				$this->answerText = $answerText;
				$this->sourceLink = $sourceLink;
				$this->sourceText = $sourceText;
		}
		
		public function getQuestionText(){
			return $this->questionText;
		}
		
		public function getAlternative($number){
			if($number == 1){
				return $this->altA;
			}elseif($number == 2){
				return $this->altB;
			}elseif($number == 3){
				return $this->altC;
			}elseif($number == 4){
				return $this->altD;
			}
		}
		
		public function getAnswer(){
			return $this->answer;
		}
		
		public function getAnswerText(){
			return $this->answerText;
		}
		
		public function getSourceLink(){
			return $this->sourceLink;
		}
		
		public function getSourceText(){
			return $this->sourceText;
		}
}
