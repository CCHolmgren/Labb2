<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2014-09-25
 * Time: 16:20
 */
namespace Controller;
require_once("../view/RegistrationView.php");
require_once("../model/Model.php");

class RegistrationController {
    private $view;
    private $model;

    public function __construct(){
        //$this->model = new \Model\Model();
        $this->view = new \View\RegistrationView();//$this->model);
    }
    public function getHTML(){
        //Registered
        $message = "";
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            try {
                $this->model = new \Model\Model($this->view->getUsername(), $this->view->getPassword(), $this->view->getRepeatedPassword());
                $this->model->validatePost("<br />");
                $this->model->addUser();
                header("Location: " . "/Labb2/Login/" . "?username=" . urlencode($this->model->username) . "&message=".urlencode("Registrering av ny användare lyckades"));
                exit;
            }catch(\Exception $e){
                $message = $e->getMessage();
            }
        }
        return $this->view->getRegistrationForm($message,@$this->model->username);
    }

}