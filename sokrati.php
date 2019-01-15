<?php 

error_reporting(-1);
require_once('db.php');
require_once('functions.php');

$sql = 'SELECT * FROM links';

$query = $pdo->query($sql);
$result = $query->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP, 1);

$emptyUrl = true;

$i = 1;

$newUrl = '';

while($emptyUrl != false) {
	$sokrat = generateRandomString($i);
	if (array_key_exists($sokrat, $result)) {
		$i++;
	}
	else {
		$emptyUrl = false;
		
		$newLink = "INSERT INTO links (`url`, `full_url`) VALUES(:url, :full_url)";
		$queryNewLink = $pdo->prepare($newLink);
		$queryNewLink->bindValue(':url', $sokrat, PDO::PARAM_STR);
		$queryNewLink->bindValue(':full_url', $_GET['text'], PDO::PARAM_STR);
		$queryNewLink->execute();
		
		$newUrl = $sokrat;
		
	}
}

echo 'http://' . $_SERVER['SERVER_NAME'] . '/' . $newUrl;


