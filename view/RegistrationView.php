<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2014-09-25
 * Time: 16:20
 */
namespace View;
require_once("../model/Model.php");
require_once("DateTimeView.php");

class UsernameMissingException extends \Exception{}
class PasswordMissingException extends \Exception{}
class InvalidPasswordMatchException extends \Exception{}

class RegistrationView{
    private $model;
    private $timeString;

    public function __construct(){//\Model\Model $model){
        //$this->model = $model;
        $this->timeString = new \View\DateTime();

    }
    public function addModel(\Model\Model $model){
        $this->model = $model;
    }
    public function getUsername(){
        if(!empty($_POST["Username"]))
            return $_POST["Username"];
        return false;
    }
    public function getPassword(){
        if(!empty($_POST["Password"]))
            return $_POST["Password"];
        return false;
    }
    public function getRepeatedPassword(){
        if(!empty($_POST["Repeat"]))
            return $_POST["Repeat"];

        return false;
    }

    public function getRegistrationForm($message,$username=null){
        $html = "
                <!DOCTYPE html>
                <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <title>Register</title>
                    </head>
                    <body>
                    <a href='../Login/'>Login</a>
                    <a href='../'>Base</a>
                        $message
                        <form method='post'>
                                <label for='Username'>Username</label>
                                <input type='text' name='Username'";
        if($username){
            $html.="value='".$username."'";
        }
        $html.=">
                                <label for='Password'>Password</label>
                                <input type='password' name='Password'>
                                <label for='Repeat'>Repeat password</label>
                                <input type='password' name='Repeat'>
                                <input type='Submit' value='Submit'>
                        </form>
                        {$this->timeString->getTime()}
                    </body>
                </html>
            ";
        return $html;
    }
}