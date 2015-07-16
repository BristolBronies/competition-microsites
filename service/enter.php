<?php

require_once("../config/config.php");

$data = !empty($_POST) ? $_POST : false;
header("Content-Type: application/json");

function dataService($content) {
	global $connection;
	try {
		$query = $connection->prepare("INSERT INTO entrants(name, email, ip, competition) VALUES (:name, :email, :ip, :competition)");
		$query->execute(array(
			"name" => $content[0][1],
			"email" => $content[1][1],
			"ip" => $content[3][1],
			"competition" => COMPETITION_ID
		));
		return true;
	}
	catch(PDOException $e) {
		return false;
	}
}

if($data) {
	$errors = false;
	$return = array();
	$content = array(
		array("name", $_POST["name"], true),
		array("email", $_POST["email"], true),
		array("terms", $_POST["terms"], true),
		array("ip", clientIp())
	);
	foreach($content as $item) {
		if($item[2] === true && empty($item[1])) {
			$errors = true;
			$return[] = array($item[0], "required");
		}
		if($item[0] === "email" && !empty($item[1])) {
			if(!filter_var($item[1], FILTER_VALIDATE_EMAIL)) {
				$errors = true;
				$return[] = array($item[0], "invalidformat");
			}
			$testEmail = $connection->prepare("SELECT * FROM entrants WHERE email = :email AND competition = :competition LIMIT 1");
			$testEmail->execute(array("email" => $item[1], "competition" => COMPETITION_ID));
			if(count($testEmail->fetchAll()) > 0) {
				$errors = true;
				$return[] = array("form", "alreadyentered");
			}
		}
		if($item[0] === "ip" || $item[0] === "email") {
			$testIp = $connection->prepare("SELECT * FROM entrants WHERE ip = :ip AND competition = :competition LIMIT 1");
			$testIp->execute(array("ip" => $item[1], "competition" => COMPETITION_ID));
			if(count($testIp->fetchAll()) > 0) {
				$errors = true;
				$return[] = array("form", "alreadyentered");
			}
		}
	}
	if($errors) {
		$errors = array(
			"error" => 1,
			"fields" => $return
		);
		$return = $errors;
	}
	else {
		if(dataService($content)) {
			$return = array("success" => 1);
		}
		else {
			$return = array("error" => 1, "fields" => array("form" => "savefail"));
		}
	}
}
else {
	$return = array("error" => 1, "fields" => array("form" => "nodata"));
}

echo json_encode($return);