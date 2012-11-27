<?php include_once('func.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>508</title>
  </head>
  <body>
  	<?php include('header.php'); ?>
    <?php getAppMessage(); ?>
    <?php
  	if(loggedIn()){
      listProjects();
      ?>
      <a href="/508/new">Create Project</a>
      <?php
    	include('loggedin.php');
	}
	else{
		include('form.php');
	}
	?>
  </body> 
</html>