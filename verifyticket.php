<?php
	//Get code from QR url
	if(isset($_GET['code'])){
		$ticketCode = $_GET['code'];
		if($sqlTicketservertype = 'mysql'){
			$ticketdb = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
			$eventdb = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
			$useticketdb = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
		}
	
		// Check to see if the ticket code is valid
		$ticketCodequery = $ticketdb->PREPARE("SELECT uid, redeemed, classID FROM Tickets WHERE ticketCode = '$ticketCode';");
		$ticketCodequery->execute();
		$ticketCoderesult = $ticketCodequery->fetch();
		$ticketCodecount = $ticketCodequery->rowCount();
		if($ticketCodecount != '0'){
			// Good Ticket Code now we check to see if it has been used
			$redeemed = $ticketCoderesult['redeemed'];
			$classID = $ticketCoderesult['classID'];
			
			if($redeemed == 'yes'){
				// Ticket has been used
				echo "<p>Ticket has been redeemed before.</p>";
			} else {
				// Ticket has not been used
				$eventquery = $eventdb->PREPARE("SELECT title FROM Event WHERE uid = '$classID';");
				$eventquery->execute();
				$eventresult = $eventquery->fetch();
				
				$title = $eventresult['title'];
				echo "<p>Good Ticket for ".$title."</p>";
				
				// Mark ticket as been used
				$ticketUpdatesql = "UPDATE Tickets SET redeemed= ? WHERE ticketCode = '".$ticketCode."'";
				$ticketUpdatequery = $useticketdb->PREPARE($ticketUpdatesql);
				$ticketUpdatequery->execute(array('yes'));
			}
		} else {
			// Can't find a record of provided ticket code
			echo "<p>No Such Ticket</p>";
		}
	} else {
		// No ticket provided through URL
		echo "<p>No Ticket Code specified!</p>";
	}
	
?>