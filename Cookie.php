<?php

namespace View;

require_once("PageView.php");
Class Cookie{
	private $View;
	

	private static $Username = "Username"
					, $Password = "Password";
	public function __construct($View){
		$this->View = $View;
	}					
	public function setCookie($Username, $Password){
		$time = time()+36;
		setcookie(self::$Username, $Username, $time);
		setcookie(self::$Password, $Password, $time);

	}

	/**
	* Checks if username and password exists in cookie
	*/
	public function checkIfUserInCookie($InPassword, 
										$TextDocument){
		if (filter_input(INPUT_COOKIE, self::$Username) !== null &&
		 filter_input(INPUT_COOKIE, self::$Password) !== null) {

			if ($_COOKIE[self::$Username] == "Admin" && $_COOKIE[self::$Password]=$InPassword) {
				if (file_get_contents($TextDocument)>= time()) {
					$this->View->setErrorMessage("Inlogning med Cookie lyckades");
					return true;		
				}
			}
				$this->View->setErrorMessage("Ogiltig information i Cookie");
		}	
		return false;
		
	}

	public function getUsernameFromCookie(){
		return filter_input(INPUT_COOKIE, self::$Username);
	}
	public function getPasswordFromCookie(){
		return filter_input(INPUT_COOKIE, self::$Password);
	}

	public function removeCookies(){
		if(isset($_COOKIE[self::$Username])){
			setcookie(self::$Username, "", time()-9001);
  			unset($_COOKIE[self::$Username]);

  		}

  		if(isset($_COOKIE[self::$Password])){ 
  			setcookie(self::$Password, "", time()-9001);
  			unset($_COOKIE[self::$Password]);
  		}
  		setcookie('key', '', time() - 3600); // empty value and old timestamp
  	}	
}

