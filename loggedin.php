<div align="right" style="position:fixed; top:0px; right:0px;">
  	 <?php echo htmlspecialchars($_SESSION['email']) ?><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($_SESSION['email']))); ?>?s=32" width="32" height="32" style="padding-left:10px;" />
  	<br /><a href="#" style="color:grey; text-decoration: none; padding-right:10px;"> Messages</a><a href="/508/logout.php" style="color:grey; text-decoration: none;"> Logout</a> 
  </div>
