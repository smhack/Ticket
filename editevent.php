<link rel="stylesheet" href="/css/jquery-ui-timepicker-addon.css" />
<script>
	$(document).ready(function(){
		$( "#addEvent" ).validate();
		
		var startDateTextBox = $("#startDate");
var endDateTextBox = $("#endDate");

startDateTextBox.datetimepicker({ 
	onClose: function(dateText, inst) {
		if (endDateTextBox.val() != '') {
			var testStartDate = startDateTextBox.datetimepicker('getDate');
			var testEndDate = endDateTextBox.datetimepicker('getDate');
			if (testStartDate > testEndDate)
				endDateTextBox.datetimepicker('setDate', testStartDate);
		}
		else {
			endDateTextBox.val(dateText);
		}
	},
	onSelect: function (selectedDateTime){
		endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
	}
});
endDateTextBox.datetimepicker({ 
	onClose: function(dateText, inst) {
		if (startDateTextBox.val() != '') {
			var testStartDate = startDateTextBox.datetimepicker('getDate');
			var testEndDate = endDateTextBox.datetimepicker('getDate');
			if (testStartDate > testEndDate)
				startDateTextBox.datetimepicker('setDate', testEndDate);
		}
		else {
			startDateTextBox.val(dateText);
		}
	},
	onSelect: function (selectedDateTime){
		startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
	}
});
	});
	
</script>


<fieldset>
	<legend>Edit Event</legend>
	<form class="login" id="addEvent" method="post" action="editeventaction.php">
	
<?php

if(isset($_GET['id'])){
	$id = $_GET['id'];
}

if($sqlTicketservertype = 'mysql'){
	$db = new PDO('mysql:host='.$sqlTicketserver.';dbname='.$sqlTicketdbname, $sqlTicketusername, $sqlTicketpassword);
}

$query = $db->PREPARE("SELECT title,startTime,endTime,location,description, agenda, aboutTeacher FROM Event WHERE uid = '$id';");
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);

while($row = $query->fetch()){
	echo "<input type=hidden name=id value=".$id.">";
	echo "<p>
		<label for=eventName>Event Name</label>
		<input id=eventName name=eventName type=text class=required value='".$row['title']."' style='width:400px;' />
	</p>";
	echo "<p>
		<label for=startDate>Start Time</label>
		<input id=startDate name=startDate type=text class=required value='".$row['startTime']."' />
	</p>";
	
	echo "<p>
		<label for=endDate>End Time</label>
		<input id=endDate name=endDate type=text class=required value='".$row['endTime']."' />
	</p>";
	
	echo "<p>
		<label for=where>Where</label>
		<input id=where name=where type=text class=required value='".$row['location']."' style='width:400px;' />
	</p>";
	
	echo "<p>
		<label for=description>Description</label>
		<textarea id=description name=description class=required style='margin: 2px;width:400px;height:130px;'>".$row['description']."</textarea>
	</p>";
	echo "<p>
		<label for=agenda>Agenda</label>
		<textarea id=agenda name=agenda class=required style='margin: 2px;width:400px;height:130px;'>".$row['agenda']."</textarea>
	</p>";
	echo "<p>
		<label for=aboutYou>About You</label>
		<textarea id=aboutYou name=aboutYou class=required style='margin: 2px;width:400px;height:130px;'>".$row['aboutTeacher']."</textarea>
	</p>";
}
?>

	<p>
		<input class="submit" type="submit" value="Submit" />
	</p>
	</form>
	
	<p>External URL for this class is: http://ticket.smhack.org/index.php?action=event&id=<?php echo $id;?></p>
</fieldset>