<<<<<<< HEAD
<div align="right" style="position:fixed; top:0px; right:0px; background-color:#fff;">
  	 <?php echo htmlspecialchars($_SESSION['email']) ?><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($_SESSION['email']))); ?>?s=32" width="32" height="32" style="padding-left:10px;" />
  	<br />
  	<a href="/508/messages/" style="color:grey; text-decoration: none; padding-right:10px;"> Messages</a>
  	<a href="/508/projects/" style="color:grey; text-decoration: none; padding-right:10px;"> Projects</a>
  	<a href="/508/logout.php" style="color:grey; text-decoration: none;"> Logout</a> 
=======
<div id="loggedinbox">
  	<?php 
  	echo '<a href="/508/users/'.htmlspecialchars($_SESSION['username']).'">'; 
  	echo htmlspecialchars($_SESSION['username']).'</a>' ?>
  	<a href="/508/messages/" > Messages</a>
  	<a href="/508/projects/"> Projects</a>
  	<a href="/508/users/"> Users</a>
  	<a href="/508/logout.php"> Logout</a> 
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
  </div>
