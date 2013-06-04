<?php
	/*This file is included in our ipn.php file.  When the payment is processed PayPal notifies us and gives the payees information.
	$payer_email is defined in ipn.php.  If you need help with the PayPal IPN see http://www.micahcarrick.com/paypal-ipn-with-php.html*/

	//Include the Ticket Config file
	include ('./ticket/config.php');
	
	//Include the QR Code library from http://phpqrcode.sourceforge.net/
	include ('./ticket/phpqrcode/qrlib.php');

	if($sqlTicketservertype = 'mysql'){
		$ticketdb = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
		$ticketAdddb = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
	}
	//Random string generation function
	function random_string()
	{
		$character_set_array = array();
		$character_set_array[] = array('count' => 10, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$character_set_array[] = array('count' => 10, 'characters' => '0123456789');
		$temp_array = array();
		foreach ($character_set_array as $character_set) {
			for ($i = 0; $i < $character_set['count']; $i++) {
				$temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
			}
		}
		shuffle($temp_array);
		return implode('', $temp_array);
	}

	//Get random string and make sure it is not a duplicate
	do
	{
		$ticketCode = random_string();
		$ticketCodequery = $ticketdb->PREPARE("SELECT uid FROM Tickets WHERE ticketCode = '$ticketCode';");
		$ticketCodequery->execute();
		$ticketCodecount = $ticketCodequery->rowCount();
	}
	while($ticketCodecount != '0');
	
	//Create the QR Code
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
        
    $filename = $PNG_TEMP_DIR.$ticketCode.'.png';
	$QRdata = 'http://ticket.smhack.org/?action=verify&code='.$ticketCode;
	$errorCorrectionLevel = 'L';
	$matrixPointSize = 4;
	
	QRcode::png($QRdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	
	$ticketCodesql = $ticketAdddb->PREPARE("INSERT INTO Tickets (ticketCode, email, firstName, lastName, txn, paymentDate, classID) VALUES ( '$ticketCode', '$payer_email', '$first_name', '$last_name', '$txn_id', '$payment_date', '$custom')");
	$ticketCodesql->execute();
	
	//Email the ticket to the purchaser
	$fileatt = "./ticket/temp/".$ticketCode.".png"; // Path to the file
	$fileatt_type = "image/png"; // File Type
	$fileatt_name = $ticketCode.".png"; // Filename that will be used for the file as the attachment

	$email_from = "smhack@smhack.org"; // Who the email is from
	$email_subject = "SMHack Class Ticket"; // The Subject of the email
	$email_message = "Thanks for signing up for the class.  Attached you should find your ticket.  Please present this ticket at the door.
	";

	$email_to = $payer_email; // Who the email is to

	$headers = "From: ".$email_from;

	$file = fopen($fileatt,'rb');
	$data = fread($file,filesize($fileatt));
	fclose($file);

	$semi_rand = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

	$headers .= "\nMIME-Version: 1.0\n" .
	"Content-Type: multipart/mixed;\n" .
	" boundary=\"{$mime_boundary}\"";

	$email_message .= "This is a multi-part message in MIME format.\n\n" .
	"--{$mime_boundary}\n" .
	"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
	"Content-Transfer-Encoding: 7bit\n\n" .
	$email_message .= "\n\n";

	$data = chunk_split(base64_encode($data));

	$email_message .= "--{$mime_boundary}\n" .
	"Content-Type: {$fileatt_type};\n" .
	" name=\"{$fileatt_name}\"\n" .
	//"Content-Disposition: attachment;\n" .
	//" filename=\"{$fileatt_name}\"\n" .
	"Content-Transfer-Encoding: base64\n\n" .
	$data .= "\n\n" .
	"--{$mime_boundary}--\n";

	$ok = @mail($email_to, $email_subject, $email_message, $headers);
?>