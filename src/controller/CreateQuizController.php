<?php

require_once("src/model/CreateQuizModel.php");
require_once("src/view/CreateQuizView.php");


class CreateQuizController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new CreateQuizModel();
		$this->view = new CreateQuizView($this->model);
	}
	
	public function start(){
		if($this->view->userPressedSubmitQuiz()){
			$questionArray = $this->view->getQuestionArray();
			$questionValResult = $this->model->validateQuestions($questionArray);
			$questionsAreValid = $questionValResult[1];

			if($questionsAreValid){
				$category = $this->view->getCategory();
				$title = $this->view->getTitle();
				$catAndTitleValResult = $this->model->validateInput($category, $title);
				$catAndTitleValid = $catAndTitleValResult[1];
				
				if($catAndTitleValid){
					$objQuestionArray = $this->model->getObjQuestionArray($questionArray);
					$string = $this->model->createQuiz($this->view->getCategoriesArray(), $this->view->getAlternativesArray(), 
														$category, $title, $objQuestionArray);
					$ret = $this->view->showValPage($string);
				}else{
					$ret = $this->view->showValPage($catAndTitleValResult[0]);
				}
			}else{
				$ret = $this->view->showValPage($questionValResult[0]);
			}
		}else{
			$ret = $this->view->showCreateQuizPage();
		}
		return $ret;
	}
}
