<?php include('../header.php'); ?>
<h3>Register:</h3>
<form id="reg" name="reg" method="post" action="register.php">
	First Name: <input name="first_name" type="text" id="first_name" value="" size="42" /><br />
	Last Name: <input name="last_name" type="text" id="last_name" value="" size="42" /><br />
*Username: <input name="username" type="text" id="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']);?>" size="42" /><br />
*Password: <input name="password" type="password" id="password" size="42" />
<input name="register" type="submit" id="register" value="register" />
</form>