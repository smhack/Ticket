<?php
	include('head.php');

	switch($action){
		default:
			include('main.php');
			break;
		case 'admin':
			include('enforcelogon.php');
			include('adminmain.php');
			break;
		case 'addEvent':
			include('enforcelogon.php');
			include('addevent.php');
			break;
		case 'editevent':
			include('enforcelogon.php');
			include('editevent.php');
			break;
		case 'verify':
			include('verifyticket.php');
			break;
		case 'event':
			include('event.php');
			break;
	}


	include('foot.php');
?>


