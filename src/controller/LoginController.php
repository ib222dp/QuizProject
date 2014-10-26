<?php

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/controller/ProfileController.php");

class LoginController {
	private $model;
	private $view;
	
	//Konstruktor
	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}

	public function start() {
		//Kontrollerar om användaren försöker logga in, visar annars login-sida	
		if($this->view->userPressedLogon()){
			$userName = $this->view->getUserName();
			$password = $this->view->getPassword();
			//Kontrollerar att "username" och "password" inte är tomma
			$inputValResult = $this->model->validateInput($userName, $password);
			
			if($inputValResult[0] == true){
				//Kontrollerar användarnamn och lösenord mot tabellen "UserData" i databasen
				$userValResult = $this->model->validateUser($userName, $password);
				
				if($userValResult[0] == true){
					$serverInfo = $this->view->getServerInfo();
					//Lagrar användarens IP-address och webbläsare i sessionsvariabeln "ident"
					$this->model->setServerInfo($serverInfo);
					$profileController = new ProfileController();
					$ret = $profileController->start();
					//Visar att användarnamn och/eller lösenord är felaktigt	
				}else{
					$ret = $this->view->showValidationPage($userValResult[1]);
				}
				//Visar att användarnamn och/eller lösenord saknas
			}else{
				$ret = $this->view->showValidationPage($inputValResult[1]);
			}
		}else{
			$ret = $this->view->showLoginPage();
		}
		return $ret;
	}		
}
