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
<<<<<<< HEAD
=======
		$_SESSION['msg']="Must be logged in to access that page.";

>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
		 header("Location: /508");
	}
	?>
<?php include('../footer.php');