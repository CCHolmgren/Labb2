<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2014-09-26
 * Time: 15:29
 */
session_start();

require_once("../controller/RegistrationController.php");
$controller = new \Controller\RegistrationController();
try {
    echo $controller->getHTML();
}
catch(Exception $e){
    echo "<pre>";
    print_r($e);
    echo "</pre>";
    echo "<pre>";
    var_export($e);
    echo "</pre>";
}
