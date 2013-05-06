<?php

include("config.php"); 
include("loggedin.php");

require_once('PasswordHash.php'); // include the PHPass framework
$hasher = new PasswordHash(8, TRUE); // initialize the PHPass class

if($sqlServerType = 'mysql'){
	$db = new PDO('mysql:host='.$sqlServer.';dbname='.$sqlDBname, $sqlUsername, $sqlPassword);
}

$username = $_POST["loginName"];
$password = $_POST["loginPassword"];

if($username && $password){
	global $hasher;
	$query = $db->PREPARE("SELECT password FROM users WHERE username = '$username';");
	$query->execute();
	$result = $query->fetch();
	$numRows = $query->rowCount();
	if($numRows < 1){
		header('Location: index.php?error=1'); //user does not exist
		die();
	}
	
	if (!$hasher->CheckPassword($password, $result['password'])) {
				
		header('Location: index.php?error=1'); //password does not match
		die();
	} else {
		$query = $db->PREPARE("SELECT id, username, admin FROM users WHERE username = '$username';");
		$query->execute();
		$result = $query->fetch();
		$userid = $result['id'];
		$username = $result['username'];
		$admin = $result['admin'];
		validateUser($username,$userid,$admin);
		header('Location: index.php?action=admin');
	}
}

unset($hasher);

?>