<?php

include('ipnlistener.php');
include("config.php"); 

if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}
// tell PHP to log errors to ipn_errors.log in this directory
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

$listener = new IpnListener();
$listener->use_sandbox = true;

try {
    $verified = $listener->processIpn();
} catch (Exception $e) {
    // fatal error trying to process IPN.
	error_log($e->getMessage());
    exit(0);
}

if ($verified) {
    // IPN response was "VERIFIED"
	
	$email = $_POST['payer_email'];
	$txn = $_POST['txn_id'];
	$firstName = $_POST['first_name']; 
	$lastName = $_POST['last_name'];
	$paymentDate = $_POST['payment_date'];

	$query = $db->PREPARE("INSERT INTO Tickets ( email, txn, firstName, lastName, paymentDate  ) VALUES ( '$email', '$txn', '$firstName', '$lastName', '$paymentDate'  )");
	$query->execute();
			
	mail('smhack@smhack.org', 'Valid IPN', $listener->getTextReport());
} else {
    // IPN response was "INVALID"
	mail('smhack@smhack.org', 'Invalid IPN', $listener->getTextReport());
}
	
?>