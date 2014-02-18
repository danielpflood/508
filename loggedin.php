<div id="loggedinbox">
  	<?php 
  	echo '<a href="/508/users/'.htmlspecialchars($_SESSION['username']).'">'; 
  	echo htmlspecialchars($_SESSION['username']).'</a>' ?>
  	<a href="/508/messages/" > Messages</a>
  	<a href="/508/projects/"> Projects</a>
  	<a href="/508/users/"> Users</a>
  	<a href="/508/logout.php"> Logout</a> 
  </div>
