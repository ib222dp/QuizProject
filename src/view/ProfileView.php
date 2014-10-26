<?php

require_once("src/view/View.php");

class ProfileView extends View {
	private $model;
	private static $editProfile = "edit";
	private static $deleteAccount = "delete";
	
	//Konstruktor
	public function __construct(ProfileModel $model) {
		
		parent::__construct();
		
		$this->model = $model;
	}
	
	public function userClickedEditProfile () {
		if(array_key_exists(self::$editProfile, $_GET)) {
			return true;
		}else {
			return false;
		}
	}
	
	public function userClickedDeleteAccount () {
		if(array_key_exists(self::$deleteAccount, $_GET)) {
			return true;
		}else {
			return false;
		}
	}
	
	public function showProfilePage($user) {
		$content =			"<div id='content'>
								<div id='profileleft'>
								<h1>" . $this->model->getUserName() . "</h1>
									<div id='profiletable'>
										<table>
											<thead>
												<tr>
													<th>
													</th>
													<th>
													</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
												</tr>
											</tfoot>
											<tbody>
												<tr>
													<td>
														Förnamn
													</td>
													<td>"
														. $user->getFirstName() .
													"</td>
												</tr>
												<tr>
													<td>
														Efternamn
													</td>
													<td>"
														. $user->getLastName() .
													"</td>
												</tr>
												<tr>
													<td>
														Ålder
													</td>
													<td>"
														. $user->getAge() .
													"</td>
												</tr>
												<tr>
													<td>
														Hemort
													</td>
													<td>"
														. $user->getHomeTown() .
													"</td>
												</tr>
												<tr>
													<td>
														Sysselsättning
													</td>
													<td>"
														. $user->getOccupation() .
													"</td>
												</tr>
											</tbody>
										</table>
									 </div>
									<div id='profilebuttons'>
										<a href='index.php?" . self::$editProfile . "'>Redigera profil</a> 
										<a href='index.php?" . self::$deleteAccount . "'>Radera konto</a>
									</div>
								</div>
							</div>";
		return array($this->loginMenu, $content);
	}
}
