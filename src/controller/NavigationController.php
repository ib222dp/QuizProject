<?php

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/controller/LoginController.php");
require_once("src/controller/ProfileController.php");
require_once("src/controller/RegisterController.php");

class NavigationController {
	private $loginModel;
	private $loginView;
	private $loginController;

	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->loginView = new LoginView($this->loginModel);
		$this->loginController = new LoginController($this->loginModel, $this->loginView);
	}
	
	public function start() {
		//Hämtar användarens IP-address och webbläsare
		$serverInfo = $this->loginView->getServerInfo();
		
		if($this->loginModel->userIsLoggedOn($serverInfo)) {
			if($this->loginView->userPressedLogout()){
				$this->loginModel->logoutUser();
				$ret = $this->loginController->start();
			}else{
				$profileController = new ProfileController();
				$ret = $profileController->start();
			}
		}elseif($this->loginView->userClickedRegister()) {
			$registerController = new RegisterController();
			$ret = $registerController->start();
		}else{
			$ret = $this->loginController->start();
		}
		return $ret;
	}
}
