<?php if(isset($_GET['id'])){
	$id = $_GET['id'];
}

if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}

$query = $db->PREPARE("SELECT title,startTime,endTime,location,description,agenda,aboutTeacher FROM Event WHERE uid = '$id';");
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);

while($row = $query->fetch()){
$classTitle=$row['title'];
echo "<h2>".$row['title']."</h2>";
echo "<p><b>Description:</b> ".$row['description']."</p>";
echo "<p>Class will be held on ".$row['startTime']." until ".$row['endTime']." at ".$row['location']."</p>";
echo "<p><b>Agenda:</b> ".$row['agenda']."</p>";
echo "<p><b>About the Teacher: ".$row['aboutTeacher']."</p>";


}
?>

<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="finance@smhack.org">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="<?php echo $classTitle;?>">
<input type="hidden" name="item_number" value="Class">
<input type="hidden" name="custom" value="<?php echo $id;?>">
<input type="hidden" name="amount" value="20.00">
<input type="hidden" name="return" value="http://www.smhack.org">
<input type="hidden" name="notify_url" value="http://www.smhack.org/ipn.php">
<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
