<?php

namespace Model;

Class Model {

	public static $errorMessage = 0;
	private $ifSetCookie = false;
	
	// Variabler för att undvika strängberoende
	private $salt = "Monster";
	private $SaltedPassword = "Password";
	private $TextDocument = "SaveCookie.txt";
	private $loggedInSession = "loggedIn";
	private $userClient = "UserClient";
	private $userBrowser = "UserBrowser";
	private $password = "Password";
	private $admin = "Admin";
	

	public function userLoggedIn(){
		
		if (isset($_SESSION[$this->loggedInSession])) {
			if($_SESSION[$this->userClient] ==  $_SERVER["REMOTE_ADDR"] && $_SESSION[$this->userBrowser] ==  $_SERVER["HTTP_USER_AGENT"]){
				return true;
			
			}
		}
		return false;
		
	}
	public function getIfSetCookie(){
		return $this->ifSetCookie;
	}
	public function logInSession($Checkbox = null){
		if ($Checkbox) {
			$this->ifSetCookie = true;

			self::$errorMessage=5;
		}
		else {
			self::$errorMessage=4;
		}
			file_put_contents($this->TextDocument, time()+36);			
			$_SESSION[$this->userClient] =  $_SERVER["REMOTE_ADDR"];
			$_SESSION[$this->userBrowser] =  $_SERVER["HTTP_USER_AGENT"];
		
		$_SESSION[$this->loggedInSession] = true;
	}



	public function verifyUser($Password, $Username, $Checkbox){
		$Password = crypt($Password, $this->salt);
		if ($Username == "") {
			self::$errorMessage=1;
		}
		else if ($Password == "") {
			self::$errorMessage=2;
		}
		else if ($Password == crypt($this->password, $this->salt) && $Username == $this->admin) {
			$this->logInSession($Checkbox);
			$this->SaltedPassword = $Password;
			return true;
		}
		else {
			self::$errorMessage=3;
		}
		return false;
	}
	public function getSaltedPassword(){
		return $this->SaltedPassword;
	}
	public function getTextDocument() {
		return $this->TextDocument;
	}
	public function logOut() {
		
		self::$errorMessage=6;
		
		
		unset($_SESSION[$this->loggedInSession]);

	}

}