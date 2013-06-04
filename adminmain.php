<center><table width="75%" >
<tr>
<th>Event</th>
<th>Attendees</th>
</tr>
<?php 
if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}

$query = $db->PREPARE("SELECT title,attendeeCount,uid FROM Event WHERE isActive = '1';");
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);

while($row = $query->fetch()){
	echo "<tr><td><a href=index.php?action=editevent&id=".$row['uid'].">".$row['title']."</a></td><td>".$row['attendeeCount']."</td></tr>";
}
?>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><a href="index.php?action=addEvent">Add event</a><br/></td></tr>
</table></center>


