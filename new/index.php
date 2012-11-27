<?php include_once('../func.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>508 - New Project</title>
  </head>
  <body>
    <?php include('../header.php'); ?>
  	<?php
  	if (loggedIn()){
      getAppMessage();
      ?>
      <h2>New Project</h2>
      <?php 
      include('form.php');
    	include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
	}
	else{
		include('../form.php');
	}
	?>
  </body> 
</html>