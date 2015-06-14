<?php 
	require "partials/_html-header.php";
	require "partials/_header.php";
	$alreadyEntered = false;
	$testIp = $connection->prepare("SELECT * FROM entrants WHERE ip = :ip AND competition = :competition LIMIT 1");
	$testIp->execute(array("ip" => clientIp(), "competition" => COMPETITION_ID));
	$rows = $testIp->fetchAll();
	if(count($rows) > 0) {
		$alreadyEntered = true;
	}
?>

<?php 
	require "partials/_footer.php";
	require "partials/_html-footer.php";
?>