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
	<legend>Add Event</legend>
	<form class="login" id="addEvent" method="post" action="addeventaction.php">
	<p>
		<label for="eventName">Event Name</label>
		<input id="eventName" name="eventName" type="text" class="required" />
	</p>
	<p>
		<label for="startDate">Start Time</label>
		<input id="startDate" name="startDate" type="text" class="required" />
	</p>
	<p>
		<label for="endDate">End Time</label>
		<input id="endDate" name="endDate" type="text" class="required" />
	</p>
	<p>
		<label for="where">Where</label>
		<input id="where" name="where" type="text" class="required" />
	</p>
	<p>
		<label for="description">Description</label>
		<textarea id="description" name="description" class="required"></textarea>
	</p>
	
	<p>
		<input class="submit" type="submit" value="Submit" />
	</p>
	</form>
</fieldset>