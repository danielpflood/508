<form name="login" method="post" action="login.php">
<input name="username" type="text" id="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']);?>">
<br />
<input name="pass" type="password" id="pass" placeholder="Password" >
<input name="login" type="submit" id="login" value="login">
<br />
<a href="/508/register">Register Here</a>
</form>