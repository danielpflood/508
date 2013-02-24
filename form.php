<form name="login" method="post" action="login.php">
username<input name="username" type="text" id="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']);?>">
<br />
password<input name="pass" type="password" id="pass" >
<input name="login" type="submit" id="login" value="login">
<br />
<a href="/508/register">Register Here</a>
</form>