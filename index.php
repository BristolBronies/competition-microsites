<?php 

$view = !empty($_GET["view"]) ? $_GET["view"] : "";

require_once("config/config.php");

if(!empty($view) && file_exists("views/" . $view . ".php")) {
	$identifier = $view; 
	require "views/" . $view . ".php";
}
else if($view == "") {
	$identifier = "form";
	require "views/form.php";
}
else {
	$identifier = "404";
	require "views/404.php";
}