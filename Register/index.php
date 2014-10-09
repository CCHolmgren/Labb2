<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2014-09-26
 * Time: 15:29
 */
session_start();
define("__ROOT__", "C:/Users/Chrille/Desktop/Labb2/Labb2");
require_once(__ROOT__."/controller/RegistrationController.php");
$controller = new \Controller\RegistrationController();
echo $controller->getHTML();