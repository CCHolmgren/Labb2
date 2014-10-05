<?php

namespace Model;

require_once("DatabaseConnection.php");

Class Model extends Database {

	public static $errorMessage = 0;
	private $ifSetCookie = false;
	
	// Variabler för att undvika strängberoende
	private $salt = "Monster";
	private $SaltedPassword = "Password";
	private $TextDocument = "SaveCookie.txt";
	private $loggedInSession = "loggedIn";
	private $userClient = "UserClient";
	private $userBrowser = "UserBrowser";
	private $password;// = "Password";
	private $admin;// = "Admin";
    private $username;
    private $passwordCorrect;
    private $repeatedPassword;

    public function __construct($username = "", $password = "", $repeatedpassword = ""){
        $this->username = $username;
        $this->password = $password;
        $this->repeatedPassword = $repeatedpassword;
    }
    public function addUser(){
        if($this->usernameExistsInDataBase($this->username)){
            throw new \Exception("Användarnamnet är redan upptaget.");
        }
        try {
            $connection = $this->getConnection();
            $sth = $connection->prepare("INSERT INTO users (username, password) VALUES(?,?)");
            $sth->execute(array($this->username, $this->password));
        }
        catch(\Exception $e){
            throw $e;
        }

    }
    public function validatePost($glue = "\n"){

        $errors = array();

        if(mb_strlen($this->username) < 3){
            $errors[] = "Användarnamnet har för få tecken. Minst 3 tecken.";
        }
        if(mb_strlen($this->password) < 6 ||mb_strlen($this->repeatedPassword)<6){
            $errors[] = "Lösenorden har för få tecken. Minst 6 tecken.";
        }
        if($this->password !== $this->repeatedPassword){
            $errors[] = "Lösenorden matchar inte.";
        }
        $errors_string = implode($glue, $errors);
        if($errors){
            throw new \Exception($errors_string);
        }
        return;

    }
    private function usernameExistsInDataBase($username){
        try {
            $connection = $this->getConnection();
            $sth = $connection->prepare("SELECT * FROM users WHERE username = ?");
            $sth->execute(array($username));//password_hash($password, PASSWORD_DEFAULT)));
            $rows = $sth->fetch(\PDO::FETCH_COLUMN);
            if($rows!=="0"){
                return true;
            }
            return false;
        }
        catch(\Exception $e){
            throw $e;
        }
    }
    private function userExistsInDataBase($username, $password){
        try {
            $connection = $this->getConnection();
            $sth = $connection->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $sth->execute(array($username, $password));//password_hash($password, PASSWORD_DEFAULT)));
            $rows = $sth->fetch(\PDO::FETCH_NUM);
            if($rows){
                return true;
            }
            return false;
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function getUsers(){
        try{
            $connection = $this->getConnection();
            $sth = $connection->query("SELECT * FROM users");
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            echo "</pre>";

            return $result;
        }
        catch(\Exception $e){
            throw new \Exception($e);
        }
    }

	public function userLoggedIn(){
		
		if (isset($_SESSION[$this->loggedInSession]) && $_SESSION[$this->userClient] ===  $_SERVER["REMOTE_ADDR"] && $_SESSION[$this->userBrowser] ===  $_SERVER["HTTP_USER_AGENT"]) {
            return true;
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



	private function verifyUser($password, $username, $Checkbox){
        var_dump($this->userExistsInDataBase($username, $password));
        return $this->userExistsInDataBase($username, $password);

		$password = crypt($password, $this->salt);
		if ($username == "") {
			self::$errorMessage=1;
		}
		else if ($password == "") {
			self::$errorMessage=2;
		}
		else if ($password == crypt($this->password, $this->salt) && $username == $this->admin) {
			$this->logInSession($Checkbox);
			$this->SaltedPassword = $password;
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