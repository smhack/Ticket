<script>
	$(document).ready(function(){
		$("#loginForm").validate();
	});
</script>
<fieldset>
	<legend>Login</legend>
	<?php
	if(isset($_GET["error"])){
		$error = $_GET["error"];
		if($error == '1'){
			echo "<p>Please try again.  The username/password you entered is not correct.</p>";
		}
		if($error == '2'){
			echo "<p>Please contact an Admin.</p>";
		}
	}
	?>
	<form class="login" id="loginForm" method="post" action="processlogin.php">
	<p>
		<label for="loginName">Username</label>
		<input id="loginName" name="loginName" type="text" class="required" />
	</p>
	<p>
		<label for="loginPassword">Password</label>
		<input id="loginPassword" name="loginPassword" type="password" class="required" />
	</p>
	<p>
		<input class="submit" type="submit" value="Submit" />
	</p>
	</form>
</fieldset>