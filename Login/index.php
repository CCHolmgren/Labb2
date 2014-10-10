<?php
session_start();
define("__ROOT__", "C:/Users/Chrille/Desktop/Labb2/Labb2");
require_once(__ROOT__."/controller/Controller.php");

$Controller = new \Controller\Controller();
echo $Controller->getHTML();
