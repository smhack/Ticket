<?php
$action = '';
//If action is passed through url assign it to the action variable
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

//If action is passed through a form assign it to the action variable
if(isset($_POST['action'])){
	$action = $_POST['action'];
}

?>