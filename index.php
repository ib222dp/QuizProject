<?php

require_once("HTMLView.php");
require_once("src/controller/NavigationController.php");

session_start();

$HTMLView = new HTMLView();
$controller = new NavigationController();

//Anropar metod som returnerar det som ska visas i HTMLview:s body
$html = $controller->start();

//Anropar metod för att eka ut htmlBody
$HTMLView->echoHTML($html[0], $html[1]);
