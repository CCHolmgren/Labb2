<?php

namespace View;

require_once("DateTimeView.php");

Class PageView{

	private $errorMessage;
	//variabler för att undvika strängberoende YOLO!
	private $username = "username";
	private $password = "password";
	private $logInButton = "logInButton";
	private $logOutButton = "logOutButton";
	private $checkBox = "LoginView::Checked";
	


	public function __construct(){
		$this->timeString = new \View\DateTime();
	}
	

	public function setErrorMessage($errorMessage){
		$this->$errorMessage = $errorMessage;
	}

	private function getErrorMessage(){

		$number = \Model\Model::$errorMessage;
		if($number != NULL){
			$errorMessage = "";
			
			switch ($number) {
				case 1:
					$this->errorMessage = "Måste skriva in användarnamn.";
					break;
				case 2:
					$this->errorMessage = "Måste skriva in Lösenord.";
					break;
				case 3:
					$this->errorMessage = "Fel Lösenord/Användarnamn.";
					break;
				case 4:
					$this->errorMessage = "Du är nu inloggad";
					break;
				case 5:
					$this->errorMessage = "Du är nu inloggad och vi kommer ihåg dig";
					break;
				case 6:
					$this->errorMessage = "Du har nu loggat ut";
					break;
					case 7:
					$this->errorMessage = "Du har nu loggat in med cookie";
					break;

				default:
					# code...
					break;
			}
		}
		return $this->errorMessage;
	}

	public function getFirstPage(){
		$username = "";
		$timeValue = $this->timeString->getTime();

		//om user posted username, set it as value in input
		if (isset($_POST[$this->username])) {
			$username = $_POST[$this->username]; 
		}
		$HTML ='
		<html>
			<header>
				<title>Admin</title>
					<meta http-equiv="content-type" content="text/html" charset="utf-8">
			</header>

				<body>
					<form id="LogIn" name="LogIn" method="post" action="?login">
						Användarnamn:
						<input name="username" type="text" value="' . $username . '" id="username" size="40"/>
						Lösenord:
						<input name="password" type="password" id="password" size="40"/>
						<input type ="submit" name="logInButton" id="button" value="Logga in">
						<label for="AutologinID" >Håll mig inloggad  :</label>
						<input type="checkbox" name="LoginView::Checked" id="AutologinID" />
						'.$this->getErrorMessage().''.$timeValue.'
										
					</form>
				</body>
		</html>';

		return $HTML;
	}

	public function getSecondPage(){
		$HTML2 ='<html>
					<head>
						<h1>Admin</h1>
						<title>Admin</title>
						'.$this->getErrorMessage().'
						<meta http-equiv="content-type" content="text/html"; charset="utf-8">
						<form action = "?logOut" method = "post"> 
						<input type ="submit" name="logOutButton" id="button" value="Log Out">
						
						</form>
					</head>
				</html>';

		return $HTML2;
	}

	public function onLoginButtonClick(){
		if(isset($_POST[$this->logInButton])){
			return true;

		}
		return false;
	}
	public function onLogoutButtonClick(){
		if(isset($_POST[$this->logOutButton])){
			return true;

		}
		return false;
	}


	public function getPassword(){
		if (isset($_POST[$this->password])) {
		
			return $_POST[$this->password];
		}
	
	}

	public function getUsername(){
		if(isset($_POST[$this->username])){
			return $_POST[$this->username];
		}
	}

	public function getCheckbox(){
	if(isset($_POST[$this->checkBox])){
		return true;

	}
	return false;
}
}