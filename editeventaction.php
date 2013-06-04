<?php
include("config.php");

$id = $_POST["id"];
$title = $_POST["eventName"];
$startTime = $_POST["startDate"];
$endTime = $_POST["endDate"];
$location = $_POST["where"];
$description = $_POST["description"];
$agenda = $_POST["agenda"];
$aboutYou = $_POST["aboutYou"];

if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}
$sql = "UPDATE Event SET title = ?, startTime = ?, endTime = ?, location = ?, description = ?, agenda = ?, aboutTeacher= ? WHERE uid = '".$id."'";
$query = $db->PREPARE($sql);
$query->execute(array($title,$startTime,$endTime,$location,$description,$agenda,$aboutYou));
header('Location: index.php?action=admin');
?>


