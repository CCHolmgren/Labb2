<?php
session_start();

require_once("Controller.php");


$Controller = new \Controller\Controller();
echo $Controller->getHTML();
