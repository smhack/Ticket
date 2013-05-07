<?php
include("config.php");

$title = $_POST["eventName"];
$startTime = $_POST["startDate"];
$endTime = $_POST["endDate"];
$location = $_POST["where"];
$description = $_POST["description"];

if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}

$query = $db->PREPARE("INSERT INTO Event ( title, startTime, endTime, location, description ) VALUES ( '$title' , '$startTime', '$endTime', '$location', '$description' )");
$query->execute();
header('Location: index.php?action=admin');
?>