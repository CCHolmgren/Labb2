<?php

namespace Controller;

require_once("PageView.php");
require_once("Cookie.php");
require_once("Model.php");

Class Controller{
	private $Model;
	private $View;
	private $Cookie;

	public function __construct(){
	 $this->Model = new \Model\Model();
	 $this->View = new \View\PageView();
	 $this->Cookie = new \View\Cookie($this->View);


	}
	public function ifLogedIn(){
		if ($this->Model->userLoggedIn()){
			return true;
		}
		$TextDocument = $this->Model->getTextDocument();
		$saltedPassword = $this->Model->getSaltedPassword();
		if ($this->Cookie->checkIfUserInCookie($saltedPassword, $TextDocument)) {
			$this->Model->logInSession();
			return true;		
		}
		return false;
	}
	/*public function onLoadPage(){
		if (isset(var)) {
			# code...
		}*/
	
	public function getHTML(){

		if ($this->ifLogedIn()) {
			
			if ($this->View->onLogoutButtonClick()) {
					$this->Model->logOut();
					$this->Cookie->removeCookies();
					return $this->View->getFirstPage();
				}

			return $this->View->getSecondPage();
		}
		else{
				if ($this->View->onLoginButtonClick()) {
					$Username = $this->View->getUsername();
					$Password = $this->View->getPassword();
					$Checkbox = $this->View->getCheckbox();

					if ($this->Model->verifyUser($Password, $Username,
					 $Checkbox)) {
					 	if ($this->Model->getIfSetCookie()) {
					 		
					 		$this->Cookie->setCookie($Username, $this->Model->getSaltedPassword());

					 	}

						return $this->View->getSecondPage();
					}
					

				}


			return $this->View->getFirstPage();
			
		}
	}
}