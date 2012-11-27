<form name="login" method="post" action="login.php">
email<input name="email" type="text" id="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']);?>">
<br />
password<input name="pass" type="password" id="pass" >
<input name="login" type="submit" id="login" value="login">
<br />
<a href="/508/register">Register Here</a>
</form>