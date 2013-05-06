<?php
include 'loggedin.php';

if(!isloggedin()){
	header('Location: login.php');
	die();
}
?>