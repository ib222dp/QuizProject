<?php

require_once("src/model/ProfileModel.php");
require_once("src/view/ProfileView.php");
require_once("src/view/EditProfileView.php");
require_once("src/view/DeleteAccountView.php");
require_once("src/controller/CreateQuizController.php");

class ProfileController {
	private $model;
	private $profileView;
	private $editProfileView;
	private $deleteAccountView;
	private $createQuizController;
	
	//Konstruktor
	public function __construct() {
		$this->model = new ProfileModel();
		$this->profileView = new ProfileView($this->model);
		$this->editProfileView = new EditProfileView();
		$this->deleteAccountView = new DeleteAccountView();
		$this->createQuizController = new CreateQuizController();
	}
	
	public function start() {
		
		if($this->profileView->UserClickedEditProfile()) {
			if($this->editProfileView->userClickedSubmit()){
				$string =	$this->model->saveProfile($this->editProfileView->getFirstName(), $this->editProfileView->getLastName(), 
					$this->editProfileView->getAge(), $this->editProfileView->getHomeTown(), $this->editProfileView->getOccupation());	
				$ret = $this->editProfileView->showValidationPage($string);
			}else {
				$ret = $this->editProfileView->showEditProfilePage();
			}
		}elseif($this->profileView->UserClickedDeleteAccount()){
			if($this->deleteAccountView->userPressedSubmit()){
				if($this->deleteAccountView->userChoseYes()){
					$ret = $this->deleteAccountView->showFeedbackPage($this->model->deleteUser());
				}else {
					$ret = $this->deleteAccountView->showFeedbackPage("DITT KONTO HAR INTE RADERATS");
				}
			}else {
				$ret = $this->deleteAccountView->showConfirmPage();
			}
		}elseif($this->profileView->userPressedCreateQuiz()){
			$ret = $this->createQuizController->start();
		}else {
			$user = $this->model->getUser();
			$ret = $this->profileView->showProfilePage($user);
		}
		return $ret;
	}
}
