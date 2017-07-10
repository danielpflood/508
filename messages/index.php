<?php include('../header.php'); ?>
    
    <?php
  	if(loggedIn()){
      include('../loggedin.php');
      listMessages();
      ?>
      <a href="/508/messages/new">New Message</a>
      <?php
    	
	}
	else{
		 header("Location: /508");
	}
	?>
<?php include('../footer.php');