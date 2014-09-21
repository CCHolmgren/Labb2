<?php
session_start();

require_once("/controller/Controller.php");


$Controller = new \Controller\Controller();
echo $Controller->getHTML();
