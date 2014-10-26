<?php

require_once("src/model/RegisterModel.php");
require_once("src/view/RegisterView.php");

class RegisterController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new RegisterModel();
		$this->view = new RegisterView($this->model);
	}

	public function start() {
		if ($this->view->userPressedRegister()) {
			$userName = $this->view->getUsername();
			$password = $this->view->getPassword();
			$repPassword = $this->view->getRepeatedPassword();
			$inputValResult = $this->model->validateInput($userName, $password, $repPassword);
			$inputIsValid = $inputValResult[1];
			
			if ($inputIsValid) {
				$string = $this->model->saveUser($userName, $password);
				$ret = $this->view->showValidationPage($string);
			}else{
				$ret = $this->view->showValidationPage($inputValResult[0]);
			}
		//Visar registreringsformulär om användaren inte klickat på "Registrera"-knappen	
		}else{
			$ret = $this->view->showPage();
		}
		return $ret;
	}
}
