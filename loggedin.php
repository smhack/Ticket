<?php
function validateUser($arg1, $arg2, $arg3) {
	session_start();
	session_regenerate_id();
	session_register("valid");
	session_register("username");
	session_register("userid");
	session_register("isAdmin");
	$_SESSION["valid"] = 1;
	$_SESSION["username"] = $arg1;
	$_SESSION["userid"] = $arg2;
	$_SESSION["isAdmin"] = $arg3;
	session_write_close(); 
}

function isLoggedIn() {
	session_start();
	if(isset($_SESSION["valid"]) && $_SESSION["valid"]){
		return true;		
	} else {
		return false;		
	}
}

function logout() {
	session_start();
	session_unregister("valid");
	session_unregister("username");
	session_unregister("userid");
	session_unregister("isAdmin");
	$_SESSION = array(); //destroy all of the session variables
	session_destroy();
	header('Location: index.php');
}
?>